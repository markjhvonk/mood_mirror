<?php
    require_once '../display/php/config.php';

    $getImages = "SELECT imgresult, artresult, artInfo 
                  FROM photo_result
                  ORDER BY id DESC
                  LIMIT 1;";
    $result = mysqli_query($db, $getImages);

    $images = [];

    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $images[] = $row;
        }
    }
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Art Mirror</title>

    <!--Loading custom CSS-->
    <link rel="stylesheet" href="../assets/css/mobile.css">
    <!--Loading Open Sans font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!--Google Icons-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<header>
    <div class="img-wrap">
        <a href="#">
            <i class="material-icons" id="arrow-back">arrow_back</i>
        </a>
        <img src="../assets/img/imgMobile/logo.png" class="logo">
    </div>
</header>
<section id="result-page">
    <div class="info-text">
        <div class="text" style="text-align: center;">
            <p>Welkom op uw persoonlijke pagina van de Art Mirror. Hier kunt die uw foto downloaden en publiceren of kunt u kijken naar het gekoppelde kunstwerk met daarbij de passende informatie.</p>
        </div>
    </div>
    <div class="redirect-pictures">
        <div class="image" style="background-image: url('<?= $images['0']['imgresult'] ?>'); background-size: cover; background-position: 50%; background-repeat: no-repeat; ">
            <a href="#" id="picturePerson">
                <div class="wrapper-icon">
                    <i class="material-icons">file_download</i>
                </div>
            </a>
        </div>
        <div class="image" style="background-image: url('<?= $images['0']['artresult'] ?>'); background-size: cover; background-position: 50%; background-repeat: no-repeat;">
            <a href="#" id="pictureArt">
                <div class="wrapper-icon">
                    <i class="material-icons">info</i>
                </div>
            </a>
        </div>
    </div>
</section>
<section id="art-page">
    <div class="gradient">

    </div>
    <div class="art-image" style="background-image: url('<?= $images['0']['artresult'] ?>'); background-size: contain; background-position: 50%; background-repeat: no-repeat;">

    </div>
    <div class="background-image" style="background-image: url('<?= $images['0']['artresult'] ?>'); background-size: cover; background-position: 50%; background-repeat: no-repeat;">

    </div>
    <div class="container">
        <div class="text-art-page">
            <p><?= $images['0']['artInfo'] ?></p>
        </div>
    </div>
</section>

<section id="personal-page">
<div class="personal-page"  style="background-image: url('<?= $images['0']['imgresult'] ?>'); background-size: cover; background-position: 50%; background-repeat: no-repeat;">

</div>
<div class="download-button">
    <a href="<?= $images['0']['imgresult'] ?>" download >
        <i class="material-icons" id="download">file_download</i>
    </a>
</div>
</section>
<script src="../assets/js/mobile.js"></script>
</body>
</html>