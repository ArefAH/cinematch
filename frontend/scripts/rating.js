let currentRating = 0;

stars.forEach((star) => {
  star.addEventListener("click", () => {
    const value = star.getAttribute("data-value");
    ratingValue.textContent = `${value}`;
    updateStar(value);
    currentRating = value;
  });
});

function updateStar(value) {
  stars.forEach((star) => {
    const starValue = star.getAttribute("data-value");
    star.src =
      starValue <= value
        ? "./../assets/icons/star.svg"
        : "./../assets/icons/star-empty.svg";
  });
}

xButton.addEventListener("click", () => {
  modal.classList.toggle("hidden");
});

rate.addEventListener("click", () => {
  modal.classList.toggle("hidden");
});

ratingButton.addEventListener("click", () => {
  addRating();
  modal.classList.toggle("hidden");
});

const addRating = async () => {
  const response = await fetch(
    "https://localhost/cinematch/backend/rating.php",
    {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        userId: userId,
        movieId: movieId,
        rating: currentRating,
      }),
    }
  );
};
