<?php
include_once('config.php');

$response = ['success' => false, 'message' => 'Invalid request'];

if (!empty($_POST['courseId']) && !empty($_POST['data'])) {
  $courseId = (int)$_POST['courseId'];
  $data = json_decode($_POST['data'], true);

  if (!$data) {
    $response['message'] = 'Malformed JSON data.';
    echo json_encode($response);
    exit;
  }

  foreach ($data as $lesson) {
    $lessonId = (int)$lesson['lessonId'];
    $title = mysqli_real_escape_string($coni, $lesson['title']);
    $desc = mysqli_real_escape_string($coni, $lesson['desc']);

    if ($lessonId > 0) {
      // Update existing lesson
      mysqli_query($coni, "UPDATE modules SET module_title='$title', module_description='$desc' WHERE id=$lessonId");
    } else {
      // Insert new lesson
      mysqli_query($coni, "INSERT INTO modules (course_id, module_title, module_description, created) VALUES ($courseId, '$title', '$desc', UNIX_TIMESTAMP())");
      $lessonId = mysqli_insert_id($coni);
    }

    // Update topics
    foreach ($lesson['topics'] as $topic) {
      $topicId = (int)$topic['topicId'];
      $topicTitle = mysqli_real_escape_string($coni, $topic['topicTitle']);
      $topicDesc = mysqli_real_escape_string($coni, $topic['topicDesc']);

      if ($topicId > 0) {
        mysqli_query($coni, "UPDATE content SET topic_title='$topicTitle', topic_description='$topicDesc' WHERE id=$topicId");
      } else {
        mysqli_query($coni, "INSERT INTO content (module_id, topic_title, topic_description, created) VALUES ($lessonId, '$topicTitle', '$topicDesc', UNIX_TIMESTAMP())");
      }
    }
  }

  $response = ['success' => true, 'message' => '✅ Curriculum updated successfully!'];
}

echo json_encode($response);
