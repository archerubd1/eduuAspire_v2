<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('config.php');
if ($coni->connect_error) die("DB Connection failed: " . $coni->connect_error);

function norm($v){ return strtolower(trim($v)); }

$category   = isset($_POST['category']) ? norm($_POST['category']) : '';
$mode       = isset($_POST['mode']) ? norm($_POST['mode']) : '';
$assessment = isset($_POST['assessment']) ? norm($_POST['assessment']) : '';
$search     = isset($_POST['search']) ? norm($_POST['search']) : '';
$sort       = isset($_POST['sort']) ? $_POST['sort'] : 'popular';

$check = $coni->query("SELECT COUNT(*) AS c FROM lessons WHERE LOWER(academic_level)='professional'");
$count = $check ? $check->fetch_assoc() : array('c'=>0);

if (intval($count['c']) < 20) {
  $categories = array(
    "Communication & Soft Skills" => array("Effective Communication","Email Etiquette","Public Speaking","Interpersonal Skills","Negotiation Skills"),
    "Leadership & Management" => array("Leadership Fundamentals","Team Management","Strategic Thinking","Conflict Resolution","Motivating Teams"),
    "Digital Skills" => array("Digital Marketing Basics","Excel & Data Analysis","MS Office Mastery","Social Media Strategy","Presentation Design"),
    "Customer Service" => array("Customer Service Excellence","CRM Basics","Handling Difficult Customers","Sales Etiquette","Service Recovery"),
    "Workplace Essentials" => array("Workplace Ethics","Time Management","Personality Development","Project Management","Business Etiquette")
  );

  foreach ($categories as $cat => $courses) {
    foreach ($courses as $c) {
      $modeType = (rand(0,2)==0?"SPL":(rand(0,2)==1?"ILT":"Hybrid"));
      $assessmentType = (rand(0,2)==0?"Online":(rand(0,2)==1?"Project":"Certification"));
      $learners = rand(100,300);
      $rating = round((rand(45,49)/10),1);
      $reviews = rand(25,100);
      $info = "{$c} - A professional course under {$cat}, {$modeType} mode, {$assessmentType} assessment.";

      $stmt = $coni->prepare("
        INSERT INTO lessons (name, info, learners, rating, reviews, price, course_type,
          academic_level, board, course_mode, delivery_type, assessment_type, active, show_catalog, publish, created)
        VALUES (?, ?, ?, ?, ?, 0.00, 'Paid', 'Professional', ?, ?, 'Online', ?, 1, 1, 1, UNIX_TIMESTAMP())
      ");
      $stmt->bind_param('ssiddsss', $c, $info, $learners, $rating, $reviews, $cat, $modeType, $assessmentType);
      $stmt->execute();
    }
  }
}

$q = "SELECT id, name, info, board AS category, course_mode, assessment_type, learners, rating, reviews
      FROM lessons
      WHERE active=1 AND publish=1 AND LOWER(academic_level)='professional'";

$p = array(); $t = '';

if ($category && $category != 'all') { $q.=" AND LOWER(board)=?"; $p[]=$category; $t.='s'; }
if ($mode && $mode != 'all') { $q.=" AND LOWER(course_mode)=?"; $p[]=$mode; $t.='s'; }
if ($assessment && $assessment != 'all') { $q.=" AND LOWER(assessment_type)=?"; $p[]=$assessment; $t.='s'; }
if ($search != '') { $q.=" AND (LOWER(name) LIKE ? OR LOWER(info) LIKE ?)"; $p[]="%$search%"; $p[]="%$search%"; $t.='ss'; }

switch ($sort) {
  case 'newest': $q.=" ORDER BY created DESC"; break;
  case 'rating': $q.=" ORDER BY rating DESC"; break;
  default: $q.=" ORDER BY learners DESC";
}

$stmt = $coni->prepare($q);
if ($p) {
  $refs = array($t);
  foreach ($p as $i => $v) $refs[] = &$p[$i];
  call_user_func_array(array($stmt,'bind_param'), $refs);
}
$stmt->execute();

$result = method_exists($stmt,'get_result') ? $stmt->get_result() : false;
$courses = array();
if ($result) while($r=$result->fetch_assoc()) $courses[]=$r;

header('Content-Type: application/json');
echo json_encode($courses);
?>
