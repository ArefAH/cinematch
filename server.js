import express from 'express';
import mysql from 'mysql2';
import cors from 'cors';  

const app = express();
const port = 5500;  


app.use(cors());

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'cinematch',  
});


db.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL:', err.stack);
    return;
  }
  console.log('Connected to MySQL');
});

app.get('/movies', (req, res) => {
  const query = 'SELECT id,image FROM movies'; 

  db.query(query, (err, results) => {
    
    if (err) {
      console.error('Error fetching data from MySQL:', err);
      res.status(500).send('Error fetching data');
    } else {
      res.json(results);  
    }
  });
});

app.listen(port, () => {
  console.log(`Server running at http://localhost:${port}`);
});
