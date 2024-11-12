const userId = window.localStorage.getItem("userId");
const movieId = window.localStorage.getItem("movieId");

const instance = axios.create({
  baseURL: "https://localhost/cinematch/backend/",
});

const getInfo = async () => {
  const response = await instance.post("/getInfo.php", {
    userId: userId,
    movieId: movieId,
  });
  const data = response.data;
  poster.src = data.image;
  title.textContent = data.title;
  duration.textContent = data.duration;
  genre.textContent = data.genre;
  description.textContent = data.description;
};

getInfo();

const getRating = async () => {
  const response = await instance.post("/getRating.php", {
    userId: userId,
    movieId: movieId,
  });
  const data = response.data;
  rating.textContent = data.rating;
};

getRating();
