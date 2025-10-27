<?php 
$page = "payment";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

// Get course_id and enroll_id
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$enroll_id = isset($_GET['enroll_id']) ? intval($_GET['enroll_id']) : 0;

// Fetch course payment info
$payment = null;
if ($course_id > 0) {
  $stmt = $coni->prepare("SELECT course_name, yearly_fee, payu_url FROM payment_links WHERE course_id = ?");
  $stmt->bind_param("i", $course_id);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
    $payment = $result->fetch_assoc();
  }
  $stmt->close();
}
?>

<main class="main">

  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">Payment</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Payment</li>
        </ol>
      </nav>
    </div>
  </div>

  <section id="payment" class="payment section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div class="payment-wrapper">

            <div class="payment-header text-center mb-5">
              <h2>Complete Your Enrollment</h2>
              <p>Proceed to secure your spot by paying your yearly fee for the selected course.</p>
            </div>

            <?php if ($payment): ?>
              <div class="text-center mb-4">
                <h3><?php echo htmlspecialchars($payment['course_name']); ?></h3>
                <p class="text-muted">Yearly Fees</p>
                <h4 class="fw-bold text-success">₹<?php echo number_format($payment['yearly_fee'], 2); ?></h4>
              </div>

              <div class="text-center">
                <a href="<?php echo htmlspecialchars($payment['payu_url']); ?>?udf1=<?php echo $enroll_id; ?>&udf2=<?php echo $course_id; ?>" class="btn btn-enroll btn-lg" id="payBtn">
                  <i class="bi bi-credit-card me-2"></i> Pay Now
                </a>
                <p class="mt-3 text-muted">You’ll be redirected to our secure PayU gateway.</p>
              </div>
            <?php else: ?>
              <div class="alert alert-danger text-center">
                Invalid course or payment details not found.
              </div>
            <?php endif; ?>

          </div>
        </div>

        <div class="col-lg-4 d-none d-lg-block">
          <div class="enrollment-benefits" data-aos="fade-left" data-aos-delay="400">
            <h3>Why Choose EduuAspire?</h3>
            <div class="benefit-item">
              <div class="benefit-icon"><i class="bi bi-shield-lock"></i></div>
              <div class="benefit-content">
                <h4>Secure Transactions</h4>
                <p>All payments are encrypted via PayU for your safety.</p>
              </div>
            </div>
            <div class="benefit-item">
              <div class="benefit-icon"><i class="bi bi-envelope"></i></div>
              <div class="benefit-content">
                <h4>Instant Confirmation</h4>
                <p>Receive instant confirmation and enrollment verification after successful payment.</p>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>
</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const payBtn = document.getElementById('payBtn');
  if (payBtn) {
    payBtn.addEventListener('click', function(e) {
      e.preventDefault();
      const url = this.getAttribute('href');
      Swal.fire({
        title: 'Proceed to Payment?',
        text: 'You will be redirected to PayU to complete your payment.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Proceed',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = url;
        }
      });
    });
  }
});
</script>

<?php include_once('footer.php'); ?>
