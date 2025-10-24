<?php
/**
 * File: ajax_add_instructor.php
 * Purpose: Handle instructor creation from add_instructor.php
 * Output: Always returns clean JSON (no HTML)
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json; charset=utf-8');

// === Load DB connection ===
// config.php must define $coni = new mysqli(...);
require_once 'config.php';

/**
 * Output JSON response and stop execution.
 */
function json_response($success, $message) {
    echo json_encode(array(
        'success' => $success,
        'message' => $message
    ));
    exit;
}

try {

    // === 1️⃣ Validate Required Fields ===
    $required = array('login', 'name', 'email');
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || trim($_POST[$field]) === '') {
            json_response(false, 'Missing required field: ' . ucfirst($field));
        }
    }

    // === 2️⃣ Sanitize Inputs ===
    $login        = trim($_POST['login']);
    $first_name   = trim($_POST['name']);
    $last_name    = isset($_POST['surname']) ? trim($_POST['surname']) : '';
    $email        = trim($_POST['email']);
    $mobile       = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';
    $specialty    = isset($_POST['specialty']) ? trim($_POST['specialty']) : '';
    $qualification = isset($_POST['qualification']) ? trim($_POST['qualification']) : '';
    $experience   = isset($_POST['experience']) ? (int)$_POST['experience'] : 0;
    $languages    = isset($_POST['languages']) ? trim($_POST['languages']) : '';
    $linkedin     = isset($_POST['linkedin']) ? trim($_POST['linkedin']) : '';
    $facebook     = isset($_POST['facebook']) ? trim($_POST['facebook']) : '';
    $youtube      = isset($_POST['youtube']) ? trim($_POST['youtube']) : '';
    $bio          = isset($_POST['bio']) ? trim($_POST['bio']) : '';
    $achievements = isset($_POST['achievements']) ? trim($_POST['achievements']) : '';
    $location     = isset($_POST['location']) ? trim($_POST['location']) : '';
    $office_hours = isset($_POST['office_hours']) ? trim($_POST['office_hours']) : '';
    $website      = isset($_POST['website']) ? trim($_POST['website']) : '';
    $verified     = isset($_POST['verified']) ? 1 : 0;

    // === 3️⃣ Handle Avatar Upload ===
    $avatar_path = isset($_POST['avatar_default']) && $_POST['avatar_default'] != ''
        ? $_POST['avatar_default']
        : 'assets/img/person/default-avatar.webp';

    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/instructors/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png', 'webp');
        if (!in_array($ext, $allowed_exts)) {
            json_response(false, 'Invalid avatar file type. Allowed: JPG, PNG, WEBP.');
        }

        $filename = 'avatar_' . uniqid('', true) . '.' . $ext;
        $target_path = $upload_dir . $filename;

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_path)) {
            $avatar_path = 'uploads/instructors/' . $filename;
        }
    }

    // === 4️⃣ Check for Duplicate user_login or email ===
    $check = $coni->prepare("SELECT id FROM instructors WHERE user_login = ? OR email = ?");
    $check->bind_param("ss", $login, $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        $check->close();
        json_response(false, 'Instructor with this login or email already exists.');
    }
    $check->close();

    // === 5️⃣ Insert into instructors table ===
    $stmt1 = $coni->prepare("
        INSERT INTO instructors 
        (user_login, first_name, last_name, email, mobile, avatar, specialty, verified)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt1->bind_param(
        "sssssssi",
        $login,
        $first_name,
        $last_name,
        $email,
        $mobile,
        $avatar_path,
        $specialty,
        $verified
    );

    if (!$stmt1->execute()) {
        json_response(false, 'Failed to insert instructor: ' . $stmt1->error);
    }

    $instructor_id = $stmt1->insert_id;
    $stmt1->close();

    // === 6️⃣ Insert into instructor_profiles table ===
    $stmt2 = $coni->prepare("
        INSERT INTO instructor_profiles
        (instructor_id, qualification, experience_years, languages_known, achievements, 
         linkedin_url, facebook_url, youtube_url, bio, location, office_hours, website)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt2->bind_param(
        "isisssssssss",
        $instructor_id,
        $qualification,
        $experience,
        $languages,
        $achievements,
        $linkedin,
        $facebook,
        $youtube,
        $bio,
        $location,
        $office_hours,
        $website
    );

    if (!$stmt2->execute()) {
        json_response(false, 'Failed to insert instructor profile: ' . $stmt2->error);
    }
    $stmt2->close();

    // === 7️⃣ Success JSON ===
    json_response(true, "Instructor '" . $first_name . " " . $last_name . "' added successfully.");

} catch (Exception $e) {
    // PHP 5.4 safe fallback — no Throwable support yet
    error_log('Error in ajax_add_instructor.php: ' . $e->getMessage());
    json_response(false, 'Server Error: ' . $e->getMessage());
}
?>
