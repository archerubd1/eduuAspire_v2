<?php
// File: blog.php
$page = "blog";
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
      <div>
        <h1 class="mb-2 mb-lg-0">EduuAspire Insights</h1>
        <p class="small text-muted mb-0">Learn, teach, and grow — the latest stories from EduuAspire’s online marketplace.</p>
      </div>
      <nav class="breadcrumbs">
        <ol>
          <li><a href="index.php">Home</a></li>
          <li class="current">Blog</li>
        </ol>
      </nav>
    </div>
  </div><!-- End Page Title -->

  <!-- Blog Hero Section -->
  <section id="blog-hero" class="blog-hero section">
    <div class="container" data-aos="fade-up" data-aos-delay="100">

      <!-- Search + Category Filter -->
      <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
        <form class="d-flex w-100 w-md-50 mb-3 mb-md-0" method="GET" action="blog.php">
          <input name="q" class="form-control me-2" type="search" placeholder="Search EduuAspire guides, stories, or tips..." aria-label="Search">
          <button class="btn btn-primary" type="submit">Search</button>
        </form>

        <div class="d-flex align-items-center gap-2">
          <select name="category" onchange="if (this.value) window.location.href='blog.php?category='+encodeURIComponent(this.value)" class="form-select">
            <option value="">All Categories</option>
            <option value="Courses">Courses</option>
            <option value="Sellers">Sellers</option>
            <option value="Learning">Learning</option>
            <option value="Technology">Technology</option>
            <option value="Career">Career</option>
            <option value="Marketplace Tips">Marketplace Tips</option>
          </select>
          <a href="become-seller.php" class="btn btn-outline-success">Sell on EduuAspire</a>
        </div>
      </div>

      <div class="blog-grid">

        <!-- Featured Post -->
        <article class="blog-item featured" data-aos="fade-up">
          <img src="assets/img/blog/blog-post-3.webp" alt="EduuAspire AI Course Matching" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Oct. 5th, 2025</span>
              <span class="category">Technology</span>
              <span class="badge bg-warning text-dark ms-2">Featured</span>
            </div>
            <h2 class="post-title">
              <a href="blog-details.html">How EduuAspire’s AI helps learners find the perfect online course</a>
            </h2>
            <p class="small text-muted mb-0">Discover how EduuAspire’s smart recommendations match students to instructors effortlessly.</p>
          </div>
        </article>

        <!-- Regular Hero Posts -->
        <article class="blog-item" data-aos="fade-up" data-aos-delay="100">
          <img src="assets/img/blog/blog-post-portrait-1.webp" alt="EduuAspire Seller Guide" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Sep. 20th, 2025</span>
              <span class="category">Marketplace Tips</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html">5 ways to boost visibility for your EduuAspire course</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="200">
          <img src="assets/img/blog/blog-post-9.webp" alt="EduuAspire Career Growth" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Sep. 12th, 2025</span>
              <span class="category">Career</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html">From student to seller: how one learner built a full-time business on EduuAspire</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="300">
          <img src="assets/img/blog/blog-post-7.webp" alt="EduuAspire Cloud" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Aug. 30th, 2025</span>
              <span class="category">Technology</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html">Why EduuAspire Cloud ensures faster, smoother course streaming</a>
            </h3>
          </div>
        </article>

        <article class="blog-item" data-aos="fade-up" data-aos-delay="400">
          <img src="assets/img/blog/blog-post-6.webp" alt="EduuAspire Programming Course" class="img-fluid">
          <div class="blog-content">
            <div class="post-meta">
              <span class="date">Aug. 15th, 2025</span>
              <span class="category">Programming</span>
            </div>
            <h3 class="post-title">
              <a href="blog-details.html">Building your first coding course on EduuAspire: step-by-step guide</a>
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
              <img src="assets/img/blog/blog-post-1.webp" class="img-fluid" alt="EduuAspire Course Marketing">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>10</span>October</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Lydia Brooks</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Seller Guide</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">7 smart marketing ideas for EduuAspire instructors</h3>
              <p class="small text-muted">Use simple strategies to attract students and boost course sales.</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-2.webp" class="img-fluid" alt="EduuAspire Course Pricing">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>25</span>September</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Darren Miles</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Marketplace Tips</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Pricing your EduuAspire courses for maximum reach</h3>
              <p class="small text-muted">Learn how pricing psychology can increase enrollments.</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-3.webp" class="img-fluid" alt="EduuAspire Success Story">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>05</span>September</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Maria Jones</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Success Story</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">From teacher to EduuAspire top-seller: Maria’s journey</h3>
              <p class="small text-muted">A real story of passion turned into profit through online teaching.</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-4.webp" class="img-fluid" alt="EduuAspire Community">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>22</span>August</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Alan Smith</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Community</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">How community feedback shapes EduuAspire’s marketplace</h3>
              <p class="small text-muted">Your voice helps us build better learning tools.</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-5.webp" class="img-fluid" alt="EduuAspire Analytics">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>10</span>August</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">Nina Carter</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Analytics</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">Using EduuAspire analytics to grow your teaching brand</h3>
              <p class="small text-muted">Track engagement, optimize content, and scale smarter.</p>
              <a href="blog-details.html" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>

        <div class="col-lg-4">
          <article class="position-relative h-100">
            <div class="post-img position-relative overflow-hidden">
              <img src="assets/img/blog/blog-post-6.webp" class="img-fluid" alt="EduuAspire Learning Future">
            </div>
            <div class="meta d-flex align-items-end">
              <span class="post-date"><span>30</span>July</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-person"></i> <span class="ps-2">James Lee</span>
              </div>
              <span class="px-3 text-black-50">/</span>
              <div class="d-flex align-items-center">
                <i class="bi bi-folder2"></i> <span class="ps-2">Learning</span>
              </div>
            </div>
            <div class="post-content d-flex flex-column">
              <h3 class="post-title">The future of online education: EduuAspire’s 2025 vision</h3>
              <p class="small text-muted">Where learning meets opportunity for every student and seller.</p>
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
  </section>

  <!-- Floating CTA -->
  <a href="become-seller.php" class="btn btn-primary position-fixed" style="right:20px;bottom:20px;z-index:9999;border-radius:50px;padding:12px 18px;box-shadow:0 6px 18px rgba(0,0,0,0.12);">
    <i class="bi bi-shop me-2"></i> Sell on EduuAspire
  </a>

</main>

<?php include_once('footer.php'); ?>

