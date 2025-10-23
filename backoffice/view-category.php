<?php
$page = "catalog";
$fun = "categories";
include_once('head_nav.php');
include_once('config.php');

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger'>Invalid category ID.</div>");
}
$id = (int)$_GET['id'];

// Fetch category details
$q = "
    SELECT d.id, d.name, d.parent_direction_ID, d.description, d.active,
           (SELECT COUNT(*) FROM courses c WHERE c.directions_ID = d.id) AS total_courses,
           (SELECT COUNT(*) FROM lessons l WHERE l.directions_ID = d.id) AS total_lessons
    FROM directions d
    WHERE d.id = $id
    LIMIT 1
";
$res = mysqli_query($coni, $q);
$cat = mysqli_fetch_assoc($res);

if (!$cat) {
    die("<div class='alert alert-danger'>Category not found.</div>");
}

// Parent category name
$parentName = "—";
if ($cat['parent_direction_ID']) {
    $p = mysqli_fetch_assoc(mysqli_query($coni, "SELECT name FROM directions WHERE id={$cat['parent_direction_ID']}"));
    $parentName = $p ? $p['name'] : "—";
}
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card">
        <div class="card-header">
          <h4 class="mb-0"><i class="bx bx-category me-2"></i> Category Details</h4>
        </div>
        <div class="card-body">

          <dl class="row">
            <dt class="col-sm-3">Category ID</dt>
            <dd class="col-sm-9"><?= $cat['id'] ?></dd>

            <dt class="col-sm-3">Category Name</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($cat['name']) ?></dd>

            <dt class="col-sm-3">Parent Category</dt>
            <dd class="col-sm-9"><?= htmlspecialchars($parentName) ?></dd>

            <dt class="col-sm-3">Description</dt>
            <dd class="col-sm-9"><?= !empty($cat['description']) ? nl2br(htmlspecialchars($cat['description'])) : "<em>No description</em>" ?></dd>

            <dt class="col-sm-3">Active</dt>
            <dd class="col-sm-9"><?= $cat['active'] ? "✅ Active" : "❌ Inactive" ?></dd>

            <dt class="col-sm-3">Total Courses</dt>
            <dd class="col-sm-9"><span class="badge bg-primary"><?= $cat['total_courses'] ?></span></dd>

            <dt class="col-sm-3">Total Lessons</dt>
            <dd class="col-sm-9"><span class="badge bg-info"><?= $cat['total_lessons'] ?></span></dd>
          </dl>

          <a href="course-categories.php" class="btn btn-secondary">
            <i class="bx bx-arrow-back"></i> Back to Categories
          </a>

        </div>
      </div>

    </div>
  </div>
  <?php include_once('footer.php'); ?>
</div>
