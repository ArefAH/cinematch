import puppeteer from 'puppeteer';
import mysql from 'mysql2';

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',         
  password: '',         
  database: 'movieDB',  
});


db.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err.stack);
    return;
  }
  console.log('Connected to MySQL');
});

const getMovies = async () => {

  const browser = await puppeteer.launch({
    headless: false,
    defaultViewport: null,
  });


  const page = await browser.newPage();

  await page.goto('https://www.pathe.fr/cinemas/cinema-pathe-wilson', {
    waitUntil: 'domcontentloaded',
  });

  const movies = await page.evaluate(() => {
    const imgList = document.querySelectorAll('picture.card-screening__img img');
    return Array.from(imgList).map((img) => {
      const imageSrc = img.getAttribute('src');
      const altText = img.getAttribute('alt');
      return { imageSrc, altText };
    });
  });

  for (const movie of movies) {
    const insertQuery = 'INSERT INTO movies (imageSrc, altText) VALUES (?, ?)';
    await new Promise((resolve, reject) => {
      db.query(insertQuery, [movie.imageSrc, movie.altText], (err, results) => {
        if (err) {
          console.error('Error inserting movie into database:', err);
          reject(err);
        } else {
          console.log(`Inserted movie: ${movie.altText}`);
          resolve(results);
        }
      });
    });
  }

  await browser.close();

  db.end((err) => {
    if (err) {
      console.error('Error closing MySQL connection:', err.stack);
    } else {
      console.log('MySQL connection closed');
    }
  });
};

getMovies();
