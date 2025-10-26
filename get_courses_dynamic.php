<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php');
header('Content-Type: application/json; charset=utf-8');

// Ensure charset consistency
$coni->set_charset("utf8mb4");
$coni->query("SET collation_connection='utf8mb4_unicode_ci'");

function norm($k) {
  return isset($_POST[$k]) ? strtolower(trim($_POST[$k])) : '';
}

$direction   = isset($_POST['direction']) ? intval($_POST['direction']) : 0;
$subcategory = isset($_POST['subcategory']) ? intval($_POST['subcategory']) : 0;
$board       = norm('board');
$class       = norm('class');
$mode        = norm('mode');
$assessment  = norm('assessment');
$year        = norm('year');
$program     = norm('program');
$search      = norm('search');
$sort        = norm('sort');
if ($sort === '') $sort = 'popular';

// Base query
$query = "
SELECT 
  l.id, l.name, l.info, l.board, l.course_mode, l.assessment_type,
  l.learners, l.rating, l.reviews, l.price,
  d.name AS direction_name, sd.name AS sub_direction_name,
  cm.badge, cm.image,
  CONCAT(i.first_name, ' ', i.last_name) AS instructor_name,
  i.avatar AS instructor_avatar
FROM lessons l
LEFT JOIN directions d ON l.direction_id = d.id
LEFT JOIN directions sd ON l.sub_direction_id = sd.id
LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
LEFT JOIN users_to_lessons ul ON ul.lessons_id = l.id
LEFT JOIN instructors i ON i.user_login = ul.users_login
WHERE l.active = 1 AND l.publish = 1
";

$params = [];
$types  = '';

function addCondition(&$query, &$params, &$types, $condition, $values, $isInt = false) {
  $query .= " " . $condition;
  foreach ($values as $v) {
    $params[] = $v;
    $types   .= $isInt ? 'i' : 's';
  }
}

// Filters
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
if ($board && $board !== 'all') addCondition($query, $params, $types, "AND LOWER(l.board) = ?", [$board]);
if ($class && $class !== 'all') addCondition($query, $params, $types, "AND (LOWER(l.name) LIKE ? OR LOWER(l.info) LIKE ?)", ["%$class%", "%$class%"]);
if ($mode && $mode !== 'all') addCondition($query, $params, $types, "AND LOWER(l.course_mode) = ?", [$mode]);
if ($assessment && $assessment !== 'all') addCondition($query, $params, $types, "AND LOWER(l.assessment_type) = ?", [$assessment]);
if ($year && $year !== 'all') addCondition($query, $params, $types, "AND (LOWER(l.name) LIKE ? OR LOWER(l.info) LIKE ?)", ["%$year%", "%$year%"]);
if ($program && $program !== 'all') addCondition($query, $params, $types, "AND (LOWER(l.name) LIKE ? OR LOWER(l.board) LIKE ?)", ["%$program%", "%$program%"]);
if ($search) addCondition($query, $params, $types, "AND (LOWER(l.name) LIKE ? OR LOWER(l.info) LIKE ?)", ["%$search%", "%$search%"]);

switch ($sort) {
  case 'newest': $query .= " ORDER BY l.id DESC"; break;
  case 'rating': $query .= " ORDER BY l.rating DESC"; break;
  default:       $query .= " ORDER BY l.learners DESC"; break;
}

$stmt = $coni->prepare($query);
if (!$stmt) {
  echo json_encode(["error" => "SQL prepare failed", "detail" => $coni->error, "query" => $query]);
  exit;
}

// Bind params safely (PHP 7 compatible)
if (!empty($params)) {
  $bind_names[] = $types;
  for ($i = 0; $i < count($params); $i++) {
    $bind_name = 'bind' . $i;
    $$bind_name = $params[$i];
    $bind_names[] = &$$bind_name;
  }
  call_user_func_array([$stmt, 'bind_param'], $bind_names);
}

// Execute query
if (!$stmt->execute()) {
  echo json_encode(["error" => "Execution failed", "detail" => $stmt->error]);
  exit;
}

$result = $stmt->get_result();
$courses = [];
while ($r = $result->fetch_assoc()) {
  $r['image'] = $r['image'] ?: 'assets/img/education/default-course.webp';
  $r['instructor_avatar'] = (!empty($r['instructor_avatar']) && file_exists("backoffice/" . $r['instructor_avatar']))
    ? "backoffice/" . $r['instructor_avatar']
    : "assets/img/avatars/default.png";
  $courses[] = $r;
}

// Output
if (empty($courses)) {
  echo json_encode(["message" => "No courses found", "filters" => $_POST]);
} else {
  echo json_encode($courses);
}
?>
