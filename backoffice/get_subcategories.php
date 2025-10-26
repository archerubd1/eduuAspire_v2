<?php
// backoffice/get_subcategories.php
include_once('../config.php'); // adjust path if this file is in other folder

$parent_id = isset($_GET['parent_id']) ? intval($_GET['parent_id']) : 0;

header('Content-Type: text/html; charset=utf-8');

if ($parent_id <= 0) {
    echo '<option value="">Select Subcategory</option>';
    exit;
}

$sql = "SELECT id, name 
        FROM directions 
        WHERE direction_type='Subcategory' 
          AND parent_direction_ID = " . $parent_id . " 
          AND active = 1
        ORDER BY name ASC";

$res = mysqli_query($coni, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    echo '<option value="">Select Subcategory</option>';
    while ($r = mysqli_fetch_assoc($res)) {
        echo '<option value="' . intval($r['id']) . '">' . htmlspecialchars($r['name']) . '</option>';
    }
} else {
    echo '<option value="">No subcategories</option>';
}
