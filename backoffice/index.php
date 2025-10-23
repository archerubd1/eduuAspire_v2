<?php
$page = "login";
$fun  = "login";
include_once('head_nav.php');
?>
<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <?php //include_once('aside_nav.php'); ?>

      <!-- Layout page -->
      <div class="layout-page">

        <!-- Search/Nav -->
        <?php include_once('nav_search.php'); ?>

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">

            <div class="row justify-content-center">
              <div class="col-md-6 col-lg-4">

                <div class="card shadow-sm">
                  <div class="card-body p-4">

                    <h4 class="mb-4 text-center">Login to Your Account</h4>

                    <form action="process_login.php" method="POST">

                      <!-- Username / Email -->
                      <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email or Username</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                          <input type="text" class="form-control" id="username" name="username" placeholder="Enter your email or username" required>
                        </div>
                      </div>

                      <!-- Password -->
                      <div class="mb-3">
                        <label for="loginPassword" class="form-label">Password</label>
                        <div class="input-group">
                          <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                          <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                        </div>
                      </div>

                      <!-- Remember Me -->
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="rememberMe" name="remember_me">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                      </div>

                      <!-- Submit Button -->
                      <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                          <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </button>
                      </div>

                      <!-- Forgot Password Link -->
                      <div class="text-center mt-3">
                        <a href="forgot_password.php" class="small text-muted">Forgot your password?</a>
                      </div>

                    </form>

                  </div>
                </div>

              </div>
            </div>

          </div>
        </div>
        <!-- /Content wrapper -->

        <!-- Footer -->
        <?php include_once('footer.php'); ?>
      </div>
      <!-- /Layout page -->

    </div>
  </div>
</body>
