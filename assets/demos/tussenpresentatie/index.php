<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mood Mirror - Prototype</title>
    <style>
        body{
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
$filelist = opendir('images') ;
$photos = array();

while ($campic = readdir($filelist))
{
    if (strpos($campic, '.jpg') !== false  )
    { $photos[] = $campic; }
}
closedir($filelist);
rsort($photos);  # to display the most recent photos first
echo 'images/'.$photos[0];
//                        foreach ($photos AS $photo )
//                        { echo  ' <img width=640 height=480 src="images/'.$photo.'">
//                              <br> '.$photo.'<br> <br> <br>' ; }
?>
    <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>-->

    <div class="camcontent">
        <video id="video" autoplay></video>
        <canvas id="canvas" width="640" height="480">
    </div>
    <div class="cambuttons">
        <button id="snap" style="display:none;">  Capture </button>
        <button id="reset" style="display:none;">  Reset  </button>
        <button id="upload" style="display:none;"> Upload </button>
        <br> <span id=uploading style="display:none;"> Uploading has begun . . .  </span>
        <span id=uploaded  style="display:none;"> Success, your photo has been uploaded!
        <a href="javascript:history.go(-1)"> Return </a> </span>
    </div>


    <img id="photo" src="" width="50%"><br/>
    <img id="moodUrl" src="">
    <input type="submit" value="refresh">
    <section id="face-detection">

    </section>

    <!--Loading jquery library-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="main.js"></script>
    <script>
        // Put event listeners into place
        window.addEventListener("DOMContentLoaded", function() {
            // Grab elements, create settings, etc.
            var canvas = document.getElementById("canvas"),
                context = canvas.getContext("2d"),
                video = document.getElementById("video"),
                videoObj = { "video": true },
                image_format= "jpeg",
                jpeg_quality= 85,
                errBack = function(error) {
                    console.log("Video capture error: ", error.code);
                };


            // Put video listeners into place
            if(navigator.getUserMedia) { // Standard
                navigator.getUserMedia(videoObj, function(stream) {
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                    $("#snap").show();
                }, errBack);
            } else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
                navigator.webkitGetUserMedia(videoObj, function(stream){
                    video.src = window.webkitURL.createObjectURL(stream);
                    video.play();
                    $("#snap").show();
                }, errBack);
            } else if(navigator.mozGetUserMedia) { // moz-prefixed
                navigator.mozGetUserMedia(videoObj, function(stream){
                    video.src = window.URL.createObjectURL(stream);
                    video.play();
                    $("#snap").show();
                }, errBack);
            }
            // video.play();       these 2 lines must be repeated above 3 times
            // $("#snap").show();  rather than here once, to keep "capture" hidden
            //                     until after the webcam has been activated.

            // Get-Save Snapshot - image
            document.getElementById("snap").addEventListener("click", function() {
                context.drawImage(video, 0, 0, 640, 480);
                // the fade only works on firefox?
                $("#video").fadeOut("slow");
                $("#canvas").fadeIn("slow");
                $("#snap").hide();
                $("#reset").show();
                $("#upload").show();
            });
            // reset - clear - to Capture New Photo
            document.getElementById("reset").addEventListener("click", function() {
                $("#video").fadeIn("slow");
                $("#canvas").fadeOut("slow");
                $("#snap").show();
                $("#reset").hide();
                $("#upload").hide();
            });
            // Upload image to sever
            document.getElementById("upload").addEventListener("click", function(){
                var dataUrl = canvas.toDataURL("image/jpeg", 0.85);
                $("#uploading").show();
                $.ajax({
                    type: "POST",
                    url: "html5-webcam-save.php",
                    data: {
                        imgBase64: dataUrl,
                        user: "Mark",
                        userid: 25
                    }
                }).done(function(msg) {
                    console.log("saved");
                    $("#uploading").hide();
                    $("#uploaded").show();

                });
            });
        }, false);

        //
        //Emotion lezer stuff
        //
        var emotion; //Create empty variable to store emotion generated by API
        var photo = "";
        // attempt insert query to create a reservation, only input when data is valid
