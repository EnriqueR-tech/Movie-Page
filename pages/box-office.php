<?php
session_start();
include "../config/connection.php";

/** 
 * STEP 1: SESSION VERIFICATION
 * We check if the employee has selected a theater location for their shift.
 * If not, we force a redirect to the selection page to ensure data integrity.
 */
if (!isset($_SESSION['theater'])) {
    header("Location: theater-select.php");
    exit;
}

// Retrieve state from URL or Session
$selectedMovie = $_GET['movie_id'] ?? "";
$theaterName = $_SESSION['theater'];

/**
 * STEP 2: DYNAMIC DATA RETRIEVAL
 * We fetch all available movies to populate the dropdown.
 */
$movieList = $connection->query("SELECT movie_id, title FROM movies ORDER BY title");

/**
 * STEP 3: CONDITIONAL SHOWTIME FILTERING
 * If a movie is selected, we fetch active screenings that still have seats.
 */
$showtimes = null;
if ($selectedMovie) {
    $stmt = $connection->prepare("SELECT id, start_time, capacity FROM screenings WHERE movie_id = ? AND capacity > 0");
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
    <title>Box Office - Staff Portal</title>
</head>
<body class="bg-dark text-white">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-secondary p-4 border-0 shadow-lg">
                <h2 class="text-center">🎟️ Internal Box Office</h2>
                <!-- Displays the current "Station" the employee is logged into -->
                <p class="text-center text-warning">Logging sales for: <strong><?php echo htmlspecialchars($theaterName); ?></strong></p>
                <hr>

                <!-- STEP 4: TRANSACTION FORM 
                     Directs the data to tickets-save.php for processing -->
                <form method="POST" action="../handlers/tickets-save.php">
                    <div class="mb-3">
                        <label>Select Movie</label>
                        <!-- JavaScript 'onchange' allows the page to refresh and load showtimes immediately -->
                        <select class="form-select" onchange="location.href='box-office.php?movie_id='+this.value">
                            <option disabled <?php echo !$selectedMovie ? 'selected' : ''; ?>>--- Choose Movie ---</option>
                            <?php while ($m = $movieList->fetch_assoc()): ?>
                                <option value="<?php echo $m['movie_id']; ?>" <?php echo ($selectedMovie == $m['movie_id']) ? 'selected' : ''; ?>>
                                    <?php echo $m['title']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <?php if ($selectedMovie): ?>
                        <input type="hidden" name="movie_id" value="<?php echo $selectedMovie; ?>">
                        
                        <div class="mb-3">
                            <label>Customer Name</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="Walk-in Customer Name" required>
                        </div>

                        <div class="mb-3">
                            <label>Select Showtime</label>
                            <select name="screening_id" class="form-select" required>
                                <?php while ($s = $showtimes->fetch_assoc()): ?>
                                    <option value="<?php echo $s['id']; ?>">
                                        <?php echo date("g:i A", strtotime($s['start_time'])); ?> 
                                        (<?php echo $s['capacity']; ?> seats remaining)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Quantity</label>
                            <input type="number" name="tickets" class="form-control" value="1" min="1" required>
                        </div>

                        <button type="submit" class="btn btn-danger w-100 fw-bold">COMPLETE SALE</button>
                    <?php endif; ?>
                </form>
                
                <div class="mt-3 text-center">
                    <a href="theater-select.php" class="text-light small">Change Station Location</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
