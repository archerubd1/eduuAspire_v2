<?php
include_once('config.php');
header('Content-Type: application/json');

// Turn off MySQLi strict errors for PHP 5.4 compatibility
mysqli_report(MYSQLI_REPORT_OFF);

$response = array('success' => false, 'message' => '');

try {
  // ===== Sanitize and assign =====
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  $type = isset($_POST['direction_type']) ? $_POST['direction_type'] : 'Category';
  $academic = isset($_POST['academic_level']) ? $_POST['academic_level'] : 'General';
  $parent = (isset($_POST['parent_direction_ID']) && $_POST['parent_direction_ID'] != '') ? (int)$_POST['parent_direction_ID'] : NULL;
  $desc = isset($_POST['description']) ? $_POST['description'] : NULL;
  $featured = isset($_POST['featured']) ? (int)$_POST['featured'] : 0;
  $active = isset($_POST['active']) ? (int)$_POST['active'] : 1;

  // ===== Validation =====
  if ($name == '') {
    throw new Exception("Category name is required.");
  }

  // ===== Prepare & Execute =====
  $stmt = $coni->prepare("INSERT INTO directions 
      (name, direction_type, academic_level, parent_direction_ID, description, featured, active)
      VALUES (?, ?, ?, ?, ?, ?, ?)");

  if (!$stmt) {
    throw new Exception("Database prepare error: " . $coni->error);
  }

  $stmt->bind_param("sssissi", $name, $type, $academic, $parent, $desc, $featured, $active);
  if (!$stmt->execute()) {
    throw new Exception("Database execute error: " . $stmt->error);
  }

  $stmt->close();

  $response['success'] = true;
  $response['message'] = 'Category added successfully!';
} catch (Exception $e) {
  $response['success'] = false;
  $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;
?>
