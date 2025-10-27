<?php
// ajax_toggle_promotion.php
include_once('config.php');
header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Invalid request');

if (isset($_POST['id'])) {
  $id = (int)$_POST['id'];

  // Fetch current state
  $q = mysqli_query($coni, "SELECT is_active FROM marketplace_promotions WHERE id = $id LIMIT 1");
  if ($q && mysqli_num_rows($q) > 0) {
    $row = mysqli_fetch_assoc($q);
    $newStatus = ($row['is_active'] == 1) ? 0 : 1;

    $update = mysqli_query($coni, "UPDATE marketplace_promotions SET is_active = $newStatus WHERE id = $id");
    if ($update) {
      $stateText = ($newStatus == 1) ? 'activated' : 'deactivated';
      $response = array('success' => true, 'message' => "Promotion successfully $stateText.");
    } else {
      $response['message'] = 'Database update failed: ' . mysqli_error($coni);
    }
  } else {
    $response['message'] = 'Promotion not found.';
  }
} else {
  $response['message'] = 'Missing ID parameter.';
}

echo json_encode($response);
?>
