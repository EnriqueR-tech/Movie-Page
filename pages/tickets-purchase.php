<?php
session_start();
include "../config/connection.php";

$selectedMovie = $_GET['movie_id'] ?? "";


if (!isset($_SESSION['theater'])) {
    $_SESSION['theater'] = "Default Theater";
}

$theater_session = $_SESSION['theater'];

$displayTheater = is_array($theater_session)
    ? ($theater_session['name'] ?? "Default Theater")
    : $theater_session;


$movie = null;

if ($selectedMovie) {
    $stmt = $connection->prepare("
        SELECT * FROM movies WHERE movie_id = ?
    ");
    $stmt->bind_param("i", $selectedMovie);
    $stmt->execute();
    $movie = $stmt->get_result()->fetch_assoc();
}

$stmt = $connection->prepare("
    SELECT movie_id, title
    FROM movies
    ORDER BY title
");
$stmt->execute();
$movieList = $stmt->get_result();

$showtimes = null;

if ($selectedMovie) {
    $stmt = $connection->prepare("
        SELECT id, start_time, capacity
        FROM screenings
        WHERE movie_id = ?
        AND capacity > 0
        ORDER BY start_time
    ");

    $stmt->bind_param("i", $selectedMovie);
    $stmt->execute();
    $showtimes = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../config/header.php"; ?>
    <link rel="stylesheet" href="../config/style.css">
    <title>Get Tickets</title>
</head>

<body>

<div class="container-fluid bg-dark text-white text-center py-3">
    <h3>🎬 Team Popcorn</h3>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
    <ul class="nav nav-pills nav-fill">

        <li class="nav-item">
            <a class="nav-link text-white" href="../index.php">Home</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="movie-cards.php">Movies</a>
        </li>

        <li class="nav-item">
            <a class="nav-link active bg-danger" href="tickets-purchase.php">Get Tickets</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="tickets-history.php">History</a>
        </li>

        <li class="nav-item">
            <a class="nav-link text-white" href="about-us.php">About Us</a>
        </li>

    </ul>
</nav>

<div class="top-bar">
    📍 <?php echo htmlspecialchars($displayTheater); ?>
    <a href="theater-select.php">CHANGE</a>
</div>

<div class="container mt-4">

    <div class="ticket-wrapper justify-content-center">

        <div class="movie-preview text-center">

            <h4>Select Movie</h4>

            <select class="form-control form-select mb-3"
                onchange="location.href='tickets-purchase.php?movie_id='+this.value">

                <option disabled selected>Select Movie</option>

                <?php while ($m = $movieList->fetch_assoc()): ?>
                    <option value="<?php echo $m['movie_id']; ?>"
                        <?php echo ($selectedMovie == $m['movie_id']) ? 'selected' : ''; ?>>
                        <?php echo $m['title']; ?>
                    </option>
                <?php endwhile; ?>

            </select>

            <?php if ($movie): ?>
                <div class="movie-card">
                    <img src="../assets/images/<?php echo $movie['image']; ?>" alt="">
                </div>
            <?php endif; ?>

        </div>

        <div class="ticket-form">

            <h3 class="mb-3 text-center">Book Tickets</h3>

            <form method="POST" action="../handlers/tickets-save.php">

                <input type="hidden" name="movie_id" value="<?php echo $selectedMovie; ?>">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Showtimes</label>

                    <select name="screening_id" id="showtimeSelect"
                        class="form-control form-select" required>

                        <option disabled selected>Select Showtime</option>

                        <?php
                        $hasShowtimes = false;

                        if ($showtimes && $showtimes->num_rows > 0) {

                            while ($s = $showtimes->fetch_assoc()) {
                                $hasShowtimes = true;
                        ?>
                                <option value="<?php echo $s['id']; ?>"
                                    data-capacity="<?php echo $s['capacity']; ?>">

                                    <?php
                                    echo date("M d, g:i A", strtotime($s['start_time']));
                                    echo " — " . $s['capacity'] . " seats";
                                    ?>

                                </option>
                        <?php
                            }
                        }
                        ?>

                    </select>

                    <?php if (!$hasShowtimes): ?>
                        <p style="color:#ff4d4d;font-weight:bold;margin-top:10px;">
                            No Showtimes Available for this movie
                        </p>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label>Tickets</label>
                    <input type="number" name="tickets" id="ticketInput"
                        class="form-control" value="1" min="1" required>
                </div>

                <button class="btn btn-danger w-100 py-2">
                    BOOK NOW
                </button>

            </form>

        </div>

    </div>

</div>

<script>
const showtimeSelect = document.getElementById("showtimeSelect");
const ticketInput = document.getElementById("ticketInput");

function updateMax() {
    const option = showtimeSelect.options[showtimeSelect.selectedIndex];
    const capacity = option?.getAttribute("data-capacity");

    if (capacity) {
        ticketInput.max = capacity;

        if (parseInt(ticketInput.value) > parseInt(capacity)) {
            ticketInput.value = capacity;
        }
    }
}

showtimeSelect.addEventListener("change", updateMax);
</script>

</body>
</html>