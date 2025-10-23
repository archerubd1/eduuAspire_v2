<?php
include_once('config.php');
header('Content-Type: application/json');
error_reporting(E_ALL & ~E_NOTICE);

// Basic validation
if (!isset($_POST['title']) || trim($_POST['title']) == '') {
    echo json_encode(array("success" => false, "message" => "Course title is required."));
    exit;
}

// sanitize inputs
$title        = mysqli_real_escape_string($coni, trim($_POST['title']));
$subtitle     = mysqli_real_escape_string($coni, trim($_POST['subtitle']));
$description  = mysqli_real_escape_string($coni, trim($_POST['description']));
$duration     = intval($_POST['duration']);
$price        = floatval($_POST['price']);
$discount     = isset($_POST['discount_price']) ? floatval($_POST['discount_price']) : 0.00;
$badge        = mysqli_real_escape_string($coni, trim($_POST['badge']));
$category_id  = intval($_POST['category_id']);
$course_mode  = mysqli_real_escape_string($coni, trim($_POST['course_mode']));
$creator      = isset($_POST['instructor_login']) ? mysqli_real_escape_string($coni, trim($_POST['instructor_login'])) : '';
$specialty    = isset($_POST['specialty']) ? mysqli_real_escape_string($coni, trim($_POST['specialty'])) : '';

$meta_overview   = isset($_POST['meta_overview']) ? mysqli_real_escape_string($coni, trim($_POST['meta_overview'])) : '';
$meta_skills     = isset($_POST['meta_skills']) ? mysqli_real_escape_string($coni, trim($_POST['meta_skills'])) : '';
$meta_objectives = isset($_POST['meta_objectives']) ? mysqli_real_escape_string($coni, trim($_POST['meta_objectives'])) : '';
$meta_audience   = isset($_POST['meta_audience']) ? mysqli_real_escape_string($coni, trim($_POST['meta_audience'])) : '';
$meta_modules    = isset($_POST['meta_modules']) ? mysqli_real_escape_string($coni, trim($_POST['meta_modules'])) : '';

$modules_post = isset($_POST['modules']) ? $_POST['modules'] : array();

// upload root
$root_upload_dir = dirname(__DIR__) . "/uploads/";
if (!is_dir($root_upload_dir)) mkdir($root_upload_dir, 0777, true);

// -------------------- course image --------------------
$course_image = "assets/img/education/default-course.webp";
if (isset($_FILES['course_image']) && $_FILES['course_image']['error'] == UPLOAD_ERR_OK) {
    $course_dir = $root_upload_dir . "courses/";
    if (!is_dir($course_dir)) mkdir($course_dir, 0777, true);
    $filename = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['course_image']['name']));
    $target = $course_dir . $filename;
    if (move_uploaded_file($_FILES['course_image']['tmp_name'], $target)) {
        $course_image = "uploads/courses/" . $filename;
    }
}

// -------------------- brochure upload --------------------
$brochure_path = NULL;
$brochure_type = NULL;
if (isset($_FILES['meta_brochure']) && $_FILES['meta_brochure']['error'] == UPLOAD_ERR_OK) {
    $brochure_dir = $root_upload_dir . "brochures/";
    if (!is_dir($brochure_dir)) mkdir($brochure_dir, 0777, true);
    $filename = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($_FILES['meta_brochure']['name']));
    $target = $brochure_dir . $filename;
    if (move_uploaded_file($_FILES['meta_brochure']['tmp_name'], $target)) {
        $brochure_path = "uploads/brochures/" . $filename;
        $brochure_type = pathinfo($filename, PATHINFO_EXTENSION);
    }
}

// require instructor for ILT/Hybrid
if (($course_mode == 'ILT' || $course_mode == 'Hybrid') && empty($creator)) {
    echo json_encode(array("success" => false, "message" => "Instructor is required for ILT or Hybrid courses."));
    exit;
}

