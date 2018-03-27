<?php

$file_to_path = 'uploads/';
$name = 'webcam'.md5(time()).'.jpg';

$uploaded_file = move_uploaded_file($_FILES['webcam']['tmp_name'], $file_to_path.$name);

$createUrl = "http://" . $_SERVER['SERVER_NAME'] . "/mood_mirror/display/php/uploads/" . $name;

echo $createUrl;
exit;