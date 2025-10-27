<?php
// ajax_save_banner.php
include_once('config.php');
$response = array('success'=>false,'message'=>'Invalid');
if (!empty($_POST['title'])) {
  $title = mysqli_real_escape_string($coni, $_POST['title']);
  $course_id = !empty($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
  $area = mysqli_real_escape_string($coni, $_POST['display_area']);
  $priority = (int)$_POST['priority'];
  $image_path = '';

  if (!empty($_FILES['image']['name'])) {
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed = array('jpg','jpeg','png','webp');
    if (!in_array($ext, $allowed)) { $response['message'] = 'Invalid image'; echo json_encode($response); exit; }
    $dir = '../uploads/banners/';
    if (!file_exists($dir)) mkdir($dir, 0777, true);
    $name = time().'_banner_'.rand(1000,9999).'.'.$ext;
    $dest = $dir.$name;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $dest)) $image_path = 'uploads/banners/'.$name;
    else { $response['message']='Upload failed'; echo json_encode($response); exit; }
  }

  $sql = "INSERT INTO marketplace_banners (title, image_path, course_id, display_area, priority, created, is_active) VALUES ('".$title."','".$image_path."',".$course_id.",'".$area."',".$priority.",UNIX_TIMESTAMP(),1)";
  if (mysqli_query($coni, $sql)) $response = array('success'=>true,'message'=>'Banner saved');
  else $response['message']='DB error: '.mysqli_error($coni);
}
echo json_encode($response);
