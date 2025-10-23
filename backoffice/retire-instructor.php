<?php
include_once('config.php');

$id = intval($_GET['id'] ?? 0);
if ($id > 0) {
    // Soft delete (mark inactive)
    $coni->query("UPDATE instructors SET active=0 WHERE id=$id");
    header("Location: instructors-list.php?msg=success&text=" . urlencode("Instructor retired successfully"));
    exit;
}
header("Location: instructors-list.php?msg=error&text=" . urlencode("Invalid instructor ID"));
exit;
?>
