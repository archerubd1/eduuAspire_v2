<?php
session_start();
include 'config.php';  // Ensure $coni is your valid mysqli connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usernameOrEmail = trim($_POST['username']);
    $password        = $_POST['password'];

    $sql = "SELECT id, username, email, password_hash, full_name, role, status FROM adminuser WHERE username = ? OR email = ?";
    $stmt = $coni->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: (" . $coni->errno . ") " . $coni->error);
    }

    $stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($id, $username, $email, $password_hash, $full_name, $role, $status);

    if ($stmt->fetch()) {  // If user is found
        if ($status !== 'active') {
            $_SESSION['message']  = "Your account is not active. Please contact admin.";
            $_SESSION['msg_type'] = "warning";
            header("Location: index.php");
            exit();
        }

        if (md5($password) === $password_hash) {
            // Login success
            $_SESSION['user_id']    = $id;
            $_SESSION['username']   = $username;
            $_SESSION['full_name']  = $full_name;
            $_SESSION['role']       = $role;
            $_SESSION['message']    = "Login successful!";
            $_SESSION['msg_type']   = "success";

            header("Location: marketplace-dashboard.php");
            exit();
        } else {
            $_SESSION['message']  = "Invalid password.";
            $_SESSION['msg_type'] = "danger";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['message']  = "User not found.";
        $_SESSION['msg_type'] = "danger";
        header("Location: index.php");
        exit();
    }

    $stmt->close();
}

$coni->close();
?>
