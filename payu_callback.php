<?php
include_once('config.php');
include_once('head-nav.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

$postData = $_POST;
$raw = json_encode($postData, JSON_PRETTY_PRINT);

// Extract key fields
$enroll_id = intval($postData['udf1'] ?? 0);
$course_id = intval($postData['udf2'] ?? 0);
$status = strtolower(trim($postData['status'] ?? 'pending'));
$txnid = $postData['txnid'] ?? '';
$amount = $postData['amount'] ?? 0;
$mode = $postData['mode'] ?? '';
$bank_ref = $postData['bank_ref_num'] ?? '';
$mihpayid = $postData['mihpayid'] ?? '';
$hash = $postData['hash'] ?? '';

// Save into payments table
$stmt = $coni->prepare("
  INSERT INTO payments (enroll_id, course_id, transaction_id, payment_status, amount, payment_mode, bank_ref_num, mihpayid, hash, raw_response)
  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param("iissdsssss", $enroll_id, $course_id, $txnid, $status, $amount, $mode, $bank_ref, $mihpayid, $hash, $raw);
$stmt->execute();
$stmt->close();

// Update enrollment status
if ($status === 'success') {
  $coni->query("UPDATE enrollments SET payment_status='paid' WHERE id=$enroll_id");
}
?>

<main class="main">
  <div class="page-title light-background">
    <div class="container text-center">
      <h1>Payment <?php echo ucfirst($status); ?></h1>
    </div>
  </div>

  <section id="payment-result" class="section">
    <div class="container text-center" data-aos="fade-up">
      <?php if ($status === 'success'): ?>
        <div class="alert alert-success p-4 rounded shadow-sm">
          <h3 class="mb-3">🎉 Payment Successful!</h3>
          <p>Your payment of ₹<?php echo htmlspecialchars($amount); ?> has been received successfully.</p>
          <p>Transaction ID: <strong><?php echo htmlspecialchars($txnid); ?></strong></p>
          <p>Bank Reference: <strong><?php echo htmlspecialchars($bank_ref); ?></strong></p>
        </div>
      <?php elseif ($status === 'failure'): ?>
        <div class="alert alert-danger p-4 rounded shadow-sm">
          <h3>❌ Payment Failed</h3>
          <p>Transaction ID: <strong><?php echo htmlspecialchars($txnid); ?></strong></p>
          <p>Your transaction was not completed. Please try again.</p>
        </div>
      <?php else: ?>
        <div class="alert alert-warning p-4 rounded shadow-sm">
          <h3>⚠️ Payment Pending</h3>
          <p>Your payment confirmation is pending. Please wait or contact support.</p>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const status = "<?php echo $status; ?>";
  if (status === 'success') {
    Swal.fire({
      icon: 'success',
      title: 'Thank You 🎓',
      html: '<p>Your enrollment details, LXP login, and course access information will be shared via email to your registered email ID.</p>',
      confirmButtonText: 'Okay',
      allowOutsideClick: false
    }).then(() => {
      window.location.href = 'index.php';
    });
  } else if (status === 'failure') {
    Swal.fire({
      icon: 'error',
      title: 'Payment Failed ❌',
      text: 'Please try again or contact support.'
    });
  } else if (status === 'pending') {
    Swal.fire({
      icon: 'info',
      title: 'Payment Pending ⏳',
      text: 'Your payment is being processed. We’ll notify you shortly.'
    });
  }
});
</script>

<?php include_once('footer.php'); ?>
