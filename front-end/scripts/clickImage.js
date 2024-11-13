
const images = document.querySelectorAll('#movies-container');

images.forEach(image => {
  image.addEventListener('click', function(event) {
    const imageSrc = event.target.src;  
    const imageAlt = event.target.alt;  

    console.log('You clicked on image with source:', imageSrc);
    console.log('Image Alt Text:', imageAlt);
  });
});
