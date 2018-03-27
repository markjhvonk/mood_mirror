<script>
    console.log('hoi');
</script>

<?php
require_once("settings.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$rawData = $_POST['imgBase64'];
$filteredData = explode(',', $rawData);
$unencoded = base64_decode($filteredData[1]);

$datime = date("Y-m-d-H.i.s", time() ) ; # - 3600*7

$userid  = $_POST['userid'] ;

// name & save the image file
$fp = fopen("images/".$datime.'-'.$userid.'.jpg', 'w');
$currentImg = "images/".$datime.'-'.$userid.'.jpg'; //get img url
print_r($currentImg);

if(isset($_GET['submit'])){
    // attempt insert query to create a reservation, only input when data is valid
    $add_image = "INSERT INTO photo_result (image_name, musea_id) VALUES ('$currentImg', 1)";

    // Create row in db
    $result = mysqli_query($mysqli,$add_image);
    // End insert query when form is correct
    if($result){
        echo "Afbeelding geupload";
    }else{
        echo "Try again mate";
    }
}

//store img url in session
session_start();
$_SESSION['currentImg'] = $currentImg;

fwrite($fp, $unencoded);
fclose($fp);