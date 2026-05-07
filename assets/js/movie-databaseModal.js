
document.querySelectorAll('[data-toggle="modal"]').forEach(function(trigger) {
    trigger.addEventListener('click', function(e) {
        e.preventDefault();

        const title = this.getAttribute('data-title');
        const image = this.getAttribute('data-image');
        const runtime = this.getAttribute('data-runtime');
        const rating = this.getAttribute('data-rating');
        const description = this.getAttribute('data-description');
        

        const runtimeParts = runtime.split(':');
        const runtimeDisplay = parseInt(runtimeParts[0]) + " HR " + parseInt(runtimeParts[1]) + " MIN";
        
        
        document.getElementById('movieModalCardLabel').textContent = title;
        document.getElementById('moviePoster').src = `../assets/images/${image}`;
        document.getElementById('movieOverview').textContent = description;
        
        document.getElementById('movieRuntime').textContent = 'Runtime: ' + runtimeDisplay;
        document.getElementById('movieRating').textContent = 'Rating: ' + rating;
        document.getElementById('movieHeroBg').style.backgroundImage = "url('../assets/images/" + image + "')";
    });
});
