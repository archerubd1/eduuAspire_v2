<?php
$page = "courses";
$fun  = "lessons";
include_once('head_nav.php');
include_once('config.php');

$courseId = (int)$_GET['course'];
$course = mysqli_fetch_assoc(mysqli_query($coni, "SELECT name FROM lessons WHERE id=$courseId"));
$lessons = mysqli_query($coni, "SELECT id, module_title AS lesson_title, module_description AS lesson_description FROM modules WHERE course_id=$courseId ORDER BY module_order ASC");
?>
<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
	
	
	
<div class="container py-4">
  <h4 class="mb-4"><i class="bx bx-show-alt me-2"></i>Curriculum for <?= htmlspecialchars($course['name']) ?></h4>
  
  <?php
  if ($lessons && mysqli_num_rows($lessons) > 0) {
    while ($lesson = mysqli_fetch_assoc($lessons)) {
      echo "<div class='card mb-3'>
        <div class='card-header bg-light'>
          <strong>Lesson:</strong> " . htmlspecialchars($lesson['lesson_title']) . "
        </div>
        <div class='card-body'>
          <p class='text-muted mb-2'>" . htmlspecialchars($lesson['lesson_description']) . "</p>
          <ul class='list-group'>";
          $topics = mysqli_query($coni, "SELECT topic_title, topic_description FROM content WHERE module_id=" . $lesson['id'] . " ORDER BY topic_order ASC");
          if ($topics && mysqli_num_rows($topics) > 0) {
            while ($topic = mysqli_fetch_assoc($topics)) {
              echo "<li class='list-group-item'>
                <strong>" . htmlspecialchars($topic['topic_title']) . "</strong><br>
                <small class='text-muted'>" . htmlspecialchars($topic['topic_description']) . "</small>
              </li>";
            }
          } else {
            echo "<li class='list-group-item text-muted'>No topics available for this lesson.</li>";
          }
          echo "</ul></div></div>";
    }
  } else {
    echo "<p class='text-muted'>No lessons found for this course.</p>";
  }
  ?>
  <a href="course-lessons.php" class="btn btn-outline-secondary mt-3"><i class="bx bx-arrow-back"></i> Back to Courses</a>
</div>
<?php include_once('footer.php'); ?>
