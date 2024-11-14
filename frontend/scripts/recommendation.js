const userId = +window.localStorage.getItem("userId");

const instance = axios.create({
  baseURL: "http://localhost/cinematch/backend/",
});

async function fetchMovies(userId) {
  const response = await instance.post("/getBookmark.php", {
    userId: userId,
  });

  const data = response.data;

  const moviesList = document.getElementById("movies-list");
  moviesList.innerHTML = "";

  data.forEach((movie) => {
    const listItem = document.createElement("li");
    listItem.innerHTML = `
            <div class="movie-card">
              <a href="./single-movie.html">
                <div class="card-banner">
                  <img src="${movie.image}" alt="${movie.title}">
                </div>
              </a>
            </div>
          `;
    moviesList.appendChild(listItem);
  });
}

fetchMovies(userId);
