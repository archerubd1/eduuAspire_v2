<?php
// ajax_add_course.php — PHP 5.4 compatible, clean JSON output

include_once('config.php');
header('Content-Type: application/json');

// Turn off on-screen errors (to prevent <br/> output in JSON)
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/ajax_add_course_errors.log');

// helper
function safe($k) { return isset($_POST[$k]) ? trim($_POST[$k]) : ''; }

try {
    // === INPUTS ===
    $title          = safe('title');
    $subtitle       = safe('subtitle');
    $description    = safe('description');
    $duration       = isset($_POST['duration']) ? (int) $_POST['duration'] : 0;
    $price          = isset($_POST['price']) ? (float) $_POST['price'] : 0.0;
    $discount_price = isset($_POST['discount_price']) ? (float) $_POST['discount_price'] : 0.0;
    $badge          = safe('badge');
    $course_mode    = safe('course_mode');
    $specialty      = safe('specialty');
    $instructor     = safe('instructor_login');

    // Hierarchy
    $parent_direction_id = isset($_POST['parent_direction_id']) ? (int) $_POST['parent_direction_id'] : 0; 
    $subcategory_id      = isset($_POST['subcategory_id']) ? (int) $_POST['subcategory_id'] : 0;         
    $board_name          = safe('board_name'); 
    $class_direction_id  = isset($_POST['sub_direction_id']) ? (int) $_POST['sub_direction_id'] : 0; 

    // Meta
    $meta_overview   = safe('meta_overview');
    $meta_skills     = safe('meta_skills');
    $meta_objectives = safe('meta_objectives');
    $meta_audience   = safe('meta_audience');
    $modules         = isset($_POST['modules']) ? $_POST['modules'] : array();

    if ($title == '' || $parent_direction_id == 0) {
        throw new Exception("Missing mandatory fields: title / hierarchy.");
    }

    // === UPLOADS ===
    $uploadDir = dirname(__DIR__) . '/uploads/courses/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

    $course_image = '';
    $meta_brochure = '';

    if (isset($_FILES['course_image']) && $_FILES['course_image']['name'] != '') {
        $imgName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES['course_image']['name']);
        if (move_uploaded_file($_FILES['course_image']['tmp_name'], $uploadDir . $imgName)) {
            $course_image = 'uploads/courses/' . $imgName;
        }
    }

    if (isset($_FILES['meta_brochure']) && $_FILES['meta_brochure']['name'] != '') {
        $broName = time() . '_' . preg_replace('/[^A-Za-z0-9.\-_]/', '', $_FILES['meta_brochure']['name']);
        if (move_uploaded_file($_FILES['meta_brochure']['tmp_name'], $uploadDir . $broName)) {
            $meta_brochure = 'uploads/courses/' . $broName;
        }
    }

    $created_time = time();

    // === LESSONS TABLE ===
    $stmt = $coni->prepare("
        INSERT INTO lessons
        (name, info, duration, price, direction_id, sub_direction_id, board, creator_LOGIN,
         active, show_catalog, publish, created, course_mode)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'admin', 1, 1, 1, ?, ?)
    ");
    if (!$stmt) throw new Exception('Prepare failed (lessons): ' . $coni->error);

    $stmt->bind_param(
        'ssdiissis',
        $title, $description, $duration, $price,
        $parent_direction_id, $subcategory_id, $board_name, $created_time, $course_mode
    );
    $stmt->execute();
    $lesson_id = $stmt->insert_id;
    $stmt->close();

    // === COURSE MARKETPLACE ===
    $stmt2 = $coni->prepare("
        INSERT INTO course_marketplace
        (lesson_id, subtitle, price, discount_price, badge, image, featured, is_active)
        VALUES (?, ?, ?, ?, ?, ?, 'No', 1)
    ");
    if (!$stmt2) throw new Exception('Prepare failed (course_marketplace): ' . $coni->error);
    $stmt2->bind_param('isddss', $lesson_id, $subtitle, $price, $discount_price, $badge, $course_image);
    $stmt2->execute();
    $stmt2->close();

    // === COURSE METADATA ===
    $bro_type = $meta_brochure ? pathinfo($meta_brochure, PATHINFO_EXTENSION) : '';
    $stmt3 = $coni->prepare("
        INSERT INTO course_metadata
        (course_id, overview, skills, objectives, audience, brochure_path, brochure_type)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    if (!$stmt3) throw new Exception('Prepare failed (course_metadata): ' . $coni->error);
    $stmt3->bind_param('issssss', $lesson_id, $meta_overview, $meta_skills, $meta_objectives, $meta_audience, $meta_brochure, $bro_type);
    $stmt3->execute();
    $stmt3->close();

    // === MODULES & CONTENT ===
    if (is_array($modules) && count($modules) > 0) {
        $stmtMod = $coni->prepare("INSERT INTO modules (course_id, module_title, module_description, created) VALUES (?, ?, ?, ?)");
        $stmtTopic = $coni->prepare("INSERT INTO content (module_id, topic_title, topic_description, topic_order, created) VALUES (?, ?, ?, ?, ?)");

        if ($stmtMod && $stmtTopic) {
            foreach ($modules as $m) {
                $mod_title = isset($m['title']) ? trim($m['title']) : '';
                $mod_desc  = isset($m['description']) ? trim($m['description']) : '';
                if ($mod_title == '') continue;
                $stmtMod->bind_param('issi', $lesson_id, $mod_title, $mod_desc, $created_time);
                $stmtMod->execute();
                $module_id = $stmtMod->insert_id;

                if (isset($m['topics']) && is_array($m['topics'])) {
                    $order = 1;
                    foreach ($m['topics'] as $t) {
                        $topic_title = isset($t['title']) ? trim($t['title']) : '';
                        if ($topic_title == '') continue;
                        $stmtTopic->bind_param('issii', $module_id, $topic_title, $mod_desc, $order, $created_time);
                        $stmtTopic->execute();
                        $order++;
                    }
                }
            }
            $stmtMod->close();
            $stmtTopic->close();
        }
    }

    // === ASSIGN INSTRUCTOR ===
    if ($instructor != '' && ($course_mode == 'ILT' || $course_mode == 'Hybrid')) {
        $stmt4 = $coni->prepare("INSERT INTO users_to_lessons (user_login, lesson_id, user_type) VALUES (?, ?, 'instructor')");
        if ($stmt4) {
            $stmt4->bind_param('si', $instructor, $lesson_id);
            $stmt4->execute();
            $stmt4->close();
        }
    }

    echo json_encode(array('success' => true, 'message' => '✅ Course successfully saved with hierarchy, modules & instructor.'));

} catch (Exception $e) {
    echo json_encode(array('success' => false, 'message' => '❌ Error: ' . $e->getMessage()));
}
?>
