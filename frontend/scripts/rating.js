stars.forEach(star => {
    star.addEventListener('click', () => {
        const value = star.getAttribute('data-value');
        ratingValue.textContent = `${value}`;
        updateStar(value);
    });

});

function updateStar(value) {
    stars.forEach(star => {
        const starValue = star.getAttribute('data-value');
        star.src = starValue <= value ? './../assets/icons/star.svg' : './../assets/icons/star-empty.svg';
    });
}

xButton.addEventListener('click', ()=>{
    modal.classList.toggle('hidden')
    console.log('pressed')
})