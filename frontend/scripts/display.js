
window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const imageSrc = urlParams.get('imageSrc');
    const ids =urlParams.get('id');
    console.log(ids)

    if (imageSrc) {
        document.getElementById('movie-image').src = imageSrc;
    } else {
        console.error("No image source found in the URL.");
    }
};
