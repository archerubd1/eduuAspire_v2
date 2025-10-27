<?php
// marketplace-promotions.php
$page = "marketplace";
$fun  = "market_promotions";
include_once('head_nav.php');
include_once('config.php');

// Fetch promotions
$promQ = mysqli_query($coni, "SELECT * FROM marketplace_promotions ORDER BY id DESC");

// Fetch active courses for applicability dropdown
$courseQ = mysqli_query($coni, "SELECT id, name FROM lessons WHERE active=1 ORDER BY name ASC");
?>
<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl container-p-y">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bx bx-gift me-2"></i> Promotions & Coupons</h4>
        <a class="btn btn-outline-secondary" href="marketplace-dashboard.php">Back</a>
      </div>

      <!-- Add/Edit Form -->
      <div class="card mb-4 shadow-sm">
        <div class="card-body">
          <form id="promoForm" enctype="multipart/form-data">
            <input type="hidden" name="id" value="0">

            <div class="row g-3">
              <div class="col-md-4">
                <label class="form-label">Promotion Title</label>
                <input type="text" name="title" class="form-control" required>
              </div>

              <div class="col-md-2">
                <label class="form-label">Code (optional)</label>
                <input type="text" name="code" class="form-control">
              </div>

              <div class="col-md-2">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                  <option value="percentage">Percentage</option>
                  <option value="flat">Flat</option>
                </select>
              </div>

              <div class="col-md-2">
                <label class="form-label">Value</label>
                <input type="number" name="value" class="form-control" step="0.01" required>
              </div>

              <div class="col-md-2">
                <label class="form-label">Status</label>
                <select name="is_active" class="form-select">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>

              <div class="col-md-4">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control">
              </div>

              <div class="col-md-4">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control">
              </div>

              <div class="col-md-4">
                <label class="form-label">Applicable Courses</label>
                <select name="courses[]" class="form-select" multiple>
                  <?php
                  if ($courseQ) {
                    while ($c = mysqli_fetch_assoc($courseQ)) {
                      echo '<option value="' . (int)$c['id'] . '">' . htmlspecialchars($c['name']) . '</option>';
                    }
                  }
                  ?>
                </select>
                <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple courses</small>
              </div>

              <div class="col-md-12 text-end mt-3">
                <button type="submit" class="btn btn-primary px-4">
                  <i class="bx bx-save me-1"></i> Save Promotion
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Promotions List -->
      <div class="card shadow-sm">
        <div class="card-body">
          <table id="promoTable" class="table table-striped table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Code</th>
                <th>Type</th>
                <th>Value</th>
                <th>Period</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              if ($promQ && mysqli_num_rows($promQ) > 0) {
                while ($p = mysqli_fetch_assoc($promQ)) {
                  $period = htmlspecialchars($p['start_date']) . ' - ' . htmlspecialchars($p['end_date']);
                  $statusBadge = ($p['is_active'] == 1)
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-secondary">Inactive</span>';

                  echo '<tr>
                    <td>' . $i++ . '</td>
                    <td>' . htmlspecialchars($p['title']) . '</td>
                    <td>' . htmlspecialchars($p['code']) . '</td>
                    <td>' . htmlspecialchars($p['type']) . '</td>
                    <td>' . htmlspecialchars($p['value']) . '</td>
                    <td>' . $period . '</td>
                    <td>' . $statusBadge . '</td>
                    <td class="text-nowrap">
                      <button class="btn btn-sm btn-outline-primary" onclick="editPromo(' . $p['id'] . ')" data-bs-toggle="tooltip" title="Edit Promotion"><i class="bx bx-edit"></i></button>
                      <button class="btn btn-sm btn-outline-warning" onclick="togglePromo(' . $p['id'] . ')" data-bs-toggle="tooltip" title="Toggle Active"><i class="bx bx-power-off"></i></button>
                      <button class="btn btn-sm btn-outline-danger" onclick="deletePromo(' . $p['id'] . ')" data-bs-toggle="tooltip" title="Delete Promotion"><i class="bx bx-trash"></i></button>
                    </td>
                  </tr>';
                }
              } else {
                echo '<tr><td colspan="8" class="text-center text-muted py-3">No promotions found.</td></tr>';
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


<script>
  // Handle Save Promotion
  $('#promoForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    var selectedCourses = [];
    $('select[name="courses[]"] option:selected').each(function() {
      selectedCourses.push($(this).val());
    });
    formData.append('courses', JSON.stringify(selectedCourses));

    $.ajax({
      url: 'ajax_save_promotion.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(res) {
        try {
          var j = JSON.parse(res);
          alert(j.message);
          if (j.success) location.reload();
        } catch (e) {
          alert('Unexpected response: ' + res);
        }
      }
    });
  });
});

// Edit promotion
function editPromo(id) {
  $.getJSON('ajax_get_promotion.php', { id: id }, function(res) {
    if (!res.success) {
      alert(res.message);
      return;
    }
    var p = res.promotion;
    var f = $('#promoForm');
    f.find('input[name=id]').val(p.id);
    f.find('input[name=title]').val(p.title);
    f.find('input[name=code]').val(p.code);
    f.find('select[name=type]').val(p.type);
    f.find('input[name=value]').val(p.value);
    f.find('select[name=is_active]').val(p.is_active);
    f.find('input[name=start_date]').val(p.start_date);
    f.find('input[name=end_date]').val(p.end_date);

    try {
      var arr = JSON.parse(p.course_ids || '[]');
      f.find('select[name="courses[]"] option').prop('selected', false);
      for (var i = 0; i < arr.length; i++) {
        f.find('select[name="courses[]"] option[value="' + arr[i] + '"]').prop('selected', true);
      }
    } catch (e) {}

    $('html,body').animate({ scrollTop: 0 }, 300);
  });
}

// Toggle active
function togglePromo(id) {
  $.post('ajax_toggle_promotion.php', { id: id }, function(res) {
    try {
      var j = JSON.parse(res);
      alert(j.message);
      if (j.success) location.reload();
    } catch (e) {
      alert('Unexpected response');
    }
  });
}

// Delete promotion
function deletePromo(id) {
  if (!confirm('Are you sure you want to delete this promotion?')) return;
  $.post('ajax_delete_promotion.php', { id: id }, function(res) {
    try {
      var j = JSON.parse(res);
      alert(j.message);
      if (j.success) location.reload();
    } catch (e) {
      alert('Unexpected response');
    }
  });
}
</script>

<style>
.btn.btn-sm i { font-size: 1.1rem; vertical-align: middle; }
.table td, .table th { vertical-align: middle; }
</style>
