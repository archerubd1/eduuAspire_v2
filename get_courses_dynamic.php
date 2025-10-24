<?php
// get_courses_dynamic.php
// Universal course loader — PHP 5.4 compatible version
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once('config.php');

// helper: normalise input safely (PHP 5.4)
function norm_trim_lower($k) {
    if (!isset($_POST[$k])) return '';
    return strtolower(trim($_POST[$k]));
}

// capture POST (PHP 5.4 safe)
$direction   = isset($_POST['direction']) ? intval($_POST['direction']) : 0;
$subcategory = isset($_POST['subcategory']) ? intval($_POST['subcategory']) : 0;
$board       = norm_trim_lower('board');
$class       = norm_trim_lower('class');
$mode        = norm_trim_lower('mode');
$assessment  = norm_trim_lower('assessment');
$search      = norm_trim_lower('search');
$sort        = norm_trim_lower('sort');
if ($sort === '') $sort = 'popular';

// debug switch (use GET debug=1 to see SQL & params)
$debug = (isset($_GET['debug']) && $_GET['debug'] == '1') ? true : false;

// base query
$query = "
  SELECT 
    l.id, l.name, l.info, l.board, l.course_mode, l.assessment_type,
    l.learners, l.rating, l.reviews, 
    d.name AS direction_name, sd.name AS sub_direction_name
  FROM lessons l
  LEFT JOIN directions d ON l.direction_id = d.id
  LEFT JOIN directions sd ON l.sub_direction_id = sd.id
  WHERE l.active = 1 AND l.publish = 1
";

$params = array();
$types  = '';

// apply numeric filters
if ($direction > 0) {
    $query .= " AND l.direction_id = ?";
    $params[] = $direction;
    $types .= 'i';
}

if ($subcategory > 0) {
    $query .= " AND l.sub_direction_id = ?";
    $params[] = $subcategory;
    $types .= 'i';
}

// board exact match (case-insensitive)
if ($board !== '' && $board !== 'all' && $board !== 'all boards') {
    $query .= " AND LOWER(l.board) = ?";
    $params[] = $board;
    $types .= 's';
}

// class filter: for K-12 we match class text inside name or info (e.g. "Class X")
if ($class !== '' && $class !== 'all' && $class !== 'all classes') {
    // use LIKE on name OR info
    $query .= " AND (LOWER(l.name) LIKE ? OR LOWER(l.info) LIKE ?)";
    $like = '%' . $class . '%';
    $params[] = $like;
    $params[] = $like;
    $types .= 'ss';
}

// course mode
if ($mode !== '' && $mode !== 'all' && $mode !== 'all modes') {
    $query .= " AND LOWER(l.course_mode) = ?";
    $params[] = $mode;
    $types .= 's';
}

// assessment type
if ($assessment !== '' && $assessment !== 'all' && $assessment !== 'all types') {
    $query .= " AND LOWER(l.assessment_type) = ?";
    $params[] = $assessment;
    $types .= 's';
}

// search across name/info
if ($search !== '') {
    $query .= " AND (LOWER(l.name) LIKE ? OR LOWER(l.info) LIKE ?)";
    $s_like = '%' . $search . '%';
    $params[] = $s_like;
    $params[] = $s_like;
    $types .= 'ss';
}

// sorting
if ($sort === 'newest') {
    $query .= " ORDER BY l.created DESC";
} else if ($sort === 'rating') {
    $query .= " ORDER BY l.rating DESC";
} else {
    $query .= " ORDER BY l.learners DESC";
}

// debug: return SQL & params (useful during development)
if ($debug) {
    header('Content-Type: application/json');
    echo json_encode(array(
        'sql' => $query,
        'types' => $types,
        'params' => $params
    ));
    exit;
}

// prepare
$stmt = $coni->prepare($query);
if (!$stmt) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'SQL Prepare failed: ' . $coni->error));
    exit;
}

// bind params if any (PHP 5.4 style)
if (!empty($params)) {
    // build array of references
    $bind_names = array();
    $bind_names[] = $types;
    for ($i = 0; $i < count($params); $i++) {
        // create variable variables and bind by reference
        $bind_name = 'bind' . $i;
        $$bind_name = $params[$i];
        $bind_names[] = &$$bind_name;
    }
    call_user_func_array(array($stmt, 'bind_param'), $bind_names);
}

// execute
$exec_ok = $stmt->execute();
if (!$exec_ok) {
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'Execute failed: ' . $stmt->error));
    exit;
}

// fetch results: prefer get_result, fallback to bind_result
$courses = array();
if (method_exists($stmt, 'get_result')) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
} else {
    // fallback for older drivers
    $meta = $stmt->result_metadata();
    if ($meta) {
        $fields = array();
        $row = array();
        while ($field = $meta->fetch_field()) {
            $fields[] = &$row[$field->name];
        }
        call_user_func_array(array($stmt, 'bind_result'), $fields);
        while ($stmt->fetch()) {
            // copy values (to avoid reference issues)
            $r = array();
            foreach ($row as $k => $v) $r[$k] = $v;
            $courses[] = $r;
        }
    }
}

// output JSON
header('Content-Type: application/json');
echo json_encode($courses);
exit;
?>
