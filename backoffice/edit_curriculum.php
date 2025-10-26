<?php
$page = "courses";
$fun  = "lessons";
include_once('head_nav.php');
include_once('config.php');

$courseId = (int)$_GET['course'];
if (!$courseId) die("Invalid course ID.");

$course = mysqli_fetch_assoc(mysqli_query($coni, "SELECT id, name FROM lessons WHERE id = $courseId"));
if (!$course) die("Course not found.");

$lessons = mysqli_query($coni, "SELECT * FROM modules WHERE course_id = $courseId ORDER BY module_order ASC");
?>



<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
	
	
	
	
<div class="container py-4">
  <h4 class="mb-4"><i class="bx bx-edit-alt me-2"></i>Edit Curriculum: <?= htmlspecialchars($course['name']) ?></h4>

  <div id="lessonContainer">
    <?php
    if ($lessons && mysqli_num_rows($lessons) > 0) {
      while ($lesson = mysqli_fetch_assoc($lessons)) {
        $lessonId = $lesson['id'];
        $topics = mysqli_query($coni, "SELECT * FROM content WHERE module_id = $lessonId ORDER BY topic_order ASC");
    ?>
    <div class="card mb-4 lesson-block" data-lesson-id="<?= $lessonId ?>">
      <div class="card-header d-flex justify-content-between align-items-center bg-light">
        <div>
          <strong>Lesson:</strong> 
          <input type="text" class="form-control d-inline-block w-auto" name="lesson_title" value="<?= htmlspecialchars($lesson['module_title']) ?>" placeholder="Lesson Title">
        </div>
        <div>
          <button class="btn btn-sm btn-outline-danger" onclick="suspendLesson(<?= $lessonId ?>)">
            <i class="bx bx-pause-circle"></i> Suspend
          </button>
          <button class="btn btn-sm btn-outline-success" onclick="addTopic(<?= $lessonId ?>)">
            <i class="bx bx-plus-circle"></i> Add Topic
          </button>
        </div>
      </div>
      <div class="card-body">
        <textarea class="form-control mb-3" name="lesson_description" placeholder="Lesson Description"><?= htmlspecialchars($lesson['module_description']) ?></textarea>
        <h6 class="text-muted mb-2">Topics</h6>
        <ul class="list-group topic-list" id="topics-<?= $lessonId ?>">
          <?php
          if ($topics && mysqli_num_rows($topics) > 0) {
            while ($topic = mysqli_fetch_assoc($topics)) {
              echo "
              <li class='list-group-item topic-item' data-topic-id='{$topic['id']}'>
                <div class='d-flex justify-content-between align-items-start'>
                  <div class='w-100'>
                    <input type='text' class='form-control mb-2' name='topic_title' value='" . htmlspecialchars($topic['topic_title']) . "' placeholder='Topic Title'>
                    <textarea class='form-control' name='topic_description' placeholder='Topic Description'>" . htmlspecialchars($topic['topic_description']) . "</textarea>
                  </div>
                  <button class='btn btn-sm btn-outline-danger ms-2' onclick='removeTopic(this, {$topic['id']})'>
                    <i class='bx bx-trash'></i>
                  </button>
                </div>
              </li>";
            }
          } else {
            echo "<li class='list-group-item text-muted'>No topics found for this lesson.</li>";
          }
          ?>
        </ul>
      </div>
    </div>
    <?php
      }
    } else {
      echo "<p class='text-muted'>No lessons available. Use the button below to add one.</p>";
    }
    ?>
  </div>

  <button class="btn btn-primary mt-3" id="addLesson"><i class="bx bx-plus-circle"></i> Add Lesson</button>
  <button class="btn btn-success mt-3" id="saveCurriculum"><i class="bx bx-save"></i> Save All Changes</button>
  <a href="course-lessons.php" class="btn btn-outline-secondary mt-3"><i class="bx bx-arrow-back"></i> Back</a>
</div>

<!-- JS & Styling -->
<style>
.lesson-block { border-radius: 8px; }
.lesson-block input, .lesson-block textarea { font-size: 0.9rem; }
.topic-item { border-left: 4px solid #0d6efd; margin-bottom: 6px; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {

  // Add new lesson
  $('#addLesson').on('click', function() {
    const newLesson = `
      <div class="card mb-4 lesson-block new-lesson">
        <div class="card-header bg-light">
          <strong>New Lesson:</strong>
          <input type="text" class="form-control mt-2" name="lesson_title" placeholder="Lesson Title">
        </div>
        <div class="card-body">
          <textarea class="form-control mb-3" name="lesson_description" placeholder="Lesson Description"></textarea>
          <h6 class="text-muted mb-2">Topics</h6>
          <ul class="list-group topic-list"></ul>
          <button class="btn btn-sm btn-outline-success mt-2" onclick="addTopicDynamic(this)">
            <i class="bx bx-plus-circle"></i> Add Topic
          </button>
        </div>
      </div>`;
    $('#lessonContainer').append(newLesson);
  });

  // Save curriculum (AJAX)
  $('#saveCurriculum').on('click', function() {
    const payload = [];

    $('.lesson-block').each(function() {
      const lessonId = $(this).data('lesson-id') || 0;
      const title = $(this).find('[name="lesson_title"]').val();
      const desc = $(this).find('[name="lesson_description"]').val();

      const topics = [];
      $(this).find('.topic-item').each(function() {
        const topicId = $(this).data('topic-id') || 0;
        const topicTitle = $(this).find('[name="topic_title"]').val();
        const topicDesc = $(this).find('[name="topic_description"]').val();
        topics.push({ topicId, topicTitle, topicDesc });
      });

      payload.push({ lessonId, title, desc, topics });
    });

    $.ajax({
      url: 'ajax_update_curriculum.php',
      method: 'POST',
      data: { courseId: <?= $courseId ?>, data: JSON.stringify(payload) },
      success: function(res) {
        try {
          const data = JSON.parse(res);
          alert(data.message);
          if (data.success) location.href = 'course-lessons.php';
        } catch (e) {
          alert('Error parsing response');
        }
      },
      error: function() {
        alert('Error updating curriculum');
      }
    });
  });
});

// Add topic for existing lesson
function addTopic(lessonId) {
  const li = `
    <li class='list-group-item topic-item'>
      <div class='d-flex justify-content-between align-items-start'>
        <div class='w-100'>
          <input type='text' class='form-control mb-2' name='topic_title' placeholder='Topic Title'>
          <textarea class='form-control' name='topic_description' placeholder='Topic Description'></textarea>
        </div>
      </div>
    </li>`;
  $('#topics-' + lessonId).append(li);
}

// Add topic in newly added lesson
function addTopicDynamic(button) {
  const topicItem = `
    <li class='list-group-item topic-item'>
      <div class='d-flex justify-content-between align-items-start'>
        <div class='w-100'>
          <input type='text' class='form-control mb-2' name='topic_title' placeholder='Topic Title'>
          <textarea class='form-control' name='topic_description' placeholder='Topic Description'></textarea>
        </div>
      </div>
    </li>`;
  $(button).siblings('.topic-list').append(topicItem);
}

// Remove topic
function removeTopic(el, id) {
  if (!confirm("Remove this topic?")) return;
  $(el).closest('li').remove();
}

// Suspend lesson
function suspendLesson(lessonId) {
  if (!confirm("Suspend this lesson?")) return;
  $.post('ajax_suspend_lesson.php', { id: lessonId }, function(res) {
    try {
      const data = JSON.parse(res);
      alert(data.message);
      if (data.success) location.reload();
    } catch (e) {
      alert('Error suspending lesson');
    }
  });
}
</script>
