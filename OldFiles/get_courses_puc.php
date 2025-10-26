<?php
// -----------------------------------------------------------------------------
// EduuAspire – Dynamic PUC Course Loader (1st & 2nd Year)
// Works with PHP 5.4+ | Compatible with DB Admin Additions
// -----------------------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

// Normalize inputs
function norm($v){return isset($v)?strtolower(trim($v)):"";}

$year = norm($_POST['year']);
$stream = norm($_POST['stream']);
$subject = norm($_POST['subject']);
$mode = norm($_POST['mode']);
$assessment = norm($_POST['assessment']);
$search = norm($_POST['search']);
$sort = isset($_POST['sort']) ? $_POST['sort'] : 'popular';

// -----------------------------------------------------------------------------
// AUTO-POPULATE SAMPLE DATA (runs only once)
// -----------------------------------------------------------------------------
$check = $coni->query("SELECT COUNT(*) AS c FROM lessons WHERE academic_level='PUC'");
$count = $check->fetch_assoc();

if ($count['c'] == 0) {
  $samples = [];

  // Year 1 – Arts
  $artsSubjects = ['History','Political Science','Economics','Sociology','English','Hindi'];
  foreach ($artsSubjects as $s) {
    $samples[] = ["PUC 1st Year Arts - $s SPL", "1st Year", "Arts", $s, "SPL", "Practice Tests", 120, 4.7, 40];
  }

  // Year 1 – Commerce
  $commSubjects = ['Accountancy','Business Studies','Statistics','Economics','Secretarial Practice'];
  foreach ($commSubjects as $s) {
    $samples[] = ["PUC 1st Year Commerce - $s ILT", "1st Year", "Commerce", $s, "ILT", "Monthly Assessments", 180, 4.8, 55];
  }

  // Year 1 – Science
  $sciSubjects = ['Physics','Chemistry','Mathematics','Biology','Practical Labs PCMB'];
  foreach ($sciSubjects as $s) {
    $samples[] = ["PUC 1st Year Science - $s Hybrid", "1st Year", "Science", $s, "Hybrid", "Labs & Projects", 200, 4.9, 65];
  }

  // Year 2 – Arts
  foreach ($artsSubjects as $s) {
    $samples[] = ["PUC 2nd Year Arts - $s SPL", "2nd Year", "Arts", $s, "SPL", "Semester Exams", 130, 4.8, 42];
  }

  // Year 2 – Commerce
  foreach ($commSubjects as $s) {
    $samples[] = ["PUC 2nd Year Commerce - $s ILT", "2nd Year", "Commerce", $s, "ILT", "Board Prep Series", 200, 4.9, 60];
  }

  // Year 2 – Science
  foreach ($sciSubjects as $s) {
    $samples[] = ["PUC 2nd Year Science - $s Hybrid", "2nd Year", "Science", $s, "Hybrid", "Semester Exams", 230, 4.9, 75];
  }

  // Insert all
  foreach ($samples as $s) {
    $stmt = $coni->prepare("INSERT INTO lessons
      (name, info, learners, rating, reviews, price, course_type, academic_level, board, course_mode, delivery_type, assessment_type, active, show_catalog, publish, created)
      VALUES (?, ?, ?, ?, ?, 0.00, 'Paid', 'PUC', ?, ?, 'Online', ?, 1, 1, 1, UNIX_TIMESTAMP())");
    $info = "Auto-sample for {$s[1]} {$s[2]} - {$s[3]} course covering syllabus with adaptive assessments.";
    $stmt->bind_param('ssiddsss', $s[0], $info, $s[6], $s[7], $s[8], $s[2], $s[4], $s[5]);
    $stmt->execute();
  }
}

// -----------------------------------------------------------------------------
// Build Query (for filters)
// -----------------------------------------------------------------------------
$q = "SELECT id, name, info, board AS stream, course_mode, assessment_type, learners, rating, reviews,
CASE WHEN name LIKE '%1st Year%' THEN '1st Year' WHEN name LIKE '%2nd Year%' THEN '2nd Year' ELSE '' END AS year,
SUBSTRING_INDEX(SUBSTRING_INDEX(name,'-',-1),' ',2) AS subject
FROM lessons
WHERE active=1 AND publish=1 AND academic_level='PUC'";

$p = []; $t = '';

if ($year && $year != 'all') { $q .= " AND name LIKE ?"; $p[] = '%' . $year . '%'; $t .= 's'; }
if ($stream && $stream != 'all') { $q .= " AND LOWER(board) = ?"; $p[] = ucfirst($stream); $t .= 's'; }
if ($subject && $subject != 'all') { $q .= " AND LOWER(name) LIKE ?"; $p[] = '%' . $subject . '%'; $t .= 's'; }
if ($mode && $mode != 'all') { $q .= " AND LOWER(course_mode) = ?"; $p[] = strtoupper($mode); $t .= 's'; }
if ($assessment && $assessment != 'all') { $q .= " AND LOWER(assessment_type) LIKE ?"; $p[] = '%' . $assessment . '%'; $t .= 's'; }
if ($search != '') { $q .= " AND (LOWER(name) LIKE ? OR LOWER(info) LIKE ?)"; $p[] = '%' . $search . '%'; $p[] = '%' . $search . '%'; $t .= 'ss'; }

switch ($sort) {
  case 'newest': $q .= " ORDER BY created DESC"; break;
  case 'rating': $q .= " ORDER BY rating DESC"; break;
  default: $q .= " ORDER BY learners DESC";
}

// -----------------------------------------------------------------------------
// Execute
// -----------------------------------------------------------------------------
$stmt = $coni->prepare($q);
if ($p) {
  $refs = [$t];
  foreach ($p as $i => $v) { $refs[] = &$p[$i]; }
  call_user_func_array([$stmt, 'bind_param'], $refs);
}
$stmt->execute();

$result = method_exists($stmt, 'get_result') ? $stmt->get_result() : false;
$courses = [];

if ($result) {
  while ($r = $result->fetch_assoc()) { $courses[] = $r; }
} else {
  $meta = $stmt->result_metadata();
  if ($meta) {
    $fields = []; $row = [];
    while ($f = $meta->fetch_field()) { $fields[] = &$row[$f->name]; }
    call_user_func_array([$stmt, 'bind_result'], $fields);
    while ($stmt->fetch()) { $courses[] = $row; }
  }
}

header('Content-Type: application/json');
echo json_encode($courses);
?>
