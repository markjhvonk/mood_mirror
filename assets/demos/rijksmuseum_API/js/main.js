/**
 * Created by Mark on 29/03/2017.
 */
window.addEventListener("load", init);

//GLOBALS
var apiKey = "mxPByyoV";
var hexColor = '#ff0000';

function init(){
    getArt();
}


function getArt()
{
    reqwest({
        url: 'https://www.rijksmuseum.nl/api/nl/collection?key='+ apiKey +'&format=json&maker='+ hexColor,
        method: 'get',
        crossOrigin: true,
        success: getArtSuccessHandler,
        error: getArtErrorHandler
    })
}

function getArtSuccessHandler(data) {
    console.log(data);
    var image = data.artObjects[0].webImage.url;
    console.log(image);
    document.getElementById('images').src = image;
}

function getArtErrorHandler(){
    console.log("Fix yer code!");
}