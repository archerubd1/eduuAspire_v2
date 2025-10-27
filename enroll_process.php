<?php
include_once('config.php');

// Always set JSON header before output
header('Content-Type: application/json');

// Disable notices and warnings (to avoid breaking JSON in old PHP)
error_reporting(E_ERROR | E_PARSE);

// Check DB connection
if ($coni->connect_error) {
    echo json_encode(array('success' => false, 'message' => 'Database connection failed.'));
    exit;
}

// Safely capture form data (no ?? operators in PHP 5.4)
$firstName  = isset($_POST['firstName'])  ? trim($_POST['firstName'])  : '';
$lastName   = isset($_POST['lastName'])   ? trim($_POST['lastName'])   : '';
$email      = isset($_POST['email'])      ? trim($_POST['email'])      : '';
$phone      = isset($_POST['phone'])      ? trim($_POST['phone'])      : '';
$education  = isset($_POST['education'])  ? trim($_POST['education'])  : '';
$experience = isset($_POST['experience']) ? trim($_POST['experience']) : '';
$motivation = isset($_POST['motivation']) ? trim($_POST['motivation']) : '';
$schedule   = isset($_POST['schedule'])   ? trim($_POST['schedule'])   : '';
$newsletter = isset($_POST['newsletter']) ? 1 : 0;
$course_id  = isset($_POST['course_id'])  ? intval($_POST['course_id']) : 0;

// Validate required fields
if ($firstName == '' || $lastName == '' || $email == '' || $course_id == 0) {
    echo json_encode(array('success' => false, 'message' => 'Required fields are missing.'));
    exit;
}

// Prepare SQL (keep column order consistent with bind types)
$sql = "INSERT INTO enrollments 
    (first_name, last_name, email, phone, course_id, education, experience, motivation, schedule, newsletter, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

$stmt = $coni->prepare($sql);

// Validate prepare() success
if (!$stmt) {
    echo json_encode(array('success' => false, 'message' => 'Database prepare failed: ' . $coni->error));
    exit;
}

// Bind parameters — use 's' for string, 'i' for integer
$stmt->bind_param(
    "ssssissssi",
    $firstName,
    $lastName,
    $email,
    $phone,
    $course_id,
    $education,
    $experience,
    $motivation,
    $schedule,
    $newsletter
);

// Execute and return response
if ($stmt->execute()) {
    $enroll_id = $stmt->insert_id;
    echo json_encode(array(
        'success'  => true,
        'message'  => 'Enrollment successful! Redirecting to payment...',
        'redirect' => 'payment.php?id=' . $course_id . '&enroll_id=' . $enroll_id
    ));
} else {
    echo json_encode(array('success' => false, 'message' => 'Database error: ' . $stmt->error));
}

$stmt->close();
$coni->close();
?>
