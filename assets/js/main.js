window.addEventListener('load', init);

var cameraBtn = document.getElementById('cameraBtn');

function init()
{
    cameraBtn.addEventListener('click', hideCamera);
}

/**
 * Trigger the loading screen when an picture is taken
 */
function loadingScreen(){
    var wrapLoadingScreen = document.getElementById('backgroundLoader');
    wrapLoadingScreen.style.display = 'block';
    wrapLoadingScreen.classList.add('hideMe');
}
/**
 * When a picture is made the camera disappears
 */
function hideCamera(){
    var cameraWrap = document.getElementById('my_camera');
    cameraWrap.style.display = 'none';
    cameraBtn.style.display = 'none';

    console.log('ohboiii');
    hideDisclaimer();
    showUsage();
}

/**
 *  Hide disclaimer after picture is taken
 */
function hideDisclaimer(){
    console.log("hoooiiii");
    var disclaimerText = document.getElementById('disclaimer');
    disclaimerText.style.display = 'none';
}

function showUsage(){
    var textUsage = document.getElementById("usage");
    textUsage.style.display = 'block';
}