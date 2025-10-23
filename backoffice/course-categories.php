<?php
// ============================================
// File: course-categories.php
// Optimized version with fast query & profiling
// ============================================

$page = "courses";
$fun  = "categories";
include_once('head_nav.php');
include_once('config.php');

// Enable detailed MySQL errors
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Start profiling
$startTime = microtime(true);

// ===== CATEGORY COUNT =====
$categoryCount = (int) $coni->query("SELECT COUNT(*) AS cnt FROM directions WHERE active=1")->fetch_assoc()['cnt'];

// ===== PAGINATION SETTINGS =====
$limit = 25; // items per page
$pageNo = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($pageNo - 1) * $limit;

// ===== OPTIMIZED QUERY =====
$query = "
  SELECT 
    d.id,
    d.name,
    d.parent_direction_ID,
    p.name AS parent_name,
    COUNT(DISTINCT cm.id) AS total_courses,
    COUNT(DISTINCT l.id) AS total_lessons
  FROM directions d
  LEFT JOIN lessons l ON l.directions_ID = d.id
  LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
  LEFT JOIN directions p ON p.id = d.parent_direction_ID
  WHERE d.active = 1
  GROUP BY d.id, d.name, d.parent_direction_ID, p.name
  ORDER BY d.name ASC
  LIMIT $limit OFFSET $offset
";

$res = $coni->query($query);
$queryTime = round((microtime(true) - $startTime) * 1000, 2); // in ms

// ===== TOTAL PAGES =====
$totalPages = ceil($categoryCount / $limit);
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <!-- Alerts -->
      <?php if (isset($_GET['msg'])): ?>
        <?php if ($_GET['msg'] === 'success'): ?>
          <div class="alert alert-success">✅ Category added successfully!</div>
        <?php elseif ($_GET['msg'] === 'error'): ?>
          <div class="alert alert-danger">❌ Error while adding category. Please try again.</div>
        <?php endif; ?>
      <?php endif; ?>

      <!-- Stats -->
      <div class="row mb-4">
        <div class="col-md-4">
          <div class="card text-center">
            <div class="card-body">
              <h5>Total Categories</h5>
              <h2><?= $categoryCount ?></h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Categories Table -->
      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0"><i class="bx bx-category me-2"></i> All Course Categories</h5>
          <small class="text-muted">Query Time: <?= $queryTime ?> ms</small>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Category Name</th>
                <th>Parent Category</th>
                <th>Total Marketplace Courses</th>
                <th>Total Lessons</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($res->num_rows > 0): ?>
                <?php while ($row = $res->fetch_assoc()): ?>
                  <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= $row['parent_name'] ? htmlspecialchars($row['parent_name']) : "—" ?></td>
                    <td><?= $row['total_courses'] ?></td>
                    <td><?= $row['total_lessons'] ?></td>
                    <td>
                      <a href="view_category.php?id=<?= $row['id'] ?>" class="btn btn-info btn-sm">
                        <i class="bx bx-show"></i> View
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="6" class="text-center text-muted">No categories found.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- Pagination -->
          <nav>
            <ul class="pagination justify-content-center mt-3">
              <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= $i === $pageNo ? 'active' : '' ?>">
                  <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
              <?php endfor; ?>
            </ul>
          </nav>
        </div>
      </div>

      <!-- Add Category Form -->
      <div class="col-xl mt-4">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Add New Category</h5>
          </div>
          <div class="card-body">
            <form action="process-category.php" method="POST">
              <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter category name" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Parent Category</label>
                <select name="parent_direction_ID" class="form-select">
                  <option value="">None</option>
                  <?php
                  $cats = $coni->query("SELECT id, name FROM directions WHERE active=1 ORDER BY name ASC");
                  while ($c = $cats->fetch_assoc()):
                  ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Enter short description"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">
                <i class="bx bx-check-circle me-1"></i> Save Category
              </button>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

  <?php include_once('footer.php'); ?>
</div>
