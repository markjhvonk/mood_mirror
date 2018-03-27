<?php
require('config.inc.php'); // Connect to database

//$getMercID = clean($_GET['id']); // Get product ID

// Fetch photo only if product id is not empty
//if (!empty($getMercID)) {
    $rawData = $_POST['imgBase64'];
    echo "<img src='".$rawData."' />"; // Show photo

    list($type, $rawData) = explode(';', $rawData);
    list(, $rawData)      = explode(',', $rawData);
    $unencoded = base64_decode($rawData);

    $filename = $getMercID.'_'.date('dmYHi').'_'.rand(1111,9999).'.jpg'; // Set a filename
    file_put_contents("images/products/$filename", base64_decode($rawData)); // Save photo to folder

    // Update product database with the new filename
//    $query = "UPDATE products SET
//					product_photo='".$filename."'
//					WHERE id='".$getMercID."'";
//    $result = $mysqli-&gt;query($query);


//	}

// Stop if product id is missing
//else {
//    die('Product ID is missing...');
//}

?>