<?php
include_once('config.php');

$response = ['success' => false, 'message' => 'Unknown error'];

if (!empty($_POST['course_id'])) {
  $id = (int)$_POST['course_id'];
  $overview = mysqli_real_escape_string($coni, $_POST['overview']);
  $modules = mysqli_real_escape_string($coni, $_POST['modules']);
  $skills = mysqli_real_escape_string($coni, $_POST['skills']);
  $objectives = mysqli_real_escape_string($coni, $_POST['objectives']);
  $audience = mysqli_real_escape_string($coni, $_POST['audience']);

  $brochurePath = "";
  $brochureType = "";

  // --- Handle brochure upload ---
  if (!empty($_FILES['brochure']['name'])) {
    $allowed = ['pdf', 'doc', 'docx'];
    $ext = strtolower(pathinfo($_FILES['brochure']['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed)) {
      $uploadDir = "../uploads/brochures/";
      if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

      $newName = time() . "_brochure_" . rand(1000, 9999) . "." . $ext;
      $targetFile = $uploadDir . $newName;

      if (move_uploaded_file($_FILES['brochure']['tmp_name'], $targetFile)) {
        $brochurePath = "uploads/brochures/" . $newName;
        $brochureType = mime_content_type($targetFile);
      }
    } else {
      echo json_encode(['success' => false, 'message' => 'Invalid brochure format.']);
      exit;
    }
  }

  // --- Check existing metadata ---
  $check = mysqli_query($coni, "SELECT id FROM course_metadata WHERE course_id=$id");
  if ($check && mysqli_num_rows($check) > 0) {
    // Update
    $sql = "
      UPDATE course_metadata SET
        overview='$overview',
        modules='$modules',
        skills='$skills',
        objectives='$objectives',
        audience='$audience'
        " . ($brochurePath ? ", brochure_path='$brochurePath', brochure_type='$brochureType'" : "") . "
      WHERE course_id=$id
    ";
  } else {
    // Insert
    $sql = "
      INSERT INTO course_metadata (course_id, overview, modules, skills, objectives, audience, brochure_path, brochure_type)
      VALUES ($id, '$overview', '$modules', '$skills', '$objectives', '$audience', '$brochurePath', '$brochureType')
    ";
  }

  if (mysqli_query($coni, $sql)) {
    $response = ['success' => true, 'message' => 'Metadata updated successfully.'];
  } else {
    $response['message'] = 'Database error: ' . mysqli_error($coni);
  }
} else {
  $response['message'] = 'Invalid course ID.';
}

echo json_encode($response);
