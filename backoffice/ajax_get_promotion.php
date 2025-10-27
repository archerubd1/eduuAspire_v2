<?php
// ajax_get_promotion.php
include_once('config.php');
header('Content-Type: application/json');

$response = array('success' => false, 'message' => 'Invalid request');

if (isset($_GET['id'])) {
  $id = (int)$_GET['id'];
  $q = mysqli_query($coni, "SELECT * FROM marketplace_promotions WHERE id = $id LIMIT 1");
  if ($q && mysqli_num_rows($q) > 0) {
    $promotion = mysqli_fetch_assoc($q);
    $response = array(
      'success' => true,
      'promotion' => $promotion
    );
  } else {
    $response['message'] = 'Promotion not found.';
  }
} else {
  $response['message'] = 'No ID provided.';
}

echo json_encode($response);
?>
