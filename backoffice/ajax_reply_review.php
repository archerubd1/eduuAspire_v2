<?php
// ajax_reply_review.php
include_once('config.php');
$response = array('success'=>false,'message'=>'Invalid request');
if (!empty($_POST['review_id']) && isset($_POST['reply_text'])) {
  $id = (int)$_POST['review_id'];
  $reply = mysqli_real_escape_string($coni, trim($_POST['reply_text']));
  $sql = "UPDATE marketplace_reviews SET admin_reply='".$reply."', status='published' WHERE id=".$id;
  if (mysqli_query($coni, $sql)) $response = array('success'=>true,'message'=>'Reply posted and review published');
  else $response['message'] = 'DB error: '.mysqli_error($coni);
}
echo json_encode($response);
