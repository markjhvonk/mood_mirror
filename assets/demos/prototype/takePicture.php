<script src="https://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script>// <![CDATA[
    navigator.getUserMedia = (navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia );
    if (navigator.getUserMedia) {
        navigator.getUserMedia({
                video:true,
                audio:false
            },
            function(stream) { /* do-say something */ },
            function(error) {
                alert('Something went wrong. (error code ' + error.code + ')');
                return false;
            });
    } else {
        alert("Sorry, the browser you are using doesn't support the HTML5 webcam API");
        return false;
    }
    // ]]></script>

<script>// <![CDATA[
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
                url: "savePicture.php",
                data: {
                    imgBase64: dataUrl
                },
                success: function(data){
                    console.log(data);
                    $('#camFeedback').html(data);
                }
            }).done(function(msg) {
                console.log("saved");
                $("#uploading").hide();
                $("#uploaded").show();
            });
        });
    }, false);
    // ]]></script>
<h3>Take a photo with your webcam</h3>
&nbsp;
<p style="color: red;">You have to accept that your browser can access the webcam, if you haven't already!</p>
&nbsp;
<div class="camcontent">
    <video id="video" autoplay="autoplay" width="300" height="150"></video>
    <canvas id="canvas" width="640" height="480"> </canvas>
</div>

<!-- Font awsome icons used in buttons -->
<div class="cambuttons" style="margin-top: 10px;">
    <button id="snap" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-camera"></i> Take picture </button>
    <button id="reset" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-camera"></i> Take new picture </button>
    <button id="upload" class="btn btn-default btn-lg" style="display: none;"> <i class="fa fa-save"></i> Save </button>

    <span id="uploading" style="display: none;"> Saving photo . . . </span>
    <span id="uploaded" style="display: none;"> Success! Photo is uploaded. <a> Return </a> </span></div>
&nbsp;
<div id="camFeedback"></div>