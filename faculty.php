<?php 
$page = "faculty";
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
      <h1 class="mb-2 mb-lg-0">For Faculty</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">For Faculty</li>
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
          <img src="assets/img/blog/blog-post-3.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 14th, 2025</span>
              <span class="category">Teaching Innovation</span>
            </div>
            <h2 class="post-title">
              <a href="blog-details.html" title="Effective Online Teaching Strategies for Modern Educators">Effective Online Teaching Strategies for Modern Educators</a>
            </h2>
          </div>
        </article><!-- End Featured Post -->

        <!-- Regular Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Sep. 20th, 2025</span>
              <span class="category">Faculty Development</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Upskilling Faculty Through EduuAspire’s Certified Programs">Upskilling Faculty Through EduuAspire’s Certified Programs</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Aug. 28th, 2025</span>
              <span class="category">E-Learning</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="How to Build Engaging Online Course Content">How to Build Engaging Online Course Content</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Jul. 16th, 2025</span>
              <span class="category">Virtual Classroom</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Transforming Traditional Teaching into Virtual Learning">Transforming Traditional Teaching into Virtual Learning</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Jun. 11th, 2025</span>
              <span class="category">Faculty Growth</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Faculty Empowerment Through Digital Learning">Faculty Empowerment Through Digital Learning</a>
            </h3>
          </div>
        </article>

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
              <span class="post-date"><span>12</span>December</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. John Doe</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Course Design</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Designing Interactive Courses for Modern Students</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-2.webp" class="img-fluid" alt="">
            </div>

            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>19</span>March</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Prof. Julia Parker</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Online Learning</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Integrating Real-World Skills in Virtual Classrooms</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-3.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>24</span>June</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. Maria Doe</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Teaching Tools</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Top Digital Tools Every Faculty Should Know</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-4.webp" class="img-fluid" alt="">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>05</span>August</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Prof. Rahul Mehta</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Skill Enhancement</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Continuous Learning for College Faculty</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-5.webp" class="img-fluid" alt="">
            </div>

            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>17</span>September</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. John Parker</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Career Growth</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Building a Rewarding Career as an Online Educator</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-6.webp" class="img-fluid" alt="">
            </div>

            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>07</span>December</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. Julia White</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Digital Education</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Empowering Faculty with EduuAspire’s Tools & Support</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

      </div>
    </div>
  </section><!-- /Blog Posts Section -->

  <!-- Pagination -->
  <section id="pagination-2" class="pagination-2 section">
    <div class="container">
      <nav class="d-flex justify-content-center" aria-label="Page navigation">
        <ul>
          <li>
            <a href="#" aria-label="Previous page">
              <i class="bi bi-arrow-left"></i>
              <span class="d-none d-sm-inline">Previous</span>
            </a>
          </li>

          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li class="ellipsis">...</li>
          <li><a href="#">8</a></li>
          <li><a href="#">9</a></li>
          <li><a href="#">10</a></li>

          <li>
            <a href="#" aria-label="Next page">
              <span class="d-none d-sm-inline">Next</span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </section><!-- /Pagination -->

</main>

<?php 
include_once('footer.php');
?>
