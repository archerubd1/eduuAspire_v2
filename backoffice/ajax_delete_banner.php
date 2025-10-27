<?php
include_once('config.php');
$response = array('success'=>false,'message'=>'Invalid');
if (!empty($_POST['id'])) {
  $id = (int)$_POST['id'];
  // optionally delete file path from filesystem
  $q = mysqli_query($coni, "SELECT image_path FROM marketplace_banners WHERE id=$id LIMIT 1");
  if ($q && mysqli_num_rows($q)>0) {
    $r = mysqli_fetch_assoc($q);
    if (!empty($r['image_path']) && file_exists('../'.$r['image_path'])) @unlink('../'.$r['image_path']);
  }
  if (mysqli_query($coni, "DELETE FROM marketplace_banners WHERE id=$id")) $response = array('success'=>true,'message'=>'Deleted');
  else $response['message'] = 'DB error: '.mysqli_error($coni);
}
echo json_encode($response);
