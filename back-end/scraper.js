import puppeteer from 'puppeteer';
import mysql from 'mysql2';

const getSpecificData = async () => {
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

  const browser = await puppeteer.launch({
    headless: false, 
    defaultViewport: null,
  });

  const page = await browser.newPage();

  await page.goto('https://www.pathe.fr/films/a-toute-allure-35334', {
    waitUntil: 'domcontentloaded',
  });

  const specificData = await page.evaluate(() => {
    const title = document.querySelector('h1') ? document.querySelector('h1').innerText.trim() : null;
    const cast = document.querySelector('.ft-default.c-white-70.mb-1') ? document.querySelector('.ft-default.c-white-70.mb-1').innerText.trim() : null;
    const description = document.querySelector('.hero-film__desc.ft-default.c-white.desktop-only') ? document.querySelector('.hero-film__desc.ft-default.c-white.desktop-only').innerText.trim() : null;
    
    const genreElements = document.querySelectorAll('.ft-default.ft-500.mb-0');
    const genre = genreElements.length > 1 ? genreElements[1].innerText.trim() : null;  

    return {
      title,
      cast,
      description,
      genre,
    };
  });

  console.log("Scraped Data:");
  console.log(`Title: ${specificData.title}`);
  console.log(`Cast: ${specificData.cast}`);
  console.log(`Description: ${specificData.description}`);
  console.log(`Genre: ${specificData.genre}`);



}

getSpecificData();
