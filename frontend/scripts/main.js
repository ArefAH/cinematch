window.onload = async function () {
  try {
    console.log("Fetching movie data...");
    const response = await fetch('http://localhost:5501/movies');
    if (!response.ok) {
      throw new Error(`Failed to fetch movie images: ${response.statusText}`);
    }

    const movies = await response.json();
    console.log("Movies data received:", movies);

    const container = document.getElementById('movies-container');
    if (!container) {
      console.error("Container element not found!");
      return;
    }

    if (movies.length === 0) {
      console.log("No movies found in the response.");
    }

    movies.forEach((movie) => {
      const img = document.createElement('img');
      img.src = movie.imageSrc;
      img.style.width = '300px';
      img.style.height = '450px';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '4px';

      img.addEventListener('click', function () {
        console.log("Image clicked:", this.src); 

        window.location.href = `a.html?imageSrc=${encodeURIComponent(this.src)}`;
      });

      
      container.appendChild(img);
    });

  } catch (error) {
    console.error('Error loading movies:', error);
  }
};
