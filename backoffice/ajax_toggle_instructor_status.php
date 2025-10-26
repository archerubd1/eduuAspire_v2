<?php
error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json; charset=utf-8');

require_once 'config.php'; // must define $coni = new mysqli(...)

function json_response($success, $message) {
    echo json_encode(array('success' => $success, 'message' => $message));
    exit;
}

// Validate input
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    json_response(false, "Invalid instructor ID.");
}

$id = (int)$_POST['id'];

// Check current status
$stmt = $coni->prepare("SELECT status FROM instructors WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows == 0) {
    $stmt->close();
    json_response(false, "Instructor not found.");
}
$row = $res->fetch_assoc();
$stmt->close();

$current_status = $row['status'];

// Determine new status
$new_status = 'active';
if ($current_status == 'active') {
    $new_status = 'suspended';
} elseif ($current_status == 'suspended' || $current_status == 'inactive') {
    $new_status = 'active';
}

// Update status
$update = $coni->prepare("UPDATE instructors SET status = ? WHERE id = ?");
$update->bind_param("si", $new_status, $id);
if ($update->execute()) {
    $update->close();
    if ($new_status == 'active') {
        json_response(true, "Instructor reactivated successfully.");
    } else {
        json_response(true, "Instructor suspended successfully.");
    }
} else {
    json_response(false, "Failed to update instructor status: " . $update->error);
}
?>
