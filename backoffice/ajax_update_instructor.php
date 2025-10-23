<?php
include_once('config.php');
header('Content-Type: application/json');

try {
    $id        = intval($_POST['id']);
    $userLogin = mysqli_real_escape_string($coni, $_POST['user_login']);
    $name      = mysqli_real_escape_string($coni, trim($_POST['name']));
    $surname   = mysqli_real_escape_string($coni, trim($_POST['surname']));
    $email     = mysqli_real_escape_string($coni, trim($_POST['email']));
    $specialty = mysqli_real_escape_string($coni, trim($_POST['specialty']));

    // --- Avatar Upload ---
    $avatar = "";
    $root_upload_dir = dirname(__DIR__) . "/uploads/";
    if (!is_dir($root_upload_dir)) mkdir($root_upload_dir, 0777, true);

    if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $instructor_dir = $root_upload_dir . "instructors/";
        if (!is_dir($instructor_dir)) mkdir($instructor_dir, 0777, true);

        $filename = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['avatar']['name']));
        $target = $instructor_dir . $filename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $avatar = "uploads/instructors/" . $filename;
        }
    }

    // --- Update USERS Table ---
    $userUpdate = "
        UPDATE users 
        SET name='$name', surname='$surname', email='$email'
        WHERE login='$userLogin'
    ";
    mysqli_query($coni, $userUpdate);

    // --- Update INSTRUCTORS Table ---
    $setAvatar = $avatar != "" ? ", avatar='$avatar'" : "";
    $insUpdate = "
        UPDATE instructors 
        SET specialty='$specialty' $setAvatar 
        WHERE id=$id
    ";
    mysqli_query($coni, $insUpdate);

    echo json_encode(array("success" => true, "message" => "Instructor updated successfully!"));
} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => $e->getMessage()));
}
?>
