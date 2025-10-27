<?php
// marketplace-reviews.php
$page = "marketplace";
$fun  = "market_reviews";
include_once('head_nav.php');
include_once('config.php');
?>
<div class="layout-page">
<?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl container-p-y">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bx bx-chat me-2"></i>Marketplace Reviews & Moderation</h4>
        <a href="marketplace-dashboard.php" class="btn btn-outline-secondary">Back</a>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <p class="text-muted small mb-0">Use the controls to publish/ hide reviews and post official replies. Hover CTAs for help.</p>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table id="reviewsTable" class="table table-striped table-bordered">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Course</th>
                  <th>Student</th>
                  <th>Rating</th>
                  <th>Review</th>
                  <th>Status</th>
                  <th>Admin Reply</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
<?php
$sql = "SELECT r.id, r.course_id, r.user_login, r.rating, r.review_text, r.status, r.admin_reply, l.name AS course_name, u.first_name, u.last_name
        FROM marketplace_reviews r
        LEFT JOIN lessons l ON l.id = r.course_id
        LEFT JOIN users u ON u.login = r.user_login
        ORDER BY r.id DESC";
$res = mysqli_query($coni, $sql);
$i = 1;
if ($res) {
  while ($row = mysqli_fetch_assoc($res)) {
    $student = '';
    if (!empty($row['first_name']) || !empty($row['last_name'])) {
      $student = htmlspecialchars(trim($row['first_name'] . ' ' . $row['last_name']));
    } else {
      $student = htmlspecialchars($row['user_login']);
    }
    $snippet = htmlspecialchars(mb_substr($row['review_text'], 0, 200));
    $status_label = ($row['status'] == 'published') ? '<span class="badge bg-success">Published</span>' : '<span class="badge bg-secondary">Hidden</span>';
    echo '<tr>
      <td>' . $i . '</td>
      <td>' . htmlspecialchars($row['course_name']) . '</td>
      <td>' . $student . '</td>
      <td>' . htmlspecialchars($row['rating']) . ' ★</td>
      <td><small class="text-muted">' . $snippet . '</small></td>
      <td class="text-center">' . $status_label . '</td>
      <td><small>' . htmlspecialchars($row['admin_reply']) . '</small></td>
      <td class="text-nowrap">
        <button class="btn btn-sm btn-outline-success" data-toggle="tooltip" title="Approve / Publish" onclick="toggleReview(' . $row['id'] . ', \'published\')"><i class="bx bx-check"></i></button>
        <button class="btn btn-sm btn-outline-secondary" data-toggle="tooltip" title="Hide/Unpublish" onclick="toggleReview(' . $row['id'] . ', \'hidden\')"><i class="bx bx-hide"></i></button>
        <button class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Reply as EduuAspire" onclick="openReplyModal(' . $row['id'] . ')"><i class="bx bx-reply"></i></button>
      </td>
    </tr>';
    $i++;
  }
} else {
  echo '<tr><td colspan="8" class="text-center text-muted">No reviews found.</td></tr>';
}
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Reply Modal -->
      <div class="modal fade" id="replyModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <form id="replyForm">
              <div class="modal-header">
                <h5 class="modal-title">Post Official Reply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="review_id" id="replyReviewId" value="0">
                <div class="mb-3">
                  <label class="form-label">Reply</label>
                  <textarea name="reply_text" id="replyText" class="form-control" rows="4" required></textarea>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Post Reply</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
jQuery(function($){
  $('[data-toggle="tooltip"]').tooltip();

  $('#reviewsTable').DataTable({ "pageLength": 10 });

  $('#replyForm').on('submit', function(e){
    e.preventDefault();
    $.post('ajax_reply_review.php', $(this).serialize(), function(res){
      try {
        var j = JSON.parse(res);
        alert(j.message);
        if (j.success) { location.reload(); }
      } catch (e) { alert('Unexpected response'); }
    });
  });
});

function toggleReview(id, status){
  if (!confirm('Confirm change status?')) return;
  $.post('ajax_toggle_review.php', { id: id, status: status }, function(res){
    try {
      var j = JSON.parse(res);
      alert(j.message);
      if (j.success) location.reload();
    } catch (e) { alert('Unexpected response'); }
  });
}

function openReplyModal(id){
  $('#replyReviewId').val(id);
  $('#replyText').val('');
  $('#replyModal').modal('show');
}
</script>
