<?php
include_once('config.php');

$response = ['success' => false, 'message' => 'Unknown error'];

if (!empty($_POST['course_id'])) {
  $id = (int)$_POST['course_id'];
  $name = mysqli_real_escape_string($coni, $_POST['name']);
  $info = mysqli_real_escape_string($coni, $_POST['info']);
  $board = mysqli_real_escape_string($coni, $_POST['board']);
  $mode = mysqli_real_escape_string($coni, $_POST['course_mode']);
  $assessment = mysqli_real_escape_string($coni, $_POST['assessment_type']);
  $price = floatval($_POST['price']);
  $duration = mysqli_real_escape_string($coni, $_POST['duration']);

  // --- Handle image upload ---
  $uploadPath = "../uploads/courses/";
  $newFilePath = "";
  if (!empty($_FILES['thumbnail']['name'])) {
    $ext = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array(strtolower($ext), $allowed)) {
      if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);
      $newFileName = time() . "_course_" . rand(1000,9999) . "." . $ext;
      $fullPath = $uploadPath . $newFileName;
      if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $fullPath)) {
        $newFilePath = "uploads/courses/" . $newFileName;
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid image format.']);
      exit;
    }
  }

  // --- Update course details ---
  $sql = "
    UPDATE lessons SET
      name='$name',
      info='$info',
      board='$board',
      course_mode='$mode',
      assessment_type='$assessment',
      price='$price',
      duration='$duration'
    WHERE id=$id
  ";

  $updateLesson = mysqli_query($coni, $sql);

  // --- Update marketplace thumbnail if new image uploaded ---
  if ($newFilePath) {
    $q = mysqli_query($coni, "SELECT id FROM course_marketplace WHERE lesson_id=$id");
    if ($q && mysqli_num_rows($q) > 0) {
      mysqli_query($coni, "UPDATE course_marketplace SET image='$newFilePath' WHERE lesson_id=$id");
    } else {
      mysqli_query($coni, "INSERT INTO course_marketplace (lesson_id, image, is_active) VALUES ($id, '$newFilePath', 1)");
    }
  }

  if ($updateLesson) {
    $response = ['success' => true, 'message' => 'Course updated successfully.'];
  } else {
    $response['message'] = 'Database update failed: ' . mysqli_error($coni);
  }
} else {
  $response['message'] = 'Invalid course ID.';
}

echo json_encode($response);
