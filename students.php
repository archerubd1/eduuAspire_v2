<?php 
$page = "home";
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
      <h1 class="mb-2 mb-lg-0">EduAspire for Students</h1>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.html">Home</a></li>
          <li class="current">Student Blog</li>
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
          <img src="assets/img/blog/blog-post-3.webp" alt="Student Success" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Student Success</span>
            </div>
            <h2 class="post-title">
              <a href="blog-details.html" title="Top Learning Pathways for Students in 2025">
                Top Learning Pathways for Students in 2025
              </a>
            </h2>
          </div>
        </article><!-- End Featured Post -->

        <!-- Regular Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="Study Skills" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Study Skills</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="How Students Can Build In-Demand Skills Online">
                How Students Can Build In-Demand Skills Online
              </a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="Career Prep" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Career Preparation</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="5 Career Tips Every Student Should Know">
                5 Career Tips Every Student Should Know
              </a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="Tech Skills" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Tech Skills</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Top Technology Skills Students Should Learn">
                Top Technology Skills Students Should Learn
              </a>
            </h3>
          </div>
        </article><!-- End Blog Item -->

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="Programming Guide" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Apr. 14th, 2025</span>
              <span class="category">Programming</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html" title="Step-by-Step Programming Guide for Students">
                Step-by-Step Programming Guide for Students
              </a>
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
              <span class="post-date"><span>12</span>December</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">John Doe</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Student Success</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Mapping Your Student Goals with EduAspire</h3>
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
              <span class="post-date"><span>19</span>March</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Julia Parker</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Study Skills</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Developing Critical Skills for Academic Success</h3>
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
              <span class="post-date"><span>24</span>June</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Maria Doe</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Career Prep</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Effective Networking Tips for Students</h3>
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
              <span class="post-date"><span>05</span>August</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Maria Doe</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Guidance</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Finding Mentorship to Boost Your Learning</h3>
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
              <span class="post-date"><span>17</span>September</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">John Parker</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Workshops</span>
              </div>
            </div>

            <div class="post-content d-flex flex-column">
              <h3 class="post-title">EduAspire Student Workshops – Learn, Practice, Achieve</h3>
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
              <h3 class="post-title">Student Success Stories with EduAspire Courses</h3>
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
  </section><!-- /Pagination Section -->

</main>

<?php 
include_once('footer.php');
?>
