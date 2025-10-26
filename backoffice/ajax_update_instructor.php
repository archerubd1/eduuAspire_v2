<?php
/**
 * AJAX Update Instructor (HARD DEBUG MODE)
 * Compatible with PHP 5.4
 */

error_reporting(E_ALL);
ini_set('display_errors', '0');
ini_set('log_errors', '1');
ini_set('error_log', __DIR__ . '/php_error.log');
header('Content-Type: application/json; charset=utf-8');
ob_clean();

$logfile = __DIR__ . '/update_debug.log';
file_put_contents($logfile, "---- " . date('Y-m-d H:i:s') . " ----\n", FILE_APPEND);

function log_step($msg) {
    global $logfile;
    file_put_contents($logfile, $msg . "\n", FILE_APPEND);
}

function json_response($success, $message) {
    log_step("RETURN: " . ($success ? "SUCCESS" : "FAIL") . " - " . $message);
    echo json_encode(array('success' => $success, 'message' => $message));
    flush();
    exit;
}

log_step("Script started.");

// --- CONFIG & DB CONNECTION ---
require_once 'config.php';

if (!isset($coni)) {
    log_step("ERROR: DB variable \$coni missing.");
    json_response(false, "Database variable missing (check config.php).");
}

if ($coni->connect_errno) {
    log_step("ERROR: DB connection failed - " . $coni->connect_error);
    json_response(false, "Database connection failed.");
}

log_step("DB connected successfully.");

// --- VALIDATE ID ---
if (!isset($_POST['id']) || !is_numeric($_POST['id'])) {
    log_step("ERROR: Invalid instructor ID");
    json_response(false, "Invalid instructor ID.");
}
$id = (int)$_POST['id'];
log_step("Instructor ID = $id");

// --- COLLECT FIELDS ---
$login        = trim(isset($_POST['login']) ? $_POST['login'] : '');
$name         = trim(isset($_POST['name']) ? $_POST['name'] : '');
$surname      = trim(isset($_POST['surname']) ? $_POST['surname'] : '');
$email        = trim(isset($_POST['email']) ? $_POST['email'] : '');
$mobile       = trim(isset($_POST['mobile']) ? $_POST['mobile'] : '');
$specialty    = trim(isset($_POST['specialty']) ? $_POST['specialty'] : '');
$qualification= trim(isset($_POST['qualification']) ? $_POST['qualification'] : '');
$experience   = (int)(isset($_POST['experience']) ? $_POST['experience'] : 0);
$languages    = trim(isset($_POST['languages']) ? $_POST['languages'] : '');
$linkedin     = trim(isset($_POST['linkedin']) ? $_POST['linkedin'] : '');
$facebook     = trim(isset($_POST['facebook']) ? $_POST['facebook'] : '');
$youtube      = trim(isset($_POST['youtube']) ? $_POST['youtube'] : '');
$bio          = trim(isset($_POST['bio']) ? $_POST['bio'] : '');
$achievements = trim(isset($_POST['achievements']) ? $_POST['achievements'] : '');
$location     = trim(isset($_POST['location']) ? $_POST['location'] : '');
$website      = trim(isset($_POST['website']) ? $_POST['website'] : '');
$verified     = isset($_POST['verified']) ? 1 : 0;

log_step("Collected POST data OK.");

// --- UPDATE instructors ---
$sql1 = "UPDATE instructors 
         SET user_login=?, first_name=?, last_name=?, email=?, mobile=?, specialty=?, verified=? 
         WHERE id=?";
$stmt1 = $coni->prepare($sql1);

if (!$stmt1) {
    log_step("ERROR: Prepare1 failed - " . $coni->error);
    json_response(false, "Prepare failed: " . $coni->error);
}

if (!$stmt1->bind_param("ssssssii", $login, $name, $surname, $email, $mobile, $specialty, $verified, $id)) {
    log_step("ERROR: Bind1 failed - " . $stmt1->error);
    json_response(false, "Bind failed: " . $stmt1->error);
}

if (!$stmt1->execute()) {
    log_step("ERROR: Execute1 failed - " . $stmt1->error);
    json_response(false, "Execute failed: " . $stmt1->error);
}

$stmt1->close();
log_step("Instructor table updated successfully.");

// --- CHECK PROFILE ---
$sql_check = "SELECT id FROM instructor_profiles WHERE instructor_id=?";
$stmt_check = $coni->prepare($sql_check);
if (!$stmt_check) {
    log_step("ERROR: Prepare check failed - " . $coni->error);
    json_response(false, "Prepare check failed: " . $coni->error);
}
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$stmt_check->store_result();
$profile_exists = $stmt_check->num_rows > 0;
$stmt_check->close();

log_step("Profile exists? " . ($profile_exists ? "YES" : "NO"));

// --- UPDATE or INSERT profile ---
if ($profile_exists) {
    $sql2 = "UPDATE instructor_profiles 
             SET qualification=?, experience_years=?, languages_known=?, achievements=?, linkedin_url=?, facebook_url=?, youtube_url=?, bio=?, location=?, website=? 
             WHERE instructor_id=?";
    $stmt2 = $coni->prepare($sql2);
    if (!$stmt2) {
        log_step("ERROR: Prepare2 failed - " . $coni->error);
        json_response(false, "Prepare2 failed: " . $coni->error);
    }
    $stmt2->bind_param("sissssssssi", $qualification, $experience, $languages, $achievements, $linkedin, $facebook, $youtube, $bio, $location, $website, $id);
} else {
    $sql2 = "INSERT INTO instructor_profiles (instructor_id, qualification, experience_years, languages_known, achievements, linkedin_url, facebook_url, youtube_url, bio, location, website)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt2 = $coni->prepare($sql2);
    if (!$stmt2) {
        log_step("ERROR: Prepare insert failed - " . $coni->error);
        json_response(false, "Prepare insert failed: " . $coni->error);
    }
    $stmt2->bind_param("isissssssss", $id, $qualification, $experience, $languages, $achievements, $linkedin, $facebook, $youtube, $bio, $location, $website);
}

if (!$stmt2->execute()) {
    log_step("ERROR: Execute2 failed - " . $stmt2->error);
    json_response(false, "Execute2 failed: " . $stmt2->error);
}
$stmt2->close();
log_step("Profile updated successfully.");

// --- FINAL SUCCESS ---
json_response(true, "Instructor '{$name} {$surname}' updated successfully.");
?>
