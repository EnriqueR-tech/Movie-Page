
document.querySelectorAll('button[data-toggle="modal"]').forEach(button => {
    button.addEventListener('click', function() {
        document.getElementById('movieHeroBg').style.backgroundImage
            = "url('../assets/images/" + this.getAttribute('data-image') + "')";
            
            
        const title = this.getAttribute('data-title');
        const image = this.getAttribute('data-image');
        const runtime = this.getAttribute('data-runtime');
        const rating = this.getAttribute('data-rating');
        const description = this.getAttribute('data-description');
        const trailer = this.getAttribute('data-trailer');

        const runtimeParts = runtime.split(':');
        const runtimeDisplay = parseInt(runtimeParts[0]) + " HR " + parseInt(runtimeParts[1]) + " MIN";

        
        
        document.getElementById('movieModalCardLabel').textContent = title;
        document.getElementById('moviePoster').src = `../assets/images/${image}`;
        document.getElementById('movieOverview').textContent = description;
        document.getElementById('movieTrailer').src = 'https://www.youtube.com/embed/' + trailer;
        document.getElementById('movieRuntime').textContent = 'Runtime: ' + runtimeDisplay;
        document.getElementById('movieRating').textContent = 'Rating: ' + rating;
        document.getElementById('movieHeroBg').style.backgroundImage = "url('../assets/images/" + image + "')";
    });
});
    // Close modal - reset iframe so it doesn't bug out
document.getElementById('movieModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('movieTrailer').src = '';
});
