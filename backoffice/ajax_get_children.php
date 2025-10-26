<?php
// ajax_get_children.php
// Returns JSON array of children for a given directions.parent_direction_ID
header('Content-Type: application/json; charset=utf-8');
include_once('config.php');

// Accept parent_id via GET (or fallback to 0)
$parent_id = isset($_GET['parent_id']) ? trim($_GET['parent_id']) : '0';

// Security: allow only integers (or 0)
if ($parent_id === '' || !is_numeric($parent_id)) $parent_id = '0';

$parent_id = (int)$parent_id;

$result = array();

if ($parent_id === 0) {
    // top-level: parent_direction_ID IS NULL
    $sql = "SELECT id, name FROM directions WHERE parent_direction_ID IS NULL AND active=1 ORDER BY name ASC";
    $q = $coni->query($sql);
    if ($q) {
        while ($r = $q->fetch_assoc()) $result[] = $r;
    }
} else {
    // children of given parent id
    $stmt = $coni->prepare("SELECT id, name FROM directions WHERE parent_direction_ID = ? AND active=1 ORDER BY name ASC");
    if ($stmt) {
        $stmt->bind_param('i', $parent_id);
        $stmt->execute();
        $q = $stmt->get_result();
        while ($r = $q->fetch_assoc()) $result[] = $r;
        $stmt->close();
    } else {
        // fallback: return empty list on error
        $result = array();
    }
}

// Return JSON
echo json_encode($result);
exit;
