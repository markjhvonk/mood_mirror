<?php
require_once 'php/config.php';

if(isset($_POST['submit'])){
    // Escape user input for security
    $imgResult = mysqli_real_escape_string($db, $_POST['webcam-image']);
    $artResult = mysqli_real_escape_string($db, $_POST['art-image']);
    $artTitle = mysqli_real_escape_string($db, $_POST['art-title']);


    // Create query to insert images
    $create_result = "INSERT INTO photo_result(imgresult, artresult, artInfo, musea_id) VALUES('$imgResult','$artResult','$artTitle', 1)";

    // Make the insert
    $result = mysqli_query($db,$create_result);
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mood Mirror - Prototype</title>

    <!--Custom stylesheet-->
    <link rel="stylesheet" href="../assets/css/billboard.css">
    <!--Google font open sans-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <!-- Normalizr used for prefixes -->
    <link rel="stylesheet" href="../assets/css/vendor/normalize.css">
    <!-- Loading jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>

</head>
<body>

<!--Fake loader gets active when a picture is taken-->
<div id="backgroundLoader">
    <span class="loading-text">
        Een ogenblik geduld...<br>
        We zoeken naar een passend kunstwerk
    </span>
    <div class="spinner">
        <div class="double-bounce1"></div>
        <div class="double-bounce2"></div>
    </div>
</div>
<!-- // -->

<div class="background-container">
    <div class="background-gradient"></div>
    <div class="background-image"></div>
</div>
<div class="container">
    <header>
        <img class="logo" src="../assets/img/logo.png" alt="">
    </header>
    <div class="content">
        <div class="row">
            <div class="cameraWrapper">
                <div id="my_camera"></div>
                <!-- A button for taking snaps -->
                <form>
                    <input type="button" id="cameraBtn" class="btn btn-success" value="Klik hier om een foto te maken" onClick="take_snapshot(); setTimeout(loadingScreen, 0);">
                </form>
            </div>
            <div class="resultWrapper">
                <div id="results" class="well">

                </div>
                <div id="qrcode" style="display: none;"></div>
                <!-- Form to send image to database -->
                <form style="position: relative;" action="<?php echo "https://markvonk.com".$_SERVER['PHP_SELF']; ?>" id="imageToDatabase" method="post">

                </form>
                <div id="usage" style="display: none;">
                    <p>
                        Om uw resultaat te kunnen bekijken moet u eerst de QR code scannen en daarna op de knop "Bevestigen" klikken voordat u uw de webpagina opent.
                    </p>
                </div>
            </div>
        </div>
        <footer id="disclaimer">
            <p>
                Uw resultaat wordt bij ons opgeslagen.</br>
                Wij zullen uw foto nooit aan derde partijen verkopen.
            </p>
        </footer>
    </div>
</div>

<!-- First, include the Webcam.js JavaScript Library -->
<script type="text/javascript" src="../assets/js/vendor/webcam.min.js"></script>

<!-- Configure a few settings and attach camera -->
<script language="JavaScript">
    // Globals
    let apiKey = "mxPByyoV";
    let hexColor = "";
    let imgUrl = "";
    let imgTitle = "";

    let results = document.getElementById("results");
    let resultToDatabase = document.getElementById("imageToDatabase");

    Webcam.set({
        width: 320,
        height: 240,
        dest_width: 640,
        dest_height: 480,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
    Webcam.attach( '#my_camera' );
    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            Webcam.upload( data_uri, 'php/base64_to_img.php', function(code, text) {
                console.log(text);
                // Succes message
                if(text) {
                    var params = {
                        // Request parameters
                    };

                    $.ajax({
                        url: "https://westus.api.cognitive.microsoft.com/emotion/v1.0/recognize?" + $.param(params),
                        beforeSend: function (xhrObj) {
                            // Request headers
                            xhrObj.setRequestHeader("Content-Type", "application/json");
                            xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key", "23f48f8d30ad4caf8f1645dc0bdf3e3f");
                        },
                        type: "POST",
                        // Request body
                        data: "{'url': '" + text + "'}"
                    })
                        .done(function (data) {
                            console.log(data);

                            for (var i in data[0].scores) {
                                console.log(i + ": " + data[0].scores[i].toFixed(0));
                                if (data[0].scores[i].toFixed(0) == 1) {
                                    //emotion = i;
                                    switch (i) {
                                        case "anger":
                                            //Oranje
                                            hexColor = '981313';
                                            break;
                                        case "contempt":
                                            //Blauw
                                            hexColor = '737C84';
                                            break;
                                        case "disgust":
                                            //Gray
                                            hexColor = 'B5BFCC';
                                            break;
                                        case "fear":
                                            //Orange
                                            hexColor = '981313';
                                            break;
                                        case "happiness":
                                            //Geel
                                            hexColor = 'E0CC91';
                                            break;
                                        case "neutral":
                                            //Blue
                                            hexColor = '737C84';
                                            break;
                                        case "sadness":
                                            //Zwart
                                            hexColor = '000000';
                                            break;
                                        case "surprise":
                                            //Groen
                                            hexColor = 'E0CC91';
                                            break;
                                    }
                                    getArt(hexColor);
                                }
                            }

//                            getArt();

                            let div = document.createElement("div");
                            div.setAttribute("class", "wrapImageResult");
                            results.appendChild(div);

                            let img = document.createElement("img");
                            img.setAttribute("class", "resultImg");
                            img.setAttribute("src", text);
                            div.appendChild(img);

                            // Create hidden input with taken image
                            let input = document.createElement("input");
                            input.setAttribute("value", text);
                            input.setAttribute("type", "hidden");
                            input.setAttribute("name", "webcam-image");
                            resultToDatabase.appendChild(input);

                            // Let the QR code appear and append to result div
                            let qr = document.getElementById('qrcode');
                            qr.style.display = "block";
                            results.appendChild(qr);

                            // Generate QR code link
                            new QRCode(document.getElementById("qrcode"), "https://markvonk.com/mood_mirror/mobile/index.php");
                        })
                        .fail(function () {
                            alert("error");
                        });
                }
            });
        });
        var disclaimerText = document.getElementById('disclaimer');
        disclaimerText.style.display = 'none';

        var textUsage = document.getElementById("usage");
        textUsage.style.display = 'block';
    }

    function getArt(Color)
    {
        reqwest({
            url: 'https://www.rijksmuseum.nl/api/nl/collection?key='+ apiKey +'&format=json&f.normalized32Colors.hex=%20%23'+ Color,
            method: 'get',
            crossOrigin: true,
            success: getArtSuccessHandler,
            error: getArtErrorHandler
        })
    }

    function getArtSuccessHandler(data) {
        console.log(data);
        var rand = Math.floor((Math.random() * 10) + 0);
        imgUrl = data.artObjects[rand].webImage.url;
        imgTitle = data.artObjects[rand].longTitle;
        console.log(imgTitle);
//        console.log(imgUrl);
        let div = document.createElement("div");
        div.setAttribute("class", "artResult");

        let img = document.createElement("img");
        img.setAttribute("src", imgUrl);
        div.appendChild(img);
        results.appendChild(div);

        let input = document.createElement("input");
        input.setAttribute("value", imgUrl);
        input.setAttribute("name", "art-image");
        input.setAttribute("type", "hidden");

        let input2 = document.createElement("input");
        input2.setAttribute("value", imgTitle);
        input2.setAttribute("name", "art-title");
        input2.setAttribute("type", "hidden");

        // Submit button for hidden form
        let submit = document.createElement("input");
        submit.setAttribute("type", "submit");
        submit.setAttribute("name", "submit");
        submit.setAttribute("id", "sendBtn");
        // Append art image to form
        resultToDatabase.appendChild(input);
        resultToDatabase.appendChild(input2);
        // Append submit button to form
        resultToDatabase.appendChild(submit);
    }

    function getArtErrorHandler(){
        console.log("Fix yer code!");
    }

</script>


</body>
<!-- Loading reqwest -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/reqwest/2.0.5/reqwest.min.js"></script>
<!--Loading modernizr-->
<script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
<!-- Main javascript -->
<script src="../assets/js/main.js"></script>
<!-- Loading QR -->
<script src="../assets/js/vendor/qrcode.js"></script>
</html>