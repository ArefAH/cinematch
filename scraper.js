import puppeteer from "puppeteer";
import mysql from "mysql2";

const db = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "cinematch",
});

db.connect((err) => {
  if (err) {
    console.error("Error connecting to MySQL:", err.stack);
    return;
  }
  console.log("Connected to MySQL");
});

const getMovies = async () => {
  const browser = await puppeteer.launch({
    headless: false,
    defaultViewport: null,
  });

  const page = await browser.newPage();

  await page.goto("https://www.pathe.fr/cinemas/cinema-pathe-wilson", {
    waitUntil: "domcontentloaded",
  });

  const movies = await page.evaluate(() => {
    const movieElements = document.querySelectorAll(".card-screening__content");
    return Array.from(movieElements).map((movie) => {
      const image =
        movie
          .querySelector("picture.card-screening__img img")
          ?.getAttribute("src") || "";
      const link =
        movie
          .querySelector(".card-screening__content a")
          ?.getAttribute("href") || "";
      const title =
        movie.querySelector(".h3.ft-700.mt-1.mb-04 a")?.innerText.trim() || "";
      const genreDuration =
        movie.querySelector(".ft-secondary span")?.innerText.trim() || "";
      const [genrePart, durationPart] = genreDuration.split("(");
      const genre = genrePart.trim();
      const duration = durationPart ? durationPart.replace(")", "").trim() : "";
      return {
        image,
        link: link ? `https://www.pathe.fr${link}` : "",
        title,
        genre,
        duration,
      };
    });
  });

  for (const movie of movies) {
    const insertQuery =
      "INSERT INTO `movies-info` (image, link, title, genre, duration, description) VALUES (?, ?, ?, ?, ?, ?)";
    db.query(
      insertQuery,
      [
        movie.image,
        movie.link,
        movie.title,
        movie.genre,
        movie.duration,
        movie.description,
      ],
      (err, results) => {
        if (err) {
          console.error("Error inserting movie into database:", err);
        } else {
          console.log(`Inserted movie: ${movie.title}`);
        }
      }
    );
  }

  await browser.close();

  db.end((err) => {
    if (err) {
      console.error("Error closing MySQL connection:", err.stack);
    } else {
      console.log("MySQL connection closed");
    }
  });
};

getMovies();
