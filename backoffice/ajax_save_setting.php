<?php
// ajax_save_settings.php
include_once('config.php');
$response = array('success'=>false,'message'=>'Invalid');

if (!empty($_POST)) {
  // allowed keys
  $allowed = array('commission_pct','currency','payment_gateways','refund_days','course_visibility_default','tax_gst');
  foreach ($allowed as $k) {
    $v = isset($_POST[$k]) ? mysqli_real_escape_string($coni, trim($_POST[$k])) : '';
    // upsert into table marketplace_settings
    $q = mysqli_query($coni, "SELECT setting_key FROM marketplace_settings WHERE setting_key = '".mysqli_real_escape_string($coni,$k)."' LIMIT 1");
    if ($q && mysqli_num_rows($q) > 0) {
      mysqli_query($coni, "UPDATE marketplace_settings SET setting_value = '".$v."' WHERE setting_key = '".mysqli_real_escape_string($coni,$k)."'");
    } else {
      mysqli_query($coni, "INSERT INTO marketplace_settings (setting_key, setting_value) VALUES ('".mysqli_real_escape_string($coni,$k)."', '".$v."')");
    }
  }
  $response = array('success'=>true,'message'=>'Settings saved');
}
echo json_encode($response);
