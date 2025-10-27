<?php
// marketplace-settings.php
$page = "marketplace";
$fun  = "market_settings";
include_once('head_nav.php');
include_once('config.php');

// load settings from table marketplace_settings (key,value)
$settings = array();
$q = mysqli_query($coni, "SELECT setting_key, setting_value FROM marketplace_settings");
if ($q) {
  while ($r = mysqli_fetch_assoc($q)) $settings[$r['setting_key']] = $r['setting_value'];
}
function s($k, $d) { global $settings; return isset($settings[$k]) ? $settings[$k] : $d; }
?>
<div class="layout-page">
<?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl container-p-y">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4><i class="bx bx-cog me-2"></i>Marketplace Settings</h4>
        <a class="btn btn-outline-secondary" href="marketplace-dashboard.php">Back</a>
      </div>

      <div class="card">
        <div class="card-body">
          <form id="settingsForm">
            <div class="row g-3">
              <div class="col-md-3">
                <label class="form-label">Platform Commission (%)</label>
                <input name="commission_pct" class="form-control" value="<?php echo htmlspecialchars(s('commission_pct','20')); ?>">
              </div>
              <div class="col-md-3">
                <label class="form-label">Default Currency</label>
                <select name="currency" class="form-select">
                  <option value="INR"<?php if (s('currency','INR')=='INR') echo ' selected'; ?>>INR</option>
                  <option value="USD"<?php if (s('currency','INR')=='USD') echo ' selected'; ?>>USD</option>
                </select>
              </div>
              <div class="col-md-3">
                <label class="form-label">Payment Gateways</label>
                <input name="payment_gateways" class="form-control" value="<?php echo htmlspecialchars(s('payment_gateways','UPI,Stripe,Razorpay')); ?>">
                <small class="text-muted">Comma-separated</small>
              </div>
              <div class="col-md-3">
                <label class="form-label">Refund Policy (days)</label>
                <input name="refund_days" class="form-control" value="<?php echo htmlspecialchars(s('refund_days','7')); ?>">
              </div>

              <div class="col-md-3">
                <label class="form-label">Course Visibility Default</label>
                <select name="course_visibility_default" class="form-select">
                  <option value="public"<?php if (s('course_visibility_default','public')=='public') echo ' selected'; ?>>Public</option>
                  <option value="private"<?php if (s('course_visibility_default','public')=='private') echo ' selected'; ?>>Private</option>
                </select>
              </div>

              <div class="col-md-3">
                <label class="form-label">GST (%)</label>
                <input name="tax_gst" class="form-control" value="<?php echo htmlspecialchars(s('tax_gst','18')); ?>">
              </div>

              <div class="col-md-12 text-end">
                <button class="btn btn-success">Save Settings</button>
              </div>
            </div>
          </form>
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
  $('#settingsForm').on('submit', function(e){
    e.preventDefault();
    $.post('ajax_save_setting.php', $(this).serialize(), function(res){
      try { var j = JSON.parse(res); alert(j.message); if (j.success) location.reload(); } catch(e){ alert('Unexpected'); }
    });
  });
});
</script>
