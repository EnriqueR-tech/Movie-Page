<?php
session_start();
include "../config/connection.php";

$selectedMovie = $_GET['movie_id'] ?? "";

if (!isset($_SESSION['theater'])) {
    header("Location: theater-select.php");
    exit;
}

// Get theater from session
$theater_session = $_SESSION['theater'];
$displayTheater = is_array($theater_session) ? ($theater_session['name'] ?? "Theater") : $theater_session;

$movie = null;
if ($selectedMovie) {
    $safe_id = intval($selectedMovie);
    $res = $connection->query("SELECT * FROM movies WHERE movie_id=$safe_id");
    $movie = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../config/header.php"; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>Tickets | Team Popcorn</title>
</head>
<body>
    <div style="background: #141414; padding: 12px 20px; border-bottom: 2px solid #e50914; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: bold; color: #fff;">📍 <?php echo htmlspecialchars($displayTheater); ?></span>
        <a href="theater-select.php" class="btn bg-white" style="color: #e50914; text-decoration: none; font-weight: bold; font-size: 0.8rem;">CHANGE THEATER</a>
    </div>

    <nav class="navbar">
        <div class="container d-flex justify-content-center gap-3">
            <a href="../index.php">Home</a>
            <a href="movie-cards.php">Movies</a>
            <a href="tickets-purchase.php" class="active">Tickets</a>
            <a href="aboutUs.php">About Us</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="ticket-wrapper">
            
            <div class="movie-preview">
                <div class="mb-4">
                    <label class="small text-muted d-block mb-2">SELECT MOVIE</label>
                    <select class="form-control form-select" onchange="location.href='tickets-purchase.php?movie_id='+this.value">
                        <option value="">-- Choose Movie --</option>
                        <?php
                        $all = $connection->prepare("SELECT DISTINCT m.* FROM movies m
                            INNER JOIN screenings s ON m.movie_id = s.movie_id
                            WHERE s.theater_name=?
                            AND DATE(s.start_time) >= CURDATE()
                            ORDER BY m.title");
                        $all->bind_param("s", $displayTheater);
                        $all->execute();
                        $all = $all->get_result();
                        while ($m = $all->fetch_assoc()) {
                            $s = ($m['movie_id'] == $selectedMovie) ? "selected" : "";
                            echo "<option value='{$m['movie_id']}' $s>{$m['title']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <?php if ($movie): ?>
                    <img src="../assets/images/<?php echo $movie['image']; ?>" class="img-fluid rounded shadow border border-secondary">
                <?php endif; ?>
            </div>

            <div class="ticket-form">
                <h3 class="mb-4 border-bottom pb-2">Reserve Seats</h3>
                <form method="POST" action="../handlers/tickets-process.php">
                    <input type="hidden" name="movie_id" value="<?php echo $selectedMovie; ?>">
                    
                    <div class="mb-3">
                        <label class="small text-muted mb-1">YOUR NAME</label>
                        <input type="text" name="customer_name" class="form-control" placeholder="Enter name" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">DATE</label>
                            <select name="show_date" class="form-control form-select" required>
                                <option value="">Select Date</option>
                                <?php
                                if ($selectedMovie) {
                                    $stmt = $connection->prepare("SELECT DISTINCT DATE(start_time) as d FROM screenings WHERE movie_id=? AND theater_name=?");
                                    $stmt->bind_param("is", $selectedMovie, $displayTheater);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while($row = $res->fetch_assoc()) {
                                        echo "<option value='{$row['d']}'>{$row['d']}</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="small text-muted mb-1">TIME</label>
                            <select name="show_time" class="form-control form-select" required>
                                <option value="">Select Time</option>
                                <?php
                                if ($selectedMovie) {
                                    $stmt = $connection->prepare("SELECT DISTINCT TIME(start_time) as t FROM screenings WHERE movie_id=? AND theater_name=?");
                                    $stmt->bind_param("is", $selectedMovie, $displayTheater);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while($row = $res->fetch_assoc()) {
                                        echo "<option value='{$row['t']}'>".date("g:i A", strtotime($row['t']))."</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="small text-muted mb-1">NUMBER OF TICKETS</label>
                        <input type="number" name="tickets" class="form-control" value="1" min="1" max="10">
                    </div>

                    <button type="submit" class="btn btn-danger w-100 py-3 fw-bold">BOOK NOW</button>
                </form>
            </div>

        </div>
    </div>
</body>
</html>