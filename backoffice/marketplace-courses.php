<?php
$page = "marketplace";
$fun  = "market_courses";
include_once('head_nav.php');
include_once('config.php');

$q = mysqli_query($coni, "
  SELECT 
    l.id, l.name, CONCAT(i.first_name,' ',i.last_name) AS instructor,
    cm.price, cm.discount_price, cm.badge, cm.is_active, cm.image
  FROM lessons l
  LEFT JOIN instructors i ON i.user_login = l.creator_login
  LEFT JOIN course_marketplace cm ON cm.lesson_id = l.id
  WHERE l.active = 1
  ORDER BY l.name ASC
");
?>

<div class="layout-page">
  <?php include_once('nav_search.php'); ?>
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="mb-4"><i class="bx bx-store-alt me-2"></i> Marketplace Courses Management</h4>

      <div class="card shadow-sm">
        <div class="card-body">
          <div class="table-responsive">
            <table id="marketCourses" class="table table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>#</th>
                  <th>Image</th>
                  <th>Course</th>
                  <th>Instructor</th>
                  <th>Price</th>
                  <th>Discount</th>
                  <th>Badge</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $i=1;
              while($c=mysqli_fetch_assoc($q)){
                $status = $c['is_active'] ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-secondary'>Hidden</span>";
                echo "<tr>
                  <td>{$i}</td>
                  <td><img src='{$c['image']}' width='60' class='rounded'></td>
                  <td><strong>".htmlspecialchars($c['name'])."</strong></td>
                  <td>".htmlspecialchars($c['instructor'])."</td>
                  <td>₹".number_format($c['price'],2)."</td>
                  <td>".($c['discount_price'] ? "₹".number_format($c['discount_price'],2) : '—')."</td>
                  <td>".htmlspecialchars($c['badge'])."</td>
                  <td>{$status}</td>
                  <td>
                    <a href='edit_course.php?edit={$c['id']}' class='btn btn-sm btn-outline-primary'><i class='bx bx-edit'></i></a>
                    <button class='btn btn-sm btn-outline-warning' onclick='toggleStatus({$c['id']})'><i class='bx bx-power-off'></i></button>
                  </td>
                </tr>";
                $i++;
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
    <?php include_once('footer.php'); ?>
  </div>
</div>

<script>
function toggleStatus(id){
  if(!confirm("Toggle this course’s marketplace visibility?")) return;
  $.post("ajax_toggle_market_status.php", {id:id}, function(res){
    try {
      const data = JSON.parse(res);
      alert(data.message);
      if(data.success) location.reload();
    } catch(e){ alert("Unexpected error."); }
  });
}
</script>
