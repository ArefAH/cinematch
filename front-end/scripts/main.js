window.onload = async function () {
  try {
    console.log("Fetching movie data...");
    const response = await fetch('http://localhost:5501/movies');
    if (!response.ok) {
      throw new Error(`Failed to fetch movie images: ${response.statusText}`);
    }

    // Parse the movie data from the response
    const movies = await response.json();
    console.log("Movies data received:", movies);

    // Get the container where the movie images will be placed
    const container = document.getElementById('movies-container');
    if (!container) {
      console.error("Container element not found!");
      return;
    }

    // If no movies data
    if (movies.length === 0) {
      console.log("No movies found in the response.");
    }

    // Loop through each movie and create image elements
    movies.forEach((movie) => {
      const img = document.createElement('img');
      img.src = movie.imageSrc;
      img.style.width = '300px';
      img.style.height = '450px';
      img.style.objectFit = 'cover';
      img.style.borderRadius = '4px';

      // Add event listener for the image click
      img.addEventListener('click', function () {
        console.log("Image clicked:", this.src);  // This will log the image src when clicked

        // Redirect to a.html and pass the image src as a query parameter
        window.location.href = `a.html?imageSrc=${encodeURIComponent(this.src)}`;
      });

      // Append the image to the movies container
      container.appendChild(img);
    });

  } catch (error) {
    console.error('Error loading movies:', error);
  }
};
