<?php
session_start();
include "../config/theaters.php";
$current = $_SESSION['theater'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include "../config/header.php"; ?>
<title>About Us</title>
</head>

<body>

<?php $current = $_SESSION['theater'] ?? null; ?>

<div class="amc-theater-bar">
    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 45 45" width="18" height="18">
        <path d="M34.65 4.808C31.277 1.436 26.499-.25 21.72.03 12.447.03 5.7 5.932 5.7 13.802c.843 11.524 5.902 22.204 14.053 30.074.562.562 1.405.843 2.249 1.124.843 0 1.405-.281 1.967-.843 5.902-5.06 14.615-18.831 14.334-30.355 0-3.373-1.405-6.745-3.653-8.994z"/>
    </svg>

    <a href="selectTheater.php" class="amc-theater-btn">
        <?php echo $current ?? "Select Theatre"; ?>
    </a>

    <a href="getTickets.php" class="amc-ticket-link">
        Get Tickets →
    </a>
</div>

<nav class="navbar navbar-expand-lg navbar-dark justify-content-center">
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item"><a class="nav-link text-white" href="../index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="allMovies.php">Movies</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="getTickets.php">Get Tickets</a></li>
        <li class="nav-item"><a class="nav-link active bg-danger" href="aboutUs.php">About Us</a></li>
    </ul>
</nav>

<!-- HERO -->
<div class="container text-center mt-5">
    <h1>About Team Popcorn 🍿</h1>
    <p class="text-muted">Your local AMC-style movie booking system</p>
</div>

<!-- GRID -->
<div class="container mt-4">

    <div class="row">

        <div class="col-md-4">
            <div class="movie-card p-3 text-center">
                <h4 class="text-danger">🎬 Mission</h4>
                <p>Simple movie booking system for students.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="movie-card p-3 text-center">
                <h4 class="text-danger">📍 Locations</h4>
                <p>Dallas College + AMC inspired theaters.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="movie-card p-3 text-center">
                <h4 class="text-danger">🍿 Experience</h4>
                <p>Fast booking, clean UI, real-time showtimes.</p>
            </div>
        </div>

    </div>

</div>

<!-- TEAM -->
<div class="container mt-4">

    <div class="movie-card p-4 text-center">

        <h3 class="text-danger">Team Popcorn</h3>

        <p>🎬 Jesus</p>
        <p>💻 Enrique</p>
        <p>🧠 Nayab</p>
        <p>⚙️ Christopher</p>

    </div>

</div>

</body>
</html>