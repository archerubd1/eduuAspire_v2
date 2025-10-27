<?php
// ajax_delete_promotion.php
include_once('config.php');
header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Invalid request');

if (isset($_POST['id'])) {
  $id = (int)$_POST['id'];

  // Check if promo exists
  $check = mysqli_query($coni, "SELECT id FROM marketplace_promotions WHERE id = $id");
  if ($check && mysqli_num_rows($check) > 0) {
    $sql = "DELETE FROM marketplace_promotions WHERE id = $id";
    if (mysqli_query($coni, $sql)) {
      $response = array('success' => true, 'message' => 'Promotion deleted successfully.');
    } else {
      $response['message'] = 'Database error: ' . mysqli_error($coni);
    }
  } else {
    $response['message'] = 'Promotion not found.';
  }
} else {
  $response['message'] = 'Missing ID parameter.';
}

echo json_encode($response);
?>
