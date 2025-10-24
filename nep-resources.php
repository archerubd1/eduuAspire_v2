<?php 
$page = "nep";
include_once('head-nav.php');
include_once('config.php');

if ($coni->connect_error) {
  die("DB Connection failed: " . $coni->connect_error);
}
?>

<main class="main">

  <!-- Page Title -->
  <div class="page-title light-background">
    <div class="container d-lg-flex justify-content-between align-items-center">
      <h1 class="mb-2 mb-lg-0">NEP Resources</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">NEP Resources</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Blog Hero Section -->
  <section id="blog-hero" class="blog-hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="blog-grid">

        <!-- Featured Post -->
        <article class="blog-item featured" data-aos="fade-up">
          <img src="assets/img/blog/blog-post-3.webp" alt="NEP Resource" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">NEP 2020</span>
            </div>
            <h2 class="post-title">
              <a href="#blog-details.html" title="Key Highlights of NEP 2020">Understanding the Key Highlights of NEP 2020</a>
            </h2>
          </div>
        </article><!-- End Featured Post -->

        <!-- Regular Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Teacher Development" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">Teacher Training</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Teacher Training under NEP">Empowering Teachers through NEP 2020 Initiatives</a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="Digital Education" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">Digital Learning</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Role of Digital Platforms">Role of Digital Platforms in Modern Education</a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="Skill Development" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">Skill Development</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Vocational Skills">Integrating Skill-Based Learning into Curriculum</a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="Higher Education" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">Higher Education</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="NEP Reforms">Reforms in Higher Education Institutions</a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

      </div>

    </div>

  </section><!-- /Blog Hero Section -->

  <!-- Blog Posts Section -->
  <section id="blog-posts" class="blog-posts section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">

        <div class="col-lg-4">
          <article class="position-relative h-100">

            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-1.webp" class="img-fluid" alt="">
            </div>

            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>12</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Team</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Assessment</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Assessment Reforms and Holistic Report Cards</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>

          </article>
        </div><!-- End post list item -->

        <div class="col-lg-4">
          <article class="position-relative h-100">

            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-2.webp" class="img-fluid" alt="">
            </div>

            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>19</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Experts</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Innovation</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Innovation and Research in NEP Framework</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>

          </article>
        </div><!-- End post list item -->

        <div class="col-lg-4">
          <article class="position-relative h-100">

            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-3.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>24</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Insights</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Equity</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Promoting Equity and Inclusive Education</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>

          </article>
        </div><!-- End post list item -->

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-4.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>05</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Research</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Policy</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">NEP Implementation and Policy Guidelines</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div><!-- End post list item -->

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-5.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>17</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Editors</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Future Learning</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Building Future-Ready Students with NEP Vision</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div><!-- End post list item -->

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-6.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>07</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Academy</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Online Courses</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">How EduAspire Supports NEP Through Online Courses</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div><!-- End post list item -->

      </div>
    </div>

  </section><!-- /Blog Posts Section -->

  <!-- Pagination Section -->
  <section id="pagination-2" class="pagination-2 section">
    <div class="container">
      <nav class="d-flex justify-content-center" aria-label="Page navigation">
        <ul>
          <li><a href="#"><i class="bi bi-arrow-left"></i> Previous</a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">Next <i class="bi bi-arrow-right"></i></a></li>
        </ul>
      </nav>
    </div>
  </section>

</main>

<?php include_once('footer.php'); ?>
