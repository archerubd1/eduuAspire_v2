<?php 
$page = "teach";
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
      <h1 class="mb-2 mb-lg-0">Teachers’ Blog</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Teachers Blog</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Blog Hero Section -->
  <section id="blog-hero" class="blog-hero section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <div class="blog-grid">

        <!-- Featured Post (Large) -->
        <article class="blog-item featured" data-aos="fade-up">
          <img src="assets/img/blog/blog-post-3.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 20th, 2025</span>
              <span class="category">Education</span>
            </div>
            <h2 class="post-title">
              <a href="blog-details.html" title="Innovative Teaching Methods for Modern Classrooms">
                Innovative Teaching Methods for Modern Classrooms
              </a>
            </h2>
          </div>
        </article><!-- End Featured Post -->

        <!-- Regular Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 18th, 2025</span>
              <span class="category">Classroom Tips</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="5 Simple Ways to Keep Students Engaged">
                5 Simple Ways to Keep Students Engaged
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 12th, 2025</span>
              <span class="category">Teacher Growth</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="How Teachers Can Build Confidence and Leadership">
                How Teachers Can Build Confidence and Leadership
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 9th, 2025</span>
              <span class="category">Digital Learning</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Integrating Technology in Everyday Teaching">
                Integrating Technology in Everyday Teaching
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="Blog Image" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 5th, 2025</span>
              <span class="category">Motivation</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Inspiring Your Students Every Day">
                Inspiring Your Students Every Day
              </a>
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
              <span class="post-date"><span>12</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Prof. Anita Rao</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Mentorship</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">The Art of Mentoring Young Minds</h3>
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
              <span class="post-date"><span>15</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. Rahul Menon</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Education Policy</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Understanding NEP 2020 and Its Impact on Teachers</h3>
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
              <span class="post-date"><span>20</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Ms. Kavya Desai</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Work-Life Balance</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Balancing Work and Well-Being as a Teacher</h3>
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
              <span class="post-date"><span>22</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. Ramesh Patil</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Pedagogy</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Reinventing Teaching Styles for Modern Learners</h3>
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
              <span class="post-date"><span>25</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Prof. Sneha Kulkarni</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Inspiration</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Stories of Teachers Who Made a Difference</h3>
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
              <span class="post-date"><span>28</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Dr. Meera Joshi</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Skill Development</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Developing Communication and Leadership Skills in Students</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

      </div>
    </div>

  </section><!-- /Blog Posts Section -->

  <!-- Pagination Section -->
  <section id="pagination-2" class="pagination-2 section">
    <div class="container">
      <nav class="d-flex justify-content-center" aria-label="Page navigation">
        <ul>
          <li><a href="#"><i class="bi bi-arrow-left"></i><span class="d-none d-sm-inline">Previous</span></a></li>
          <li><a href="#" class="active">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li class="ellipsis">...</li>
          <li><a href="#">8</a></li>
          <li><a href="#">9</a></li>
          <li><a href="#">10</a></li>
          <li><a href="#"><span class="d-none d-sm-inline">Next</span><i class="bi bi-arrow-right"></i></a></li>
        </ul>
      </nav>
    </div>
  </section><!-- /Pagination Section -->

</main>

<?php include_once('footer.php'); ?>