// create modules and content tables if not exist
$create_modules_sql = "
CREATE TABLE IF NOT EXISTS modules (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  course_id INT(11) NOT NULL,
  module_title VARCHAR(255) NOT NULL,
  module_description TEXT,
  module_order INT(11) DEFAULT 0,
  created INT(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
";
mysqli_query($coni, $create_modules_sql);

$create_content_sql = "
CREATE TABLE IF NOT EXISTS content (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  module_id INT(11) NOT NULL,
  topic_title VARCHAR(255) NOT NULL,
  topic_description TEXT,
  topic_order INT(11) DEFAULT 0,
  created INT(11) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4;
";
mysqli_query($coni, $create_content_sql);

// -------------------- insert into lessons --------------------
$created_time = time();
$creator_sql = ($creator != '') ? "'" . mysqli_real_escape_string($coni, $creator) . "'" : "NULL";

$lesson_sql = "
INSERT INTO lessons
(name, info, duration, price, directions_ID, creator_LOGIN, active, show_catalog, publish, created, course_mode)
VALUES
('".$title."', '".$description."', ".$duration.", ".$price.", ".($category_id>0 ? $category_id : "NULL").", ".$creator_sql.", 1, 1, 1, ".$created_time.", '".$course_mode."')
";
if (!mysqli_query($coni, $lesson_sql)) {
    echo json_encode(array("success" => false, "message" => "Error saving lesson: " . mysqli_error($coni)));
    exit;
}
$lesson_id = mysqli_insert_id($coni);

// -------------------- insert into course_marketplace --------------------
$market_sql = "
INSERT INTO course_marketplace (lesson_id, subtitle, price, discount_price, badge, image, is_active)
VALUES (".$lesson_id.", '".$subtitle."', ".$price.", ".$discount.", '".$badge."', '".$course_image."', 1)
";
if (!mysqli_query($coni, $market_sql)) {
    echo json_encode(array("success" => false, "message" => "Error saving marketplace data: " . mysqli_error($coni)));
    exit;
}

// -------------------- insert into course_metadata --------------------
$brochure_path_sql = ($brochure_path !== NULL) ? "'".mysqli_real_escape_string($coni, $brochure_path)."'" : "NULL";
$brochure_type_sql = ($brochure_type !== NULL) ? "'".mysqli_real_escape_string($coni, $brochure_type)."'" : "NULL";

$meta_sql = "
INSERT INTO course_metadata (course_id, overview, modules, skills, objectives, audience, brochure_path, brochure_type)
VALUES (".$lesson_id.", '".$meta_overview."', '".mysqli_real_escape_string($coni, $meta_modules)."', '".$meta_skills."', '".$meta_objectives."', '".$meta_audience."', ".$brochure_path_sql.", ".$brochure_type_sql.")
";
if (!mysqli_query($coni, $meta_sql)) {
    echo json_encode(array("success" => false, "message" => "Error saving metadata: " . mysqli_error($coni)));
    exit;
}

// -------------------- ensure instructor exists or update --------------------
if ($creator != '') {
    // optional instructor avatar upload was handled in form-> instructor_avatar - but not mandatory
    // If instructors table missing, assume exists per your schema; otherwise create minimal row
    $checkInstr = mysqli_query($coni, "SELECT id, avatar, specialty FROM instructors WHERE user_login='".mysqli_real_escape_string($coni, $creator)."' LIMIT 1");
    if (mysqli_num_rows($checkInstr) == 0) {
        mysqli_query($coni, "INSERT INTO instructors (user_login, specialty, avatar, rating, total_reviews, active) VALUES ('".mysqli_real_escape_string($coni, $creator)."', '".$specialty."', 'assets/img/person/default-avatar.webp', 4.5, 0, 1)");
    } else {
        $existing = mysqli_fetch_assoc($checkInstr);
        $updateParts = array();
        if ($specialty != '' && $specialty != $existing['specialty']) {
            $updateParts[] = "specialty='".$specialty."'";
        }
        if (count($updateParts) > 0) {
            mysqli_query($coni, "UPDATE instructors SET ".implode(',', $updateParts)." WHERE user_login='".mysqli_real_escape_string($coni, $creator)."' LIMIT 1");
        }
    }
}

// -------------------- modules & topics insertion --------------------
if (is_array($modules_post) && count($modules_post) > 0) {
    foreach ($modules_post as $m_key => $m_data) {
        if (!is_array($m_data)) continue;
        $m_title = isset($m_data['title']) ? mysqli_real_escape_string($coni, trim($m_data['title'])) : '';
        $m_desc  = isset($m_data['description']) ? mysqli_real_escape_string($coni, trim($m_data['description'])) : '';
        if ($m_title == '') continue;
        $module_order = intval($m_key);
        $ins_m_sql = "INSERT INTO modules (course_id, module_title, module_description, module_order, created) VALUES (".$lesson_id.", '".$m_title."', '".$m_desc."', ".$module_order.", ".time().")";
        if (mysqli_query($coni, $ins_m_sql)) {
            $module_id = mysqli_insert_id($coni);
            if (isset($m_data['topics']) && is_array($m_data['topics'])) {
                foreach ($m_data['topics'] as $t_key => $t_data) {
                    if (!is_array($t_data)) continue;
                    $t_title = isset($t_data['title']) ? mysqli_real_escape_string($coni, trim($t_data['title'])) : '';
                    if ($t_title == '') continue;
                    $topic_order = intval($t_key);
                    $ins_t_sql = "INSERT INTO content (module_id, topic_title, topic_description, topic_order, created)
                                  VALUES (".$module_id.", '".$t_title."', '', ".$topic_order.", ".time().")";
                    mysqli_query($coni, $ins_t_sql);
                }
            }
        }
    }
}

// success
echo json_encode(array(
    "success" => true,
    "message" => "✅ Course '" . $title . "' (" . $course_mode . ") added successfully!"
));
exit;
?>
