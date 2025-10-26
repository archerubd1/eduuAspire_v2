<?php
file_put_contents(__DIR__ . '/test_run.log', "PHP executed at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
echo json_encode(['status'=>'ok','time'=>time()]);
