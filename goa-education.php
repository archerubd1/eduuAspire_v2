<?php 
$page = "goaedu";
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
      <h1 class="mb-2 mb-lg-0">Goa Education Hub</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">EduAspire Blog</li>
        </ol>
      </nav>
    </div>
  </div>
  <!-- End Page Title -->

  <!-- Blog Hero Section -->
  <section id="blog-hero" class="blog-hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="blog-grid">

        <!-- Featured Post (Large) -->
        <article class="blog-item featured" data-aos="fade-up">
          <img src="assets/img/blog/blog-post-3.webp" alt="EduAspire Goa Campus" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Learning</span>
            </div>
            <h2 class="post-title">
              <a href="blog-details.html" title="Goa – The Emerging Education Hub of India">
                Goa – The Emerging Education Hub of India
              </a>
            </h2>
          </div>
        </article>
        <!-- End Featured Post -->

        <!-- Regular Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Online Learning" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 20th, 2025</span>
              <span class="category">E-Learning</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="How Online Courses Empower Students Across Goa">
                How Online Courses Empower Students Across Goa
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="Career Skills" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">May 10th, 2025</span>
              <span class="category">Career</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Top 5 Career Skills to Learn in 2025 with EduAspire">
                Top 5 Career Skills to Learn in 2025 with EduAspire
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="Cloud Computing Courses" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">May 25th, 2025</span>
              <span class="category">Technology</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Master Cloud Computing from Goa’s Best Instructors">
                Master Cloud Computing from Goa’s Best Instructors
              </a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="Programming" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Jun. 5th, 2025</span>
              <span class="category">Programming</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Learn Programming the Smart Way with EduAspire">
                Learn Programming the Smart Way with EduAspire
              </a>
            </h3>
          </div>
        </article>

      </div>
    </div>
  </section>
  <!-- /Blog Hero Section -->

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
                <i class="bi bi-person"></i> <span class="ps-2">Admin</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Education</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Why Goa is Perfect for an EduTech Revolution</h3>
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
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Team</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Courses</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Affordable Online Courses for Every Student in Goa</h3>
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
                <i class="bi bi-person"></i> <span class="ps-2">Maria Dsouza</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Community</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Building a Community of Learners – Goa’s New Wave</h3>
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
                <i class="bi bi-person"></i> <span class="ps-2">EduAspire Mentor</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Guidance</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Career Guidance for Students: Learn, Explore & Grow</h3>
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
                <i class="bi bi-person"></i> <span class="ps-2">John Parker</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Events</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">EduAspire Launches “SkillUp Goa” 2025 Program</h3>
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
                <i class="bi bi-person"></i> <span class="ps-2">Julia White</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Success Stories</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Meet Goa Students Who Transformed Their Careers with EduAspire</h3>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

      </div>
    </div>
  </section>
  <!-- /Blog Posts Section -->

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
  </section>
  <!-- /Pagination Section -->

</main>

<?php 
include_once('footer.php');
?>
