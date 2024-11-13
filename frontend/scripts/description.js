const userId = +window.localStorage.getItem("userId");
const movieId = +window.localStorage.getItem("movieId");

const instance = axios.create({
  baseURL: "http://localhost/cinematch/backend/",
});

const getInfo = async () => {
  const response = await instance.post("/getMovies.php", {
    userId: userId,
    movieId: movieId,
  });
  const data = response.data;
  const movie = data[0];
  poster.src = movie.image;
  title.textContent = movie.title;
  duration.textContent = movie.duration;
  genre.textContent = movie.genre;
  description.textContent = movie.description;
  movieBg.style.backgroundImage = `url('${movie.image}')`;
};

getInfo();

const getRating = async () => {
  const response = await instance.post("/getRating.php", {
    userId: userId,
    movieId: movieId,
  });
  const data = response.data;
  rating.textContent = data.rating;
  console.log(movieId);
};

getRating();

const addBookmark = async () => {
  try {
    const response = await instance.post("/addBookmark.php", {
      userId: userId,
      movieId: movieId,
    });
    console.log("Bookmark added successfully:", response.data);
  } catch (error) {
    console.error("Error adding bookmark:", error);
  }
};

bookmark.addEventListener("click", () => {
  console.log(userId, movieId);
  addBookmark;
});
