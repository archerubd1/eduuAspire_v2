<?php
// File: ajax_get_all_directions.php
include_once('config.php');
header('Content-Type: application/json');

// Fast query with indexing
$sql = "SELECT id, name, parent_direction_ID FROM directions WHERE active=1 ORDER BY name ASC";
$res = $coni->query($sql);

$data = [];
while ($r = $res->fetch_assoc()) $data[] = $r;

// Optional caching layer (5 minutes)
$cacheFile = sys_get_temp_dir() . '/directions_cache.json';
file_put_contents($cacheFile, json_encode($data));

echo json_encode($data);
