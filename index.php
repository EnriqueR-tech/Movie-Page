<?php
session_start();
include "config/theaters.php";
include "config/connection.php";

// Fix theater display
$current = '';
if (isset($_SESSION['theater'])) {
    if (is_array($_SESSION['theater'])) {
        $current = $_SESSION['theater']['name'] ?? "Select Theatre";
    } else {
        $current = $_SESSION['theater'];
    }
} else {
    $current = "Select Theatre";
}

// Get featured movie
$featured = $connection->query("SELECT * FROM movies LIMIT 1");
$movie = $featured->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "config/header.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>

<body>

    <div class="container-fluid bg-dark text-white text-center py-4">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <div class="amc-theater-bar">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 45 45" width="18" height="18">
            <path d="M34.65 4.808C31.277 1.436 26.499-.25 21.72.03 12.447.03 5.7 5.932 5.7 13.802c.843 11.524 5.902 22.204 14.053 30.074.562.562 1.405.843 2.249 1.124.843 0 1.405-.281 1.967-.843 5.902-5.06 14.615-18.831 14.334-30.355 0-3.373-1.405-6.745-3.653-8.994z" />
        </svg>

        <a href="pages/theater-select.php" class="amc-theater-btn">
            <?php echo htmlspecialchars($current); ?>
        </a>
        
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark justify-content-center">
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item"><a class="nav-link active bg-danger" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="pages/movie-cards.php">Movies</a></li>
             <li class="nav-item">
            <a class="nav-link text-white" href="pages/tickets-history.php">History</a>
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="pages/tickets-purchase.php">Get Tickets</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="pages/aboutus.php">About Us</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-white" href="pages/movie-database.php">Add Movie</a>
                    <a class="dropdown-item text-white" href="pages/schedule-create.php">Schedule Screening</a>
                </div>
        </ul>
        
    </nav>

    <!-- To Do
     1. Implement a mock user login system to restrict access to the authorized access dropdown menu
        1a. Create a simple login page that sets a session variable to indicate the user is logged in
        1b. Add a logout option that clears the session variable and redirects to the login page
      -->


    <div class="container text-center mt-5">
        <h2>Welcome to Team Popcorn 🎬</h2>
        <p class="text-muted">Dallas College Movie Booking System</p>
        <?php if ($movie): ?>
            <a href="pages/movie-cards.php" class="btn btn-danger mt-3">Explore Movies</a>
        <?php else: ?>
            <p>No movies available at the moment.</p>
        <?php endif; ?>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h3 class="mb-3">Showtime Calendar</h3>
                <div class="movie-card p-3 bg-white text-dark" id="calendar"></div>
            </div>

            <div class="col-md-6">
                <h3 class="mb-3">Featured Movie</h3>
                <?php if ($movie): ?>
                    <div class="movie-card text-white">
                        <a href="pages/movie-details.php?movie_id=<?php echo $movie['movie_id']; ?>">
                            <img src="assets/images/<?php echo htmlspecialchars($movie['image']); ?>"
                                alt="<?php echo htmlspecialchars($movie['title']); ?>"
                                style="width:100%; height:300px; object-fit:cover; cursor:pointer;">
                        </a>

                        <div class="p-3">
                            <h4><?php echo htmlspecialchars($movie['title']); ?></h4>
                            <p>
                                <?php
                                if (!empty($movie['runtime'])) {
                                    $t = explode(":", $movie['runtime']);
                                    echo intval($t[0]) . " HR " . intval($t[1]) . " MIN | " . htmlspecialchars($movie['rating']);
                                } else {
                                    echo htmlspecialchars($movie['rating']);
                                }
                                ?>
                            </p>
                            <p class="text-muted"><?php echo nl2br(htmlspecialchars($movie['description'] ?? 'No description available.')); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No featured movie available.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-white text-center p-3 mt-4">
        <p>© 2024 Team Popcorn</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listWeek',
                headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek,dayGridMonth'
            },
                events: 'handlers/screening-fetch.php',
                dateClick: function(info) {
                    if (calendar.view.type === 'dayGridMonth') {
                        calendar.changeView('listDay', info.dateStr);
                    } else {
                        calendar.changeView('listWeek');
                    }
                }
            });
            calendar.render();
        });
    </script>

</body>

</html>