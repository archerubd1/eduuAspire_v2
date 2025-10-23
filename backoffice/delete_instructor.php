<?php
include_once('config.php');

// --- Validate ID ---
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    die("<div class='alert alert-danger'>Invalid instructor ID.</div>");
}

// --- Fetch instructor record ---
$sql = "SELECT id, user_login, avatar FROM instructors WHERE id=$id LIMIT 1";
$res = mysqli_query($coni, $sql);

if (!$res || mysqli_num_rows($res) == 0) {
    die("<div class='alert alert-warning'>Instructor not found.</div>");
}
$ins = mysqli_fetch_assoc($res);

$userLogin = mysqli_real_escape_string($coni, $ins['user_login']);
$avatar    = $ins['avatar'];

// --- Delete avatar file (if in uploads folder) ---
if (!empty($avatar) && strpos($avatar, 'uploads/instructors/') === 0) {
    $filePath = dirname(__DIR__) . '/' . $avatar;
    if (file_exists($filePath)) {
        @unlink($filePath);
    }
}

// --- Delete instructor record ---
$del1 = mysqli_query($coni, "DELETE FROM instructors WHERE id=$id LIMIT 1");

// --- Optional: remove from users table as well ---
if (!empty($userLogin)) {
    $del2 = mysqli_query($coni, "DELETE FROM users WHERE login='$userLogin' LIMIT 1");
}

// --- Redirect back with message ---
if ($del1) {
    header("Location: instructors-list.php?msg=success&text=Instructor deleted successfully");
    exit;
} else {
    echo "<div class='alert alert-danger'>Error deleting instructor.</div>";
}
?>
