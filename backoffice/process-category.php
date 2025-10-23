<?php
include_once("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name        = $coni->real_escape_string($_POST['name']);
    $description = !empty($_POST['description']) ? $coni->real_escape_string($_POST['description']) : '';
    $parent_id   = !empty($_POST['parent_direction_ID']) ? intval($_POST['parent_direction_ID']) : NULL;
    $active      = isset($_POST['active']) ? intval($_POST['active']) : 1;

    // Insert into directions table
    if ($parent_id) {
        $sql = "INSERT INTO directions (name, description, parent_direction_ID, active) 
                VALUES ('$name', '$description', $parent_id, $active)";
    } else {
        $sql = "INSERT INTO directions (name, description, active) 
                VALUES ('$name', '$description', $active)";
    }

    if ($coni->query($sql)) {
        // Success → Redirect to course-categories
        header("Location: course-categories.php?msg=success");
        exit;
    } else {
        // Error → Redirect with error flag
        header("Location: course-categories.php?msg=error");
        exit;
    }
} else {
    // Invalid access → Redirect back
    header("Location: course-categories.php");
    exit;
}
?>
