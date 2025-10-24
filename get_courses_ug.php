<?php
// -----------------------------------------------------------------------------
// EduuAspire UG Dynamic Course Loader (BCA, BBA, BCom, BA)
// PHP 5.4 compatible | Auto-populates if no UG courses exist
// -----------------------------------------------------------------------------
$page="ug";
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

// --- Normalize input safely ---------------------------------------------------
function norm($v){ return isset($v) ? strtolower(trim($v)) : ''; }

$year       = norm($_POST['year']);
$program    = norm($_POST['program']);
$subject    = norm($_POST['subject']);
$mode       = norm($_POST['mode']);
$assessment = norm($_POST['assessment']);
$search     = norm($_POST['search']);
$sort       = isset($_POST['sort']) ? $_POST['sort'] : 'popular';

// -----------------------------------------------------------------------------
// AUTO-POPULATE UG COURSES (runs only if table empty for UG)
// -----------------------------------------------------------------------------
$check = $coni->query("SELECT COUNT(*) AS c FROM lessons WHERE academic_level='UG'");
$count = $check->fetch_assoc();

if ($count['c'] == 0) {

  $samples = array();

  // -------------------- PROGRAM: BCA --------------------
  $bcaSubjects = array('C-Programming','DataBase Management System','Software Engineering','Java Programming','Operating System','Java Lab','MAD','AI Basics','Project Management');
  foreach (array('1st Year','2nd Year','3rd Year') as $y) {
    foreach ($bcaSubjects as $s) {
      $samples[] = array("UG $y BCA - $s","UG","BCA",$y,$s,"Hybrid","Assignments",rand(120,300),4.7,rand(25,90));
    }
  }

  // -------------------- PROGRAM: BBA --------------------
  $bbaSubjects = array('Business Environment','Business Law','Organizational Behavior','Company Secretarial','Banking & Finance Service','Skill & Development','Digital Marketing','Human Resource Management','Corporate Governance');
  foreach (array('1st Year','2nd Year','3rd Year') as $y) {
    foreach ($bbaSubjects as $s) {
      $samples[] = array("UG $y BBA - $s","UG","BBA",$y,$s,"ILT","Semester Exams",rand(100,280),4.8,rand(30,80));
    }
  }

  // -------------------- PROGRAM: BCom --------------------
  $bcomSubjects = array('Financial Accounting','Business Communication','Business Economics','Corporate Accounting','Business Law','Business Statistics','Cost Accounting','Income Tax','Marketing Management');
  foreach (array('1st Year','2nd Year','3rd Year') as $y) {
    foreach ($bcomSubjects as $s) {
      $samples[] = array("UG $y BCom - $s","UG","BCom",$y,$s,"SPL","Practice Tests",rand(150,260),4.6,rand(20,70));
    }
  }

  // -------------------- PROGRAM: BA --------------------
  $baSubjects = array('Industrial Economics','English','Managerial Economics','Indian Economics','Hindi','Micro and Macro Economics');
  foreach (array('1st Year','2nd Year','3rd Year') as $y) {
    foreach ($baSubjects as $s) {
      $samples[] = array("UG $y BA - $s","UG","BA",$y,$s,"Hybrid","Projects",rand(90,210),4.7,rand(25,65));
    }
  }

  // -------------------- Insert all --------------------
  foreach ($samples as $s) {
    $stmt = $coni->prepare("INSERT INTO lessons 
      (name, info, learners, rating, reviews, price, course_type, academic_level, board, course_mode, delivery_type, assessment_type, active, show_catalog, publish, created)
      VALUES (?, ?, ?, ?, ?, 0.00, 'Paid', ?, ?, ?, 'Online', ?, 1, 1, 1, UNIX_TIMESTAMP())");
    $info = "Comprehensive {$s[2]} {$s[3]} course on {$s[4]} with {$s[5]} mode and {$s[6]} based evaluation.";
    $stmt->bind_param('ssiddssss', $s[0], $info, $s[7], $s[8], $s[9], $s[1], $s[2], $s[5], $s[6]);
    $stmt->execute();
  }
}

// -----------------------------------------------------------------------------
// Query UG courses dynamically
// -----------------------------------------------------------------------------
$q = "SELECT id, name, info, board AS program, course_mode, assessment_type, learners, rating, reviews,
CASE 
  WHEN name LIKE '%1st Year%' THEN '1st Year' 
  WHEN name LIKE '%2nd Year%' THEN '2nd Year' 
  WHEN name LIKE '%3rd Year%' THEN '3rd Year' 
  ELSE '' 
END AS year,
SUBSTRING_INDEX(SUBSTRING_INDEX(name,'-',-1),' ',2) AS subject
FROM lessons
WHERE active=1 AND publish=1 AND academic_level='UG'";

$p = array(); $t = '';

if ($year && $year != 'all') { $q .= " AND name LIKE ?"; $p[] = "%".$year."%"; $t .= 's'; }
if ($program && $program != 'all') { $q .= " AND LOWER(board)=?"; $p[] = strtolower($program); $t .= 's'; }
if ($subject && $subject != 'all') { $q .= " AND LOWER(name) LIKE ?"; $p[] = "%".strtolower($subject)."%"; $t .= 's'; }
if ($mode && $mode != 'all') { $q .= " AND LOWER(course_mode)=?"; $p[] = strtolower($mode); $t .= 's'; }
if ($assessment && $assessment != 'all') { $q .= " AND LOWER(assessment_type) LIKE ?"; $p[] = "%".strtolower($assessment)."%"; $t .= 's'; }
if ($search != '') { $q .= " AND (LOWER(name) LIKE ? OR LOWER(info) LIKE ?)"; $p[] = "%".$search."%"; $p[] = "%".$search."%"; $t .= 'ss'; }

switch ($sort) {
  case 'newest': $q .= " ORDER BY created DESC"; break;
  case 'rating': $q .= " ORDER BY rating DESC"; break;
  default: $q .= " ORDER BY learners DESC";
}

// -----------------------------------------------------------------------------
// Execute query
// -----------------------------------------------------------------------------
$stmt = $coni->prepare($q);
if ($p) {
  $refs = array($t);
  foreach ($p as $i => $v) { $refs[] = &$p[$i]; }
  call_user_func_array(array($stmt, 'bind_param'), $refs);
}
$stmt->execute();

$result = method_exists($stmt, 'get_result') ? $stmt->get_result() : false;
$courses = array();

if ($result) {
  while ($r = $result->fetch_assoc()) { $courses[] = $r; }
} else {
  $meta = $stmt->result_metadata();
  if ($meta) {
    $fields = array(); $row = array();
    while ($f = $meta->fetch_field()) { $fields[] = &$row[$f->name]; }
    call_user_func_array(array($stmt, 'bind_result'), $fields);
    while ($stmt->fetch()) { $courses[] = $row; }
  }
}

header('Content-Type: application/json');
echo json_encode($courses);
?>
