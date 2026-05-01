

const searchInput = document.getElementById('search-input');
const searchPreview = document.getElementById('search-preview');

let timer;

searchInput.addEventListener('input', function() {
    const term = this.value.trim();
    clearTimeout(timer);

    timer = setTimeout(() => {
        if (term.length === 0) {
            searchPreview.innerHTML = '';
            searchPreview.style.display = 'none';
            return;
        }

        fetch(`../handlers/searchMovies.php?q=${encodeURIComponent(term)}`)
            .then(res => res.text())
            .then(data => {
                searchPreview.innerHTML = data;
                searchPreview.style.display = data.trim() === '' ? 'none' : 'block';
            });
    }, 200); // debounce
});

// Hide preview when clicking outside
document.addEventListener('click', function(e) {
    if (!searchPreview.contains(e.target) && e.target !== searchInput) {
        searchPreview.style.display = 'none';
    }
});

