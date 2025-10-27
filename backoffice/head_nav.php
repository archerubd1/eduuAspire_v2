<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="assets/"
  data-template="vertical-menu-template"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>EduuAspire Marketplace | Admin Panel</title>

    <meta name="description" content="EduuAspire Admin – Manage courses, instructors, learners, and marketplace content." />
    <meta name="author" content="EduuAspire" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/favicon/efaviconrb.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icon Fonts -->
    <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="assets/css/backoffice.css" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

    <!-- Helpers -->
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">

<!-- Sidebar Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="admin-dashboard.php" class="app-brand-link">
      <span class="app-brand-logo demo">
        <img src="assets/img/favicon/efaviconrb.png" width="30" alt="EduuAspire Logo" />
      </span>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">EduuAspire Admin</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>


<P><br><br></p>
<?php if (($page!='login') && ($fun!='login')) { ?>
<ul class="menu-inner py-1">

    
  <!-- Marketplace -->
<li class="<?php echo ($page=='marketplace') ? 'menu-item open active' : 'menu-item'; ?>">
  <a href="javascript:void(0);" class="menu-link menu-toggle">
    <i class="menu-icon tf-icons bx bx-store-alt"></i>
    <div>Marketplace</div>
  </a>
  <ul class="menu-sub">

    <li class="<?php echo ($fun=='market_dashboard') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-dashboard.php" class="menu-link">
        <div>Marketplace Overview</div>
      </a>
    </li>

    <li class="<?php echo ($fun=='market_courses') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-courses.php" class="menu-link">
        <div>Manage Courses</div>
      </a>
    </li>

    <li class="<?php echo ($fun=='market_reviews') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-reviews.php" class="menu-link">
        <div>Reviews & Ratings</div>
      </a>
    </li>

    <li class="<?php echo ($fun=='market_promotions') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-promotions.php" class="menu-link">
        <div>Promotions & Coupons</div>
      </a>
    </li>

    <li class="<?php echo ($fun=='market_banners') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-banners.php" class="menu-link">
        <div>Banners & Highlights</div>
      </a>
    </li>

    <li class="<?php echo ($fun=='market_settings') ? 'menu-item active' : 'menu-item'; ?>">
      <a href="marketplace-settings.php" class="menu-link">
        <div>Settings & Policies</div>
      </a>
    </li>

  </ul>
</li>
  

	
	
	
	 <!-- Instructors -->
    <li class="<?php echo ($page=='instructors') ? 'menu-item open active' : 'menu-item'; ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-user-voice"></i>
        <div>Instructors</div>
      </a>
      <ul class="menu-sub">
	   <li class="<?php echo ($fun=='add_ins') ? 'menu-item active' : 'menu-item'; ?>"><a href="add_instructor.php" class="menu-link"><div>Add Instructor</div></a></li>
        <li class="<?php echo ($fun=='all_ins') ? 'menu-item active' : 'menu-item'; ?>"><a href="instructors-list.php" class="menu-link"><div>All Instructors</div></a></li>
       
      </ul>
    </li>



    <!-- Courses -->
    <li class="<?php echo ($page=='courses') ? 'menu-item open active' : 'menu-item'; ?>">
      <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons bx bx-book"></i>
        <div>Courses</div>
      </a>
      <ul class="menu-sub">
	  <li class="<?php echo ($fun=='categories') ? 'menu-item active' : 'menu-item'; ?>">
          <a href="course-categories.php" class="menu-link"><div>Categories</div></a>
        </li>
        <li class="<?php echo ($fun=='add_course') ? 'menu-item active' : 'menu-item'; ?>">
          <a href="add_course.php" class="menu-link"><div>Add New Course</div></a>
        </li>
		 <li class="<?php echo ($fun=='lessons') ? 'menu-item active' : 'menu-item'; ?>">
          <a href="course-lessons.php" class="menu-link"><div>Add Course Lessons</div></a>
        </li>
        <li class="<?php echo ($fun=='all_courses') ? 'menu-item active' : 'menu-item'; ?>">
          <a href="courses-list.php" class="menu-link"><div>All Courses</div></a>
        </li>
        
      </ul>
    </li>

  
   

</ul>
<?php } ?>
</aside>
<!-- / Sidebar Menu -->
