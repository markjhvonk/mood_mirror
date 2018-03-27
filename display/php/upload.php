<?php

//require_once 'config.php';
// Format image name based on time

$url = $_POST['image'];



$file_to_path = 'uploads/';
$name = 'webcam'.md5(time()).'.jpg';

$uploaded_file = move_uploaded_file($_FILES['webcam']['tmp_name'], $file_to_path.$name);

$createUrl = "http://" . $_SERVER['SERVER_NAME'] . "/mood_mirror/display/php/uploads/" . $name;

echo $createUrl;
exit;


//$tmp_name = $_FILES["webcam"]["tmp_name"];
////$name = 'webcam'.md5(time()).'.jpg';
//$file = move_uploaded_file($tmp_name, 'uploads/');
//
//$createUrl = "http://" . $_SERVER['SERVER_NAME'] . "/mood_mirror/display/php/uploads/" . $tmp_name;
//
//echo "$createUrl";


//$tmp_name = $_FILES["pictures"];
//move_uploaded_file($tmp_name, "$uploads_dir/$name");



//if($uploaded_file){
//    echo "gelukt";
//}else{
//    echo "nope";
//}
//
//if(isset ($_POST["submit"]))
//{
//    // Escape user inputs for security
//    $uploaded_file = mysqli_real_escape_string($db, $_POST['image']);
//
//    // attempt insert query to create a reservation, only input when data is valid
//    $add_image = "INSERT INTO photo_result (image, musea_id) VALUES ('$uploaded_file', 1)";
//
//    // Create row in db
//    $result = mysqli_query($db,$add_image);
//    // End insert query when form is correct
//    if($result){
//        echo "Afbeelding geupload";
//    }else{
//        echo "Try again mate";
//    }
//}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
    <input name="image" value="<?= $uploaded_file ?>"/>
    <input type="submit" value="Verzend afbeelding" name="submit" id="send"/>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</body>
</html>
