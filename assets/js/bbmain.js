window.addEventListener('load', init);


/*
init Function
 */
function init(){
    document.getElementById("main_btn").addEventListener("click", function() {
        hideId("main");
        showId("camera");
    });

    document.getElementById("camera_btn").addEventListener("click", function() {
        hideId("camera");
        showId("scanning");
    });
    document.getElementById("scanning_btn").addEventListener("click", function() {
        hideId("scanning");
        showId("result");
    });

}
/*
Function hide id
 */

function hideId(data) {
    document.getElementById(data).style.display = "none";
    console.log("hidden element #"+data);
}




/*
Function show id
 */
function showId(data) {
    document.getElementById(data).style.display = "block";
    console.log("show element #"+data);
}
