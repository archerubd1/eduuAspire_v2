<?php
include_once('config.php');
header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Invalid request');

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
if ($title == '') {
  $response['message'] = 'Title is required.';
  echo json_encode($response);
  exit;
}

$id         = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$code       = isset($_POST['code']) ? mysqli_real_escape_string($coni, $_POST['code']) : '';
$type       = isset($_POST['type']) ? mysqli_real_escape_string($coni, $_POST['type']) : 'percentage';
$value      = isset($_POST['value']) ? floatval($_POST['value']) : 0.00;
$is_active  = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;
$start_date = isset($_POST['start_date']) && $_POST['start_date'] != '' ? mysqli_real_escape_string($coni, $_POST['start_date']) : NULL;
$end_date   = isset($_POST['end_date']) && $_POST['end_date'] != '' ? mysqli_real_escape_string($coni, $_POST['end_date']) : NULL;
$courses    = isset($_POST['courses']) ? $_POST['courses'] : '[]';

// Validate date range
if ($start_date && $end_date && strtotime($end_date) < strtotime($start_date)) {
  $response['message'] = 'End date cannot be earlier than start date.';
  echo json_encode($response);
  exit;
}

if ($id > 0) {
  $sql = sprintf(
    "UPDATE marketplace_promotions SET
      title='%s', code='%s', type='%s', value='%.2f',
      is_active=%d, start_date=%s, end_date=%s,
      course_ids='%s'
      WHERE id=%d",
    mysqli_real_escape_string($coni, $title),
    $code,
    $type,
    $value,
    $is_active,
    ($start_date ? "'$start_date'" : "NULL"),
    ($end_date ? "'$end_date'" : "NULL"),
    mysqli_real_escape_string($coni, $courses),
    $id
  );
} else {
  $sql = sprintf(
    "INSERT INTO marketplace_promotions
    (title, code, type, value, is_active, start_date, end_date, course_ids, created)
    VALUES ('%s','%s','%s','%.2f',%d,%s,%s,'%s',UNIX_TIMESTAMP())",
    mysqli_real_escape_string($coni, $title),
    $code,
    $type,
    $value,
    $is_active,
    ($start_date ? "'$start_date'" : "NULL"),
    ($end_date ? "'$end_date'" : "NULL"),
    mysqli_real_escape_string($coni, $courses)
  );
}

if (mysqli_query($coni, $sql)) {
  $response = array('success' => true, 'message' => 'Promotion saved successfully.');
} else {
  $response['message'] = '❌ SQL Error: ' . mysqli_error($coni) . "\n\nQuery: " . $sql;
}

echo json_encode($response);
?>
