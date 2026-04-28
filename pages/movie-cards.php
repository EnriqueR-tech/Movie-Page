<?php
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
</head>

<body>
    <div class="container-fluid bg-dark text-white text-center py-4">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark px-4">
        <div class="container-fluid d-flex align-items-center">

            <div class="flex-grow-1 d-none d-lg-block" style="flex-basis: 0;"></div>

            <div class="flex-grow-0">
                <ul class="nav nav-pills nav-fill">
                    <li class="nav-item"><a class="nav-link text-white" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active bg-danger" href="movie-cards.php">Movies</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="tickets-purchase.php">Get Tickets</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="aboutUs.php">About Us</a></li>
                </ul>
            </div>

            <div class="flex-grow-1 d-flex justify-content-end " style="flex-basis: 0; padding-right: 20px;">
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

    <!-- To Do
     1. Implement a modal pop up to get full details of the movie when the user clicks on the movie card
        1a. Replace 'Get Tickets' button with 'View Details' button that will trigger the modal pop up    
    -->

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
                            <button class="btn btn-danger btn-block"
                             data-toggle="modal" data-target="#movieModal"
                              data-title="<?php echo htmlspecialchars($movie['title']); ?>" data-image="<?php echo htmlspecialchars($movie['image']); ?>" data-description="<?php echo htmlspecialchars($movie['description']); ?>"    
                              data-movie-id="<?php echo $movie['movie_id']; ?>">More Details</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="modal fade" id="movieModal" tabindex="-1" aria-labelledby="movieModalCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content  mx-auto">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="movieModalCardLabel"><?php echo htmlspecialchars($movie['title']); ?></h5>
                    <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-dark text-white">
                    <img src="../assets/images/<?php echo htmlspecialchars($movie['image']); ?>" class="img-fluid mb-4 w-50" alt="<?php echo htmlspecialchars($movie['title']); ?>" id="moviePoster">
                    <p id="movieOverview"><?php echo htmlspecialchars($movie['description']); ?></p>
                    <ul class="list-group">

                    </ul>
                </div>
            </div>
        </div>
    </div>
<!-- modal js -->
<script>
    document.querySelectorAll('button[data-toggle="modal"]').forEach(button => {
        button.addEventListener('click', function() {
            const title = this.getAttribute('data-title');
            const image = this.getAttribute('data-image');
            const description = this.getAttribute('data-description');

            document.getElementById('movieModalCardLabel').textContent = title;
            document.getElementById('moviePoster').src = `../assets/images/${image}`;
            document.getElementById('movieOverview').textContent = description;
        });
    });
</script>

<!-- Page JS (search preview ) -->
 <script src="../assets/js/movie-search.js"></script>

</body>

</html>