//        $add_image = "INSERT INTO photo_result (image_name, musea_id) VALUES ('$uploaded_file', 1)";
//
//        // Create row in db
//        $result = mysqli_query($db,$add_image);
//        // End insert query when form is correct
//        if($result){
//            echo "Afbeelding geupload";
//        }else{
//            echo "Try again mate";
//        }
//        var photo = 'http://glamoursmiles.com/wp-content/uploads/2013/03/Smile-Head-Tilt.jpg'; //Create variable for the photo that will be added later on
    //            var photo = 'http://kingofwallpapers.com/angry/angry-002.jpg';
        document.getElementById('photo').src = photo; //add photo url to the img tag in html for preview purposes

        //start of function
//        $(function() {
//            var params = {
//                // Request parameters
//            };
//
//            //start of face scanner API
//            $.ajax({
//                url: "https://westus.api.cognitive.microsoft.com/emotion/v1.0/recognize" + $.param(params),
//                beforeSend: function(xhrObj){
//                    // Request headers
//                    xhrObj.setRequestHeader("Content-Type","application/json");
//                    xhrObj.setRequestHeader("Ocp-Apim-Subscription-Key","23f48f8d30ad4caf8f1645dc0bdf3e3f");
//                },
//                type: "POST",
//                // Request body with photo URL
//                data: "{'url': '"+photo+"'}"
//            })
            //If the photo is scanned, store the emotion with the highest value
                .done(function(data) {
                    console.log(data);
                    for (var i in data[0].scores) {
                        console.log(i + ": " + data[0].scores[i].toFixed(0));
                        if(data[0].scores[i].toFixed(0) == 1){
                            //emotion = i;
                            switch(i) {
                                case "anger":
                                    emotion = "mad";
                                    ArtAPI("mad");
                                    break;
                                case "contempt":
                                    emotion = "dark";
                                    ArtAPI("dark");
                                    break;
                                case "disgust":
                                    emotion = "sick";
                                    ArtAPI("sick");
                                    break;
                                case "fear":
                                    emotion = "distress";
                                    ArtAPI("distress");
                                    break;
                                case "happiness":
                                    emotion = "happiness";
                                    ArtAPI("happiness");
                                    break;
                                case "neutral":
                                    emotion = "sea";
                                    ArtAPI("sea");
                                    break;
                                case "sadness":
                                    emotion = "down";
                                    ArtAPI("down");
                                    break;
                                case "surprise":
                                    emotion = "surprise";
                                    ArtAPI("surprise");
                                    break;
                            }
                        }
                    }
                    console.log("Stored Emotion: "+emotion);
                    test(emotion);
                })
                //If the scanning fails
                .fail(function() {
                    alert("error");
                });
        });
//        function test(data) {
//            emotion = data;
//        }
//
//        // Combine face api with art api
//        function ArtAPI(emo){
//            var apiEndpointBaseURL = "http://api.harvardartmuseums.org/object";
//            console.log(emotion);
//            var queryString = $.param({
//                apikey: "fec9ded0-f7b6-11e6-a459-7b38e8009412",
//    //      title: "happiness",
//                title: emo,//<-- emotion is inserted here
//                classification: "Paintings"
//            });
//
//            //read the json array from the art API
////            $.getJSON(apiEndpointBaseURL + "?" + queryString, function(data) {
////                console.log(data);
////                var artSrcArray = [];
////                //Loop through all the results and keep out the results with empty image url's
////                for (var i in data.records) {
////                    var artSrc = data.records[i].primaryimageurl;
////                    if(artSrc == null){
////
////                    } else {
////                        //put all the valid results in an array
////                        artSrcArray.push(artSrc);
////                    }
////                }
////                console.log("results: "+artSrcArray.length);
////                //take a random result from the valid results array and insert it into the img tag
////                var artUrl = artSrcArray[Math.floor(Math.random()*artSrcArray.length)];
////                //document.getElementById('moodUrl').src = artUrl;
////                document.body.style.backgroundImage = "url('"+artUrl+"')";
////            });
//
//            console.log(emotion); //check the emotion with the highest value
//        }
    </script>
</body>
</html>