<?php
include_once('config.php');

$response = ['success' => false, 'message' => 'Invalid request'];

if (!empty($_POST['id'])) {
  $courseId = (int)$_POST['id'];

  // 1️⃣ Check if course exists
  $courseCheck = mysqli_query($coni, "SELECT id, name, active FROM lessons WHERE id = $courseId");
  if (!$courseCheck || mysqli_num_rows($courseCheck) == 0) {
    $response['message'] = "Course not found.";
    echo json_encode($response);
    exit;
  }

  // 2️⃣ Check if any students are assigned
  $students = mysqli_query($coni, "
    SELECT COUNT(*) AS cnt 
    FROM users_to_lessons 
    WHERE lessons_id = $courseId AND user_type = 'student'
  ");
  $row = mysqli_fetch_assoc($students);
  $studentCount = (int)$row['cnt'];

  if ($studentCount > 0) {
    $response['message'] = "❌ Cannot retire/suspend — $studentCount learner(s) are currently enrolled in this course.";
    echo json_encode($response);
    exit;
  }

  // 3️⃣ Retire the course (soft action)
  // Set active = 0, publish = 0 (or you can use a new column 'status' if preferred)
  $update = mysqli_query($coni, "UPDATE lessons SET active = 0, publish = 0 WHERE id = $courseId");

  if ($update) {
    $response = [
      'success' => true,
      'message' => '✅ Course has been successfully retired/suspended.'
    ];
  } else {
    $response['message'] = 'Database update failed: ' . mysqli_error($coni);
  }
}

echo json_encode($response);
