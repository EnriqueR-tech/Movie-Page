<?php
// pages/allMovies.php
session_start();
include "../config/connection.php";

// Fetch all movies for the main grid
$result = $connection->query("SELECT * FROM movies ORDER BY movie_id ASC");
$movies = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "../config/header.php"; ?>
    <title>All Movies</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark px-4">
        <div class="container-fluid d-flex align-items-center">

            <div class="flex-grow-1 d-none d-lg-block" style="flex-basis: 0;"></div>

            <div class="flex-grow-0">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active bg-danger" href="allMovies.php">Movies</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="getTickets.php">Get Tickets</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="aboutUs.php">About Us</a></li>
                </ul>
            </div>

            <div class="flex-grow-1 d-flex justify-content-end" style="flex-basis: 0; padding-right: 20px;">
                <div class="right-search">
                    <input
                        aria-label="Search"
                        id="search-input"
                        class="nav-search-input"
                        placeholder="Search"
                        type="text"
                        name="query"
                        autocomplete="off">

                    <span class="search-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </span>

                    <div id="search-preview" class="search-preview-dropdown"></div>
                </div>
            </div>

        </div>
    </nav>

    <!-- Movie Grid -->
    <div class="container mt-4">
        <h1 class="text-center mb-4">Now Showing</h1>
        <div class="row" id="movieGrid">
            <?php foreach ($movies as $movie): ?>
                <div class="col-md-4 mb-4 movie-item">
                    <div class="movie-card">

                        <a href="movie-details.php?movie_id=<?php echo $movie['movie_id']; ?>">
                            <img src="../assets/images/<?php echo htmlspecialchars($movie['image']); ?>"
                                alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                style="width:100%; height:300px; object-fit:cover; cursor:pointer;">
                        </a>

                        <div class="p-3">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p>
                                <?php
                                $t = explode(":", $movie['runtime']);
                                echo intval($t[0]) . " HR " . intval($t[1]) . " MIN | " . htmlspecialchars($movie['rating']);
                                ?>
                            </p>
                            <a href="tickets-purchase.php?movie_id=<?php echo $movie['movie_id']; ?>" class="btn btn-danger btn-block">Get Tickets</a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Search preview JS -->
    <script>
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
    </script>

</body>

</html>