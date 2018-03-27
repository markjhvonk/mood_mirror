# Museumpark Mood Mirror
A small project where a photo of you is taken and matched to an artwork from the Rijksmuseum API

Most of the code is deprecated and made for older web technologies. Therefor its near impossible to 
replicate this project in your own enviroment without changing nearly all the code.
Chrome (and other browsers) made it necassary to have an ssl sertificate to make use of the users webcam (which makes sense).
The Microsoft face API was integrated into the Microsoft Azure program, which means you now need to pay to use the API intensively.
They also changed the structure of the API so none of this code works anymore.

### API's used:
* [Microsoft face API](https://azure.microsoft.com/en-us/services/cognitive-services/face/)
* [Rijksmuseum API](http://rijksmuseum.github.io/)

### How it works:
1. User takes photo and is uploaded to server
2. Photo is run through the Microsoft Face API
3. Data about user expression is collected in the following format:
```json
"emotion": {
  "anger": 0.071,
  "contempt": 0.272,
  "disgust": 0.004,
  "fear": 0.0,
  "happiness": 0.0,
  "neutral": 0.637,
  "sadness": 0.016,
  "surprise": 0.0
}
```
4. The highest result is rounded up to 1 and run through a switch which determines which is the main emotion of the user in the photo.
5. Every emotion has a hex color assigned to it which is then used to filter artworks in the Rijksmuseum API.
6. A random artwork from the 10 that are picked is presented to the user.
