window.onload = async function () {
  try {
    const response = await fetch('http://localhost:5501/movies'); 
    if (!response.ok) {
      throw new Error(`Failed to fetch movie images: ${response.statusText}`);
    }

    const movies = await response.json();  

    const container = document.getElementById('movies-container');

    movies.forEach((movie, index) => {
      const movieElement = document.createElement('li');
      movieElement.classList.add('movie-card');

      const cardBanner = document.createElement('figure');
      cardBanner.classList.add('card-banner');

      const img = document.createElement('img');
      img.src = movie.imageSrc;  
      img.style.width = '300px';  
      img.style.height = '450px'; 
      img.style.objectFit = 'fit'; 
      img.style.borderRadius = '4px'; 

      cardBanner.appendChild(img);

      const link = document.createElement('a');
      link.href = './movie-details.html';
      link.appendChild(cardBanner);

      movieElement.appendChild(link);

      container.appendChild(movieElement);
    });
  } catch (error) {
    console.error('Error loading movies:', error);
  }
};
