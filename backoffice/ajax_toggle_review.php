<?php
// ajax_toggle_review.php
include_once('config.php');
$response = array('success'=>false,'message'=>'Invalid request');
if (!empty($_POST['id']) && !empty($_POST['status'])) {
  $id = (int)$_POST['id'];
  $status = mysqli_real_escape_string($coni, $_POST['status']);
  if ($status !== 'published' && $status !== 'hidden') {
    $response['message'] = 'Invalid status';
  } else {
    $q = mysqli_query($coni, "UPDATE marketplace_reviews SET status='".$status."' WHERE id=".$id);
    if ($q) $response = array('success'=>true,'message'=>'Status updated');
    else $response['message'] = 'DB error: '.mysqli_error($coni);
  }
}
echo json_encode($response);
