<?php
include_once('config.php');
header('Content-Type: application/json');

define("G_MD5KEY", 'cDWQR#$Rcxsc'); // same as in eFront

try {
    // --- Sanitize Inputs ---
    $login     = $coni->real_escape_string(trim($_POST['login']));
    $name      = $coni->real_escape_string(trim($_POST['name']));
    $surname   = $coni->real_escape_string(trim($_POST['surname']));
    $email     = $coni->real_escape_string(trim($_POST['email']));
    $mobile    = $coni->real_escape_string(trim($_POST['mobile']));
    $specialty = $coni->real_escape_string(trim($_POST['specialty']));

    // --- Upload Directory ---
    $root_upload_dir = dirname(__DIR__) . "/uploads/";
    if (!is_dir($root_upload_dir)) mkdir($root_upload_dir, 0777, true);

    $avatar = "assets/img/person/default-avatar.webp";

    // --- Avatar Handling ---
    if (!empty($_POST['avatar_default'])) {
        $avatar = $_POST['avatar_default'];
    } elseif (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $instructor_dir = $root_upload_dir . "instructors/";
        if (!is_dir($instructor_dir)) mkdir($instructor_dir, 0777, true);

        $filename = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['avatar']['name']));
        $target   = $instructor_dir . $filename;
        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target)) {
            $avatar = "uploads/instructors/" . $filename;
        }
    }

    // --- Ensure USERS Table Exists ---
    $userCheck = $coni->query("SHOW TABLES LIKE 'users'");
    if ($userCheck->num_rows == 0) {
        $coni->query("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            login VARCHAR(100) UNIQUE,
            password VARCHAR(255),
            name VARCHAR(100),
            surname VARCHAR(100),
            email VARCHAR(255),
            comments TEXT,
            user_type VARCHAR(50),
            avatar VARCHAR(255),
            active TINYINT DEFAULT 1,
            timestamp INT DEFAULT 0
        )");
    }

    // --- Add / Update USERS Table ---
    $timestamp = time();
    $passwordPattern = md5($login . "_" . $timestamp . G_MD5KEY);

    $checkUser = $coni->query("SELECT id FROM users WHERE login='$login' LIMIT 1");

    if ($checkUser && $checkUser->num_rows == 0) {
        $coni->query("INSERT INTO users (login, password, email, name, surname, active, user_type, timestamp, avatar, comments)
                      VALUES ('$login', '$passwordPattern', '$email', '$name', '$surname', 1, 'instructor', $timestamp, '$avatar', '$mobile')");
    } else {
        $coni->query("UPDATE users 
                      SET name='$name', surname='$surname', email='$email', comments='$mobile', avatar='$avatar', active=1, user_type='instructor' 
                      WHERE login='$login'");
    }

    // --- Add / Update INSTRUCTORS Table ---
    $checkInstr = $coni->query("SELECT id FROM instructors WHERE user_login='$login' LIMIT 1");
    if ($checkInstr && $checkInstr->num_rows == 0) {
        $coni->query("INSERT INTO instructors (user_login, specialty, avatar, rating, total_reviews)
                      VALUES ('$login', '$specialty', '$avatar', 4.5, 0)");
    } else {
        $coni->query("UPDATE instructors 
                      SET specialty='$specialty', avatar='$avatar' 
                      WHERE user_login='$login'");
    }

    echo json_encode(array("success" => true, "message" => "✅ Instructor $name $surname added/updated successfully!"));

} catch (Exception $e) {
    echo json_encode(array("success" => false, "message" => "❌ Error: " . $e->getMessage()));
}
?>
