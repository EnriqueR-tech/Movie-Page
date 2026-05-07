<?php
session_start();
include "../config/connection.php";

// Fetch all movies for the main grid
$result = $connection->query("SELECT * FROM movies WHERE is_hidden = 0 ORDER BY movie_id ASC");
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
                    <li class="nav-item"><a class="nav-link text-white" href="tickets-history.php">History</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="aboutus.php">About Us</a></li>
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
                            <h4 class="mb-4"><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <button class="btn btn-danger btn-block"
                             data-toggle="modal" data-target="#movieModal"
                              data-title="<?php echo htmlspecialchars($movie['title']); ?>"
                              data-runtime="<?php echo htmlspecialchars($movie['runtime']); ?>"
                              data-rating="<?php echo htmlspecialchars($movie['rating']); ?>"
                            data-image="<?php echo htmlspecialchars($movie['image']); ?>"
                             data-description="<?php echo htmlspecialchars($movie['description']); ?>"    
                              data-movie-id="<?php echo $movie['movie_id']; ?>"
                              data-trailer="<?php echo trim($movie['trailer_url']); ?>">More Details</button>
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
                    <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >&times;</span>
                    </button>
                </div>

                <div class="modal-body bg-dark text-white">
                    <section class="movie-hero">
                        <div class="hero-bg" id="movieHeroBg"
                        style="background-image: url('../assets/images/<?php echo htmlspecialchars($movie['image']); ?>');">
                            <div class="hero-overlay"></div>
                            <div class="hero-content">

                                <div class="hero-poster">
                                    <img src="../assets/images/<?php echo $movie['image']; ?>" id="moviePoster" alt="<?php echo htmlspecialchars($movie['title']); ?>">
                                </div>

                                <div class="hero-info">

                                    <h1 id="movieModalCardLabel"><?php echo $movie['title']; ?></h1>

                                    <div class="d-flex justify-content-start mb-3 ">
                                        <h4 class="mb-3 mr-4">
                                            <span class="badge badge-success p-2" id="movieRuntime">Runtime: <?php
                                                $t = explode(":", $movie['runtime']);
                                                echo intval($t[0]) . " HR " . intval($t[1]) . " MIN";
                                                ?> </span>
                                        </h4>
                                        <h4 class="mb-3">
                                            <span class="badge badge-info p-2" id="movieRating">Rating: <?php echo htmlspecialchars($movie['rating']); ?> </span>
                                        </h4>
                                    </div>

                                    <p class="desc" id="movieOverview">
                                        <?php echo $movie['description']; ?>
                                    </p>
                                    <a class="btn-ticket"
                                    href="tickets-purchase.php?movie_id=<?php echo $movie['movie_id']; ?>">
                                    Get Tickets
                                    </a>
                                </div>
                            </div>
                        </div>

                    </section>
                    
                    <iframe id="movieTrailer" width="100%" height="400" src='https://www.youtube.com/embed/ <?php echo htmlspecialchars($movie['trailer_url']); ?>' title="YouTube video player" frameborder="0" ></iframe>

                </div>
            </div>
        </div>
    </div>
    
<!-- Page JS (search preview ) -->
 <script src="../assets/js/movie-search.js"></script>

 <!-- Modal Cards button JS -->
 <script src="../assets/js/movie-cardsModal.js"></script>

</body>

</html>