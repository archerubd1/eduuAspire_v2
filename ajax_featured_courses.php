<?php
include_once("config.php");
header('Content-Type: application/json');

$limit  = 6;
$page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$offset = ($page - 1) * $limit;

// --- Updated SQL (no 'users' table join) ---
$sql = "
SELECT 
    l.id,
    l.name AS course_title,
    l.info AS description,
    l.duration,
    IFNULL(l.course_mode, 'SPL') AS course_mode,
    l.creator_LOGIN,
    cm.badge,
    cm.is_active,
    cm.image,
    d.name AS category_name,
    i.user_login AS instructor_login,
    i.specialty AS instructor_specialty,
    i.avatar AS instructor_avatar
FROM lessons l
JOIN course_marketplace cm ON cm.lesson_id = l.id
LEFT JOIN directions d ON d.id = l.directions_ID
LEFT JOIN instructors i ON i.user_login = l.creator_LOGIN
WHERE cm.is_active = 1
ORDER BY FIELD(cm.badge, 'Featured','Popular','New','Certificate'), l.id DESC
LIMIT $limit OFFSET $offset
";

$result = mysqli_query($coni, $sql);
$courses = array();
$error = "";

if (!$result) {
    $error = mysqli_error($coni);
} elseif (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        // Handle image paths
        $image_path = "assets/img/education/default-course.webp";
        if (!empty($row['image'])) {
            if (strpos($row['image'], 'uploads/') !== false) {
                $image_path = $row['image'];
            } else {
                $image_path = 'uploads/courses/' . $row['image'];
            }
        }

        // Handle instructor avatar
        $avatar = !empty($row['instructor_avatar']) ? $row['instructor_avatar'] : 'assets/img/person/default-avatar.webp';

        $courses[] = array(
            "id" => intval($row['id']),
            "course_title" => $row['course_title'],
            "description" => strip_tags($row['description']),
            "duration" => intval($row['duration']),
            "course_mode" => strtoupper($row['course_mode']),
            "badge" => $row['badge'],
            "image" => $image_path,
            "category_name" => $row['category_name'],
            "instructor_name" => $row['instructor_login'],
            "instructor_specialty" => $row['instructor_specialty'],
            "instructor_avatar" => $avatar
        );
    }
}

echo json_encode(array(
    "success" => true,
    "courses" => $courses,
    "error"   => $error,
    "debug_sql" => $sql
));
?>
