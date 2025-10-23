<?php
$page = "courses";
$fun  = "categories";
include_once('head_nav.php');
include_once('config.php');

// ---------------------------
// Validate & Fetch Category
// ---------------------------
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($category_id <= 0) {
    die("<div class='alert alert-danger m-4'>❌ Invalid category ID.</div>");
}

$sql = "
    SELECT d.id, d.name, d.description, d.parent_direction_ID, d.active,
           p.name AS parent_name
    FROM directions d
    LEFT JOIN directions p ON p.id = d.parent_direction_ID
    WHERE d.id = $category_id
    LIMIT 1
";
$res = mysqli_query($coni, $sql);
if (!$res || mysqli_num_rows($res) == 0) {
    die("<div class='alert alert-danger m-4'>❌ Category not found.</div>");
}
$category = mysqli_fetch_assoc($res);

// ---------------------------
// Fetch Subcategories
// ---------------------------
$subcats = mysqli_query($coni, "
    SELECT id, name, description
    FROM directions
    WHERE parent_direction_ID = $category_id AND active=1
    ORDER BY name ASC
");

// ---------------------------
// Fetch Lessons & Courses
// ---------------------------
$courses_sql = "
    SELECT 
        l.id AS lesson_id,
        l.name AS lesson_name,
        l.info AS description,
        l.duration,
        l.price,
        i.user_login AS instructor,
        i.specialty,
        cm.id AS marketplace_id,
        cm.subtitle,
        cm.discount_price,
        cm.badge,
        cm.image
    FROM lessons l
    LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
    LEFT JOIN instructors i ON i.user_login = l.creator_LOGIN
    WHERE l.directions_ID = $category_id
    ORDER BY l.created DESC
";
$courses = mysqli_query($coni, $courses_sql);
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Breadcrumb -->
      <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="course-categories.php">Categories</a></li>
          <?php if (!empty($category['parent_name'])): ?>
            <li class="breadcrumb-item"><?php echo htmlspecialchars($category['parent_name']); ?></li>
          <?php endif; ?>
          <li class="breadcrumb-item active"><?php echo htmlspecialchars($category['name']); ?></li>
        </ol>
      </nav>

      <!-- Category Header -->
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="bx bx-category me-2"></i> 
            <?php echo htmlspecialchars($category['name']); ?>
          </h5>
          <?php if ($category['active'] == 1): ?>
            <span class="badge bg-success">Active</span>
          <?php else: ?>
            <span class="badge bg-secondary">Inactive</span>
          <?php endif; ?>
        </div>
        <div class="card-body">
          <?php if (!empty($category['description'])): ?>
            <p><?php echo nl2br(htmlspecialchars($category['description'])); ?></p>
          <?php else: ?>
            <p class="text-muted fst-italic">No description provided.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Subcategories -->
      <?php if (mysqli_num_rows($subcats) > 0): ?>
      <div class="card mb-4">
        <div class="card-header">
          <h6><i class="bx bx-git-branch me-2"></i> Subcategories</h6>
        </div>
        <div class="card-body">
          <div class="list-group">
            <?php while ($sub = mysqli_fetch_assoc($subcats)): ?>
              <a href="view_category.php?id=<?php echo $sub['id']; ?>" class="list-group-item list-group-item-action">
                <strong><?php echo htmlspecialchars($sub['name']); ?></strong>
                <?php if (!empty($sub['description'])): ?>
                  <div class="small text-muted"><?php echo htmlspecialchars($sub['description']); ?></div>
                <?php endif; ?>
              </a>
            <?php endwhile; ?>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- Courses & Lessons -->
      <div class="card">
        <div class="card-header">
          <h6><i class="bx bx-book-open me-2"></i> Courses and Lessons in this Category</h6>
        </div>
        <div class="card-body">
          <?php if (mysqli_num_rows($courses) > 0): ?>
            <div class="table-responsive">
              <table class="table table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th>ID</th>
                    <th>Course</th>
                    <th>Instructor</th>
                    <th>Price</th>
                    <th>Badge</th>
                    <th>Duration (weeks)</th>
                    <th>Marketplace</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($c = mysqli_fetch_assoc($courses)): ?>
                    <tr>
                      <td><?php echo $c['lesson_id']; ?></td>
                      <td>
                        <strong><?php echo htmlspecialchars($c['lesson_name']); ?></strong><br>
                        <small class="text-muted">
                          <?php echo isset($c['subtitle']) ? htmlspecialchars($c['subtitle']) : ''; ?>
                        </small>
                      </td>
                      <td><?php echo !empty($c['instructor']) ? htmlspecialchars($c['instructor']) : '—'; ?></td>
                      <td>
                        ₹<?php
                          $price = $c['discount_price'] > 0 ? $c['discount_price'] : $c['price'];
                          echo number_format($price, 2);
                        ?>
                      </td>
                      <td>
                        <?php
                          if (!empty($c['badge'])) {
                              echo "<span class='badge bg-info'>" . htmlspecialchars($c['badge']) . "</span>";
                          } else {
                              echo "—";
                          }
                        ?>
                      </td>
                      <td><?php echo intval($c['duration']); ?></td>
                      <td>
                        <?php if (!empty($c['marketplace_id'])): ?>
                          <i class="bx bx-check text-success"></i> Listed
                        <?php else: ?>
                          <i class="bx bx-x text-danger"></i> Not listed
                        <?php endif; ?>
                      </td>
                      <td>
                        <a href="../course-details.php?course=<?php echo $c['lesson_id']; ?>" class="btn btn-sm btn-primary" target="_blank">
                          <i class="bx bx-show"></i> View
                        </a>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p class="text-muted text-center">No lessons or courses found for this category.</p>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </div>

  <?php include_once('footer.php'); ?>
</div>
