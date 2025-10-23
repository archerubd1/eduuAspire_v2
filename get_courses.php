<?php
// -----------------------------------------------------------------------------
// EduuAspire Marketplace – K12 Dynamic Course Loader (Safe Debug Mode)
// -----------------------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('config.php');

// ---- CONFIG -----------------------------------------------------------------
$debug = true; // ✅ Turn to false when you go live

function normalize($key, $default = '') {
    return isset($_POST[$key]) ? trim(strtolower($_POST[$key])) : $default;
}

$board      = normalize('board');
$class      = normalize('class');
$mode       = normalize('mode');
$assessment = normalize('assessment');
$search     = normalize('search');
$sort       = normalize('sort', 'popular');

// ---- Base Query -------------------------------------------------------------
$query = "SELECT id, name, info, board, course_mode, learners, rating, reviews, assessment_type
          FROM lessons
          WHERE active=1 AND publish=1
          AND board IN ('CBSE','ICSE','Goa Board')";

$params = array();
$types  = '';

// ---- Filters ----------------------------------------------------------------
if ($board && $board != 'all' && $board != 'all boards') {
    $query .= " AND LOWER(board) = ?";
    $params[] = $board;
    $types .= 's';
}

// Class filter – using REGEXP for exact match like “Class V” only
if ($class && $class != 'all' && $class != 'all classes') {
    $class_num = trim(str_ireplace('class ', '', $class));
    // This avoids matching VIII when searching for V
    $query .= " AND LOWER(name) REGEXP ?";
    $params[] = '(^|[^a-z0-9])class[[:space:]]*' . $class_num . '([^a-z0-9]|$)';
    $types .= 's';
}

if ($mode && $mode != 'all' && $mode != 'all modes') {
    $query .= " AND LOWER(course_mode) = ?";
    $params[] = $mode;
    $types .= 's';
}

if ($assessment && $assessment != 'all' && $assessment != 'all types') {
    $query .= " AND LOWER(assessment_type) = ?";
    $params[] = $assessment;
    $types .= 's';
}

if ($search != '') {
    $query .= " AND (LOWER(name) LIKE ? OR LOWER(info) LIKE ?)";
    $like = "%".$search."%";
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

// ---- Sorting ----------------------------------------------------------------
switch ($sort) {
    case 'newest': $query .= " ORDER BY created DESC"; break;
    case 'rating': $query .= " ORDER BY rating DESC"; break;
    default:       $query .= " ORDER BY learners DESC";
}

// ---- Prepare & Execute ------------------------------------------------------
$stmt = $coni->prepare($query);

if (count($params) > 0) {
    $bind_names   = array();
    $bind_names[] = $types;
    for ($i = 0; $i < count($params); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }
    call_user_func_array(array($stmt, 'bind_param'), $bind_names);
}

$stmt->execute();
$result = method_exists($stmt, 'get_result') ? $stmt->get_result() : false;

// ---- Fetch Results ----------------------------------------------------------
$courses = array();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
} else {
    $meta = $stmt->result_metadata();
    if ($meta) {
        $fields = array();
        $row = array();
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $fields);
        while ($stmt->fetch()) {
            $courses[] = $row;
        }
    }
}

// ---- DEBUG ------------------------------------------------------------------
if ($debug) {
    // Write debug info to a file instead of outputting HTML
    $log  = "==== EduuAspire K12 DEBUG (" . date('Y-m-d H:i:s') . ") ====\n";
    $log .= "Final SQL: $query\n";
    $log .= "Params (" . count($params) . "): " . print_r($params, true) . "\n";
    $log .= "Results Found: " . count($courses) . "\n\n";
    if (count($courses)) {
        $log .= "First Row:\n" . print_r($courses[0], true) . "\n\n";
    }
    file_put_contents(__DIR__ . '/debug_k12.log', $log, FILE_APPEND);
}

// ---- Output JSON safely -----------------------------------------------------
header('Content-Type: application/json');
echo json_encode($courses);
?>
