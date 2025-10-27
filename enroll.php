<?php 
$page = "enroll";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}

// Get course ID from URL
$course_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>
<main class="main">

    <!-- Page Title -->
    <div class="page-title light-background">
      <div class="container d-lg-flex justify-content-between align-items-center">
        <h1 class="mb-2 mb-lg-0">Enrollment</h1>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Enroll</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->

    <!-- Enroll Section -->
    <section id="enroll" class="enroll section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="enrollment-form-wrapper">

              <div class="enrollment-header text-center mb-5" data-aos="fade-up" data-aos-delay="200">
                <h2>A Step Towards Your Learning Journey</h2>
                <p>with EduuAspire. Complete the form below to secure your spot in our comprehensive online learning program.</p>
              </div>

              <!-- ✅ Enrollment Form -->
              <form class="enrollment-form" id="enrollmentForm" data-aos="fade-up" data-aos-delay="300">
                <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">

                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="firstName" class="form-label">First Name *</label>
                      <input type="text" id="firstName" name="firstName" class="form-control" required autocomplete="given-name">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="lastName" class="form-label">Last Name *</label>
                      <input type="text" id="lastName" name="lastName" class="form-control" required autocomplete="family-name">
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email" class="form-label">Email Address *</label>
                      <input type="email" id="email" name="email" class="form-control" required autocomplete="email">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone" class="form-label">Phone Number</label>
                      <input type="tel" id="phone" name="phone" class="form-control" autocomplete="tel">
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="education" class="form-label">Education Level</label>
                      <select id="education" name="education" class="form-select">
                        <option value="">Select your education level...</option>
                        <option value="high-school">High School</option>
                        <option value="associate">Associate Degree</option>
                        <option value="bachelor">Bachelor's Degree</option>
                        <option value="master">Master's Degree</option>
                        <option value="doctorate">Doctorate</option>
                        <option value="other">Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="experience" class="form-label">Experience Level</label>
                      <select id="experience" name="experience" class="form-select">
                        <option value="">Select your experience...</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                        <option value="expert">Expert</option>
                      </select>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-12">
                    <div class="form-group">
                      <label for="motivation" class="form-label">What motivates you to take this course?</label>
                      <textarea id="motivation" name="motivation" class="form-control" rows="4" placeholder="Share your goals and what you hope to achieve..."></textarea>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="form-label">Preferred Learning Schedule</label>
                      <div class="schedule-options">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="schedule" id="weekdays" value="weekdays">
                          <label class="form-check-label" for="weekdays">Weekdays (Monday - Friday)</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="schedule" id="weekends" value="weekends">
                          <label class="form-check-label" for="weekends">Weekends (Saturday - Sunday)</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="schedule" id="flexible" value="flexible" checked>
                          <label class="form-check-label" for="flexible">Flexible (Self-paced)</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mb-4">
                  <div class="col-12">
                    <div class="form-group">
                      <div class="agreement-section">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                          <label class="form-check-label" for="terms">
                            I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a> *
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                          <label class="form-check-label" for="newsletter">
                            I would like to receive course updates and educational content via email
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-12 text-center">
                    <!-- ✅ Added proper spinner + text for button -->
                    <button type="submit" class="btn btn-enroll">
                      <span id="btnText"><i class="bi bi-check-circle me-2"></i>Enroll Now</span>
                      <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                    </button>
                    <p class="enrollment-note mt-3">
                      <i class="bi bi-shield-check"></i>
                      Your information is secure and will never be shared with third parties
                    </p>
                  </div>
                </div>

              </form>

            </div>
          </div><!-- End Form Column -->

          <div class="col-lg-4 d-none d-lg-block">
            <div class="enrollment-benefits" data-aos="fade-left" data-aos-delay="400">
              <h3>Why Choose Our Courses?</h3>

              <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-trophy"></i></div>
                <div class="benefit-content">
                  <h4>Expert Instructors</h4>
                  <p>Learn from industry professionals with years of real-world experience</p>
                </div>
              </div>

              <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-clock"></i></div>
                <div class="benefit-content">
                  <h4>Flexible Learning</h4>
                  <p>Study at your own pace with 24/7 access to course materials</p>
                </div>
              </div>

              <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-award"></i></div>
                <div class="benefit-content">
                  <h4>Certification</h4>
                  <p>Earn industry-recognized certificates upon course completion</p>
                </div>
              </div>

              <div class="benefit-item">
                <div class="benefit-icon"><i class="bi bi-people"></i></div>
                <div class="benefit-content">
                  <h4>Community Support</h4>
                  <p>Connect with fellow students and get help when you need it</p>
                </div>
              </div>

              <div class="enrollment-stats mt-4">
                <div class="stat-item">
                  <span class="stat-number">15,000+</span>
                  <span class="stat-label">Students Enrolled</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">98%</span>
                  <span class="stat-label">Completion Rate</span>
                </div>
                <div class="stat-item">
                  <span class="stat-number">4.9/5</span>
                  <span class="stat-label">Average Rating</span>
                </div>
              </div>
            </div>
          </div><!-- End Benefits Column -->
        </div>

      </div>
    </section><!-- /Enroll Section -->

</main>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('enrollmentForm');
  const submitBtn = form.querySelector('button[type="submit"]');
  const btnText = document.getElementById('btnText');
  const spinner = document.getElementById('spinner');

  form.addEventListener('submit', async function (e) {
    e.preventDefault();

    if (btnText && spinner) {
      btnText.classList.add('d-none');
      spinner.classList.remove('d-none');
    }
    submitBtn.disabled = true;

    const formData = new FormData(form);

    try {
      const res = await fetch('enroll_process.php', {
        method: 'POST',
        body: formData
      });

      const data = await res.json();

      if (data.success) {
        await Swal.fire({
          icon: 'success',
          title: 'Enrollment Successful 🎉',
          text: data.message,
          showConfirmButton: false,
          timer: 1600
        });
        if (data.redirect) window.location.href = data.redirect;
      } else {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: data.message || 'Something went wrong. Please try again.'
        });
      }
    } catch (err) {
      Swal.fire({
        icon: 'error',
        title: 'Network Error',
        text: 'Please check your internet connection and try again.'
      });
    } finally {
      if (btnText && spinner) {
        btnText.classList.remove('d-none');
        spinner.classList.add('d-none');
      }
      submitBtn.disabled = false;
    }
  });
});
</script>

<?php include_once('footer.php'); ?>
