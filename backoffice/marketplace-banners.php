<?php
// marketplace-banners.php
$page = "marketplace";
$fun  = "market_banners";
include_once('head_nav.php');
include_once('config.php');

// fetch banners
$bannerQ = mysqli_query($coni, "SELECT * FROM marketplace_banners ORDER BY priority ASC");

// fetch courses for linking banners
$courseQ = mysqli_query($coni, "SELECT id, name FROM lessons WHERE active=1 ORDER BY name ASC");
?>
<div class="layout-page">
<?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl container-p-y">

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bx bx-image me-2"></i>Marketplace Banners & Highlights</h4>
        <a class="btn btn-outline-secondary" href="marketplace-dashboard.php">Back</a>
      </div>

      <div class="card mb-3">
        <div class="card-body">
          <form id="bannerForm" enctype="multipart/form-data">
            <input type="hidden" name="id" value="0">
            <div class="row g-2">
              <div class="col-md-4">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required>
              </div>
              <div class="col-md-3">
                <label class="form-label">Link (course or URL)</label>
                <select name="course_id" class="form-select">
                  <option value="">-- None --</option>
<?php
if ($courseQ) {
  while ($c = mysqli_fetch_assoc($courseQ)) {
    echo '<option value="'.(int)$c['id'].'">'.htmlspecialchars($c['name']).'</option>';
  }
}
?>
                </select>
              </div>
              <div class="col-md-2">
                <label class="form-label">Position</label>
                <select name="display_area" class="form-select">
                  <option value="home">Home</option>
                  <option value="category">Category</option>
                  <option value="top">Top Banner</option>
                </select>
              </div>
              <div class="col-md-1">
                <label class="form-label">Priority</label>
                <input name="priority" class="form-control" value="1">
              </div>
              <div class="col-md-2">
                <label class="form-label">Image (jpg/png/webp)</label>
                <input type="file" name="image" accept="image/*" class="form-control">
              </div>

              <div class="col-md-12 text-end">
                <button class="btn btn-primary">Upload Banner</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Existing banners -->
      <div class="card">
        <div class="card-body">
          <table id="bannerTable" class="table table-striped table-bordered">
            <thead class="table-light"><tr><th>#</th><th>Preview</th><th>Title</th><th>Area</th><th>Priority</th><th>Actions</th></tr></thead>
            <tbody>
<?php
$i = 1;
if ($bannerQ) {
  while ($b = mysqli_fetch_assoc($bannerQ)) {
    $img = !empty($b['image_path']) ? htmlspecialchars($b['image_path']) : 'assets/img/education/default-course.webp';
    echo '<tr>
      <td>'.$i.'</td>
      <td><img src="../'.ltrim($img,'/').'" style="max-width:120px"/></td>
      <td>'.htmlspecialchars($b['title']).'</td>
      <td>'.htmlspecialchars($b['display_area']).'</td>
      <td>'.(int)$b['priority'].'</td>
      <td>
        <button class="btn btn-sm btn-outline-danger" onclick="deleteBanner('.$b['id'].')"><i class="bx bx-trash"></i></button>
      </td>
    </tr>';
    $i++;
  }
} else {
  echo '<tr><td colspan="6" class="text-center text-muted">No banners</td></tr>';
}
?>
            </tbody>
          </table>
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
  $('#bannerTable').DataTable({ "pageLength": 10 });

  $('#bannerForm').on('submit', function(e){
    e.preventDefault();
    var fd = new FormData(this);
    $.ajax({
      url: 'ajax_save_banner.php',
      method: 'POST',
      data: fd,
      contentType: false,
      processData: false,
      success: function(res){
        try { var j = JSON.parse(res); alert(j.message); if (j.success) location.reload(); } catch(e){ alert('Unexpected'); }
      }
    });
  });
});

function deleteBanner(id){
  if (!confirm('Delete banner?')) return;
  $.post('ajax_delete_banner.php', { id: id }, function(res){
    try { var j = JSON.parse(res); alert(j.message); if (j.success) location.reload(); } catch(e){ alert('Unexpected'); }
  });
}
</script>
