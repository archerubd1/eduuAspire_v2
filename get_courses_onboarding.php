<?php
// -----------------------------------------------------------------------------
// EduuAspire | Corporate Onboarding & Skilling Program Loader
// PHP 5.4 Compatible | Uses ENUM('Professional') for corporate-level programs
// -----------------------------------------------------------------------------
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php');

if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

// ---- Normalize safely --------------------------------------------------------
function norm($v){ return strtolower(trim($v)); }

$sector     = isset($_POST['sector']) ? norm($_POST['sector']) : '';
$training   = isset($_POST['training']) ? norm($_POST['training']) : '';
$mode       = isset($_POST['mode']) ? norm($_POST['mode']) : '';
$assessment = isset($_POST['assessment']) ? norm($_POST['assessment']) : '';
$search     = isset($_POST['search']) ? norm($_POST['search']) : '';
$sort       = isset($_POST['sort']) ? $_POST['sort'] : 'popular';

// -----------------------------------------------------------------------------
// AUTO-POPULATE professional onboarding courses if missing
// -----------------------------------------------------------------------------
$check = $coni->query("SELECT COUNT(*) AS c FROM lessons WHERE LOWER(academic_level)='professional'");
$count = $check ? $check->fetch_assoc() : array('c'=>0);

if (intval($count['c']) == 0) {

  $sectors = array(
    "Hospitality & Tourism" => array(
      "Front Office Onboarding","Housekeeping Essentials","Food & Beverage Service",
      "Hospitality Etiquette","Customer Service Excellence","Safety & Hygiene Induction"
    ),
    "Industrial & Manufacturing" => array(
      "Industrial Safety Induction","Machine Operations Basics","Electrical & Maintenance",
      "Workplace Discipline & SOPs","Supervisory Skills Development"
    ),
    "Security & Allied Services" => array(
      "Basic Security Training","Emergency Response & First Aid",
      "Fire Safety & Evacuation Drill","Crowd Management Skills","Supervisory Security Officer Induction"
    ),
    "Retail & Customer Care" => array(
      "POS Handling","Customer Communication Skills","Complaint Management",
      "Sales Etiquette","Product Knowledge & Display"
    ),
    "Facility & Logistics" => array(
      "Material Handling Safety","Warehouse Operations","Maintenance Basics",
      "Driver Induction Program","Fleet & Transport Management"
    )
  );

  foreach ($sectors as $sectorName => $courses) {
    foreach ($courses as $c) {
      $modeType = (rand(0,2)==0?"SPL":(rand(0,2)==1?"ILT":"Hybrid"));
      $assessmentType = (rand(0,2)==0?"Practical":(rand(0,2)==1?"Online":"Project"));
      $learners = rand(80,250);
      $rating = round((rand(45,49)/10),1);
      $reviews = rand(15,90);
      $info = "Corporate onboarding & skilling course for {$sectorName}: {$c}, delivered in {$modeType} mode with {$assessmentType} evaluation.";

      $stmt = $coni->prepare("
        INSERT INTO lessons
        (name, info, learners, rating, reviews, price, course_type,
         academic_level, board, course_mode, delivery_type, assessment_type,
         active, show_catalog, publish, created)
        VALUES (?, ?, ?, ?, ?, 0.00, 'Paid', 'Professional', ?, ?, 'Online', ?, 1, 1, 1, UNIX_TIMESTAMP())
      ");
      $stmt->bind_param('ssiddsss', $c, $info, $learners, $rating, $reviews, $sectorName, $modeType, $assessmentType);
      $stmt->execute();
    }
  }
}

// -----------------------------------------------------------------------------
// Build Dynamic Filter Query
// -----------------------------------------------------------------------------
$q = "SELECT id, name, info, board AS sector, course_mode, assessment_type,
            learners, rating, reviews,
        CASE
          WHEN LOWER(name) LIKE '%onboard%' THEN 'Onboarding'
          WHEN LOWER(name) LIKE '%safety%' THEN 'Safety Induction'
          WHEN LOWER(name) LIKE '%skill%' THEN 'Skill Development'
          WHEN LOWER(name) LIKE '%supervisor%' THEN 'Supervisory Programs'
          WHEN LOWER(name) LIKE '%customer%' THEN 'Customer Service'
          ELSE 'General'
        END AS training_type
      FROM lessons
      WHERE active=1 AND publish=1 AND LOWER(academic_level)='professional'";

$p = array(); $t = '';

if ($sector && $sector != 'all') {
  $q .= " AND LOWER(board)=?";
  $p[] = $sector; $t .= 's';
}
if ($training && $training != 'all') {
  $q .= " AND LOWER(name) LIKE ?";
  $p[] = "%".$training."%"; $t .= 's';
}
if ($mode && $mode != 'all') {
  $q .= " AND LOWER(course_mode)=?";
  $p[] = $mode; $t .= 's';
}
if ($assessment && $assessment != 'all') {
  $q .= " AND LOWER(assessment_type)=?";
  $p[] = $assessment; $t .= 's';
}
if ($search != '') {
  $q .= " AND (LOWER(name) LIKE ? OR LOWER(info) LIKE ?)";
  $p[] = "%".$search."%"; $p[] = "%".$search."%"; $t .= 'ss';
}

switch ($sort) {
  case 'newest': $q .= " ORDER BY created DESC"; break;
  case 'rating': $q .= " ORDER BY rating DESC"; break;
  default: $q .= " ORDER BY learners DESC";
}

// -----------------------------------------------------------------------------
// Execute Query
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
  while ($r = $result->fetch_assoc()) $courses[] = $r;
} else {
  $meta = $stmt->result_metadata();
  if ($meta) {
    $fields = array(); $row = array();
    while ($f = $meta->fetch_field()) $fields[] = &$row[$f->name];
    call_user_func_array(array($stmt, 'bind_result'), $fields);
    while ($stmt->fetch()) $courses[] = $row;
  }
}

// -----------------------------------------------------------------------------
// Output JSON
// -----------------------------------------------------------------------------
header('Content-Type: application/json');
echo json_encode($courses);
?>
