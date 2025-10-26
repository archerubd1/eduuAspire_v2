<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json; charset=utf-8');

require_once 'config.php'; // must provide $coni = new mysqli(...)

function json_response($success, $message) {
    echo json_encode(array('success' => $success, 'message' => $message));
    exit;
}

if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    json_response(false, "Invalid instructor ID.");
}

$id = (int)$_POST['id'];

// Check if instructor exists
$check = $coni->prepare("SELECT id FROM instructors WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$check->store_result();
if ($check->num_rows === 0) {
    $check->close();
    json_response(false, "Instructor not found.");
}
$check->close();

// Delete from profiles first (to maintain FK integrity)
$delProfile = $coni->prepare("DELETE FROM instructor_profiles WHERE instructor_id = ?");
$delProfile->bind_param("i", $id);
$delProfile->execute();
$delProfile->close();

// Delete from instructors table
$delInstructor = $coni->prepare("DELETE FROM instructors WHERE id = ?");
$delInstructor->bind_param("i", $id);
if ($delInstructor->execute()) {
    json_response(true, "Instructor deleted successfully.");
} else {
    json_response(false, "Failed to delete instructor: " . $delInstructor->error);
}
$delInstructor->close();
?>
