<?php
/**
 * File: instructors-list.php
 * Purpose: Display a list of all instructors in the system
 */

$page = "instructors";
$fun  = "list_ins";

include_once('head_nav.php');
include_once('config.php');
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>

  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

      <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5><i class="bx bx-group me-2"></i> All Instructors</h5>
          <a href="add_instructor.php" class="btn btn-primary btn-sm">
            <i class="bx bx-user-plus me-1"></i> Add New Instructor
          </a>
        </div>

        <div class="card-body">
          <?php
          // Fetch instructors with profile info (LEFT JOIN ensures all instructors appear)
          $query = "
            SELECT 
              i.id,
              i.user_login,
              CONCAT(i.first_name, ' ', i.last_name) AS full_name,
              i.email,
              i.mobile,
              i.specialty,
              i.rating,
              i.total_students,
              i.total_reviews,
              i.active_courses,
              i.verified,
              i.created_at,
              p.qualification,
              p.experience_years,
              p.languages_known,
              p.linkedin_url
            FROM instructors i
            LEFT JOIN instructor_profiles p ON i.id = p.instructor_id
            ORDER BY i.created_at DESC
          ";

          $result = $coni->query($query);

          if (!$result) {
              echo '<div class="alert alert-danger">Error fetching instructors: ' . $coni->error . '</div>';
          } elseif ($result->num_rows == 0) {
              echo '<div class="alert alert-warning">No instructors found.</div>';
          } else {
          ?>
            <div class="table-responsive">
              <table class="table table-striped align-middle">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Instructor</th>
                    <th>Specialty</th>
                    <th>Qualification</th>
                    <th>Experience</th>
                    <th>Students</th>
                    <th>Courses</th>
                    <th>Rating</th>
                    <th>Verified</th>
                    <th>Joined</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $i = 1;
                while ($row = $result->fetch_assoc()) {
                  $verifiedBadge = $row['verified'] ? 
                    '<span class="badge bg-success">Yes</span>' : 
                    '<span class="badge bg-secondary">No</span>';
                  $ratingDisplay = number_format($row['rating'], 1);
                ?>
                  <tr>
                    <td><?php echo $i++; ?></td>
                    <td>
                      <strong><?php echo htmlspecialchars($row['full_name']); ?></strong><br>
                      <small><?php echo htmlspecialchars($row['email']); ?></small><br>
                      <small><i class="bx bx-phone"></i> <?php echo htmlspecialchars($row['mobile']); ?></small>
                    </td>
                    <td><?php echo htmlspecialchars($row['specialty']); ?></td>
                    <td><?php echo htmlspecialchars($row['qualification']); ?></td>
                    <td><?php echo (int)$row['experience_years']; ?> yrs</td>
                    <td><?php echo (int)$row['total_students']; ?></td>
                    <td><?php echo (int)$row['active_courses']; ?></td>
                    <td><span class="badge bg-info"><?php echo $ratingDisplay; ?></span></td>
                    <td><?php echo $verifiedBadge; ?></td>
                    <td><?php echo date("M d, Y", strtotime($row['created_at'])); ?></td>
                    <td>
                      <a href="view_instructor.php?id=<?php echo $row['id']; ?>" 
                         class="btn btn-sm btn-outline-info">
                         <i class="bx bx-show"></i>
                      </a>
                      <a href="edit_instructor.php?id=<?php echo $row['id']; ?>" 
                         class="btn btn-sm btn-outline-primary">
                         <i class="bx bx-edit"></i>
                      </a>
                      <a href="delete_instructor.php?id=<?php echo $row['id']; ?>" 
                         class="btn btn-sm btn-outline-danger" 
                         onclick="return confirm('Are you sure you want to delete this instructor?');">
                         <i class="bx bx-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
                </tbody>
              </table>
            </div>
          <?php } ?>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>
