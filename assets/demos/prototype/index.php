<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mood Mirror - Prototype</title>

</head>
<body>
    <div class="camcontent">
        <video id="video" autoplay></video>
        <canvas id="canvas" width="640" height="480">
    </div>
    <div class="cambuttons">
        <button id="snap" style="display:none;">  Capture </button>
        <button id="reset" style="display:none;">  Reset  </button>
        <button id="upload" style="display:none;"> Upload </button>
        <br> <span id=uploading style="display:none;"> Uploading has begun . . .  </span>
        <span id=uploaded  style="display:none;"> Success, your photo has been uploaded! <a href="javascript:history.go(-1)"> Return </a> </span>
    </div>

    <!--Loading jquery library-->
    s<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
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
                    video.src = stream;
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
                        user: "Joe",
                        userid: 25
            }
            }).done(function(msg) {
                    console.log("saved");
                    $("#uploading").hide();
                    $("#uploaded").show();
                });
            });
        }, false);

    </script>
<!--    <script src="main.js"></script>-->
    <script>

    </script>
</body>
</html>