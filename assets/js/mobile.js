window.addEventListener('load', init);

var homePage = document.getElementById('result-page');
var artPage = document.getElementById('art-page');
var personalPage = document.getElementById('personal-page');
var arrowBack = document.getElementById('arrow-back');

function init()
{
    var imgArt = document.getElementById('pictureArt');
    imgArt.addEventListener('click', artPageLoader);

    var arrowBack = document.getElementById('arrow-back');
    arrowBack.addEventListener('click', homePageLoader);

    var imgPerson = document.getElementById('picturePerson');
    imgPerson.addEventListener('click' , personPageLoader);

}

/*
 * Function to change the section from resultpage to art-page
 */
function artPageLoader(){
    homePage.style.display = 'none';
    artPage.style.display = 'block';
    arrowBack.style.display = 'block';
}
/*
 * Function to change the section from resultpage to Personal Page
 */
function personPageLoader() {
    homePage.style.display = 'none';
    arrowBack.style.display = 'block';
    personalPage.style.display = 'block';
}
/*
 * Function when back arrow is clicked go back to homepage
 */
function homePageLoader() {
    artPage.style.display='none';
    personalPage.style.display = 'none';
    homePage.style.display = 'block';
    arrowBack.style.display = 'none';
}