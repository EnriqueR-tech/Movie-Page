<?php
session_start();
include "../config/connection.php";

if (!isset($_SESSION['theater'])) {
    header("Location: theater-select.php");
    exit;
}

$selectedMovie = isset($_GET['movie_id']) ? (int)$_GET['movie_id'] : 0;
$theaterName = htmlspecialchars($_SESSION['theater']);

// Fetch movies
$movieList = $connection->query("SELECT movie_id, title FROM movies ORDER BY title");

// Fetch showtimes if movie selected
$showtimes = null;
if ($selectedMovie) {
    $stmt = $connection->prepare("
        SELECT id, start_time, capacity 
        FROM screenings 
        WHERE movie_id = ? AND capacity > 0 
        ORDER BY start_time ASC
    ");
    $stmt->bind_param("i", $selectedMovie);
    $stmt->execute();
    $showtimes = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Box Office - Staff Portal</title>
    <link rel="stylesheet" href="../config/style.css">
</head>
<body style="background:#1e1e1e;color:white;font-family:sans-serif;">

<div style="max-width:600px;margin:50px auto;background:#2c2c2c;padding:25px;border-radius:10px;">
    <h2 style="text-align:center;">🎟️ Internal Box Office</h2>
    <p style="text-align:center;color:#ffc107;">
        Logging sales for: <strong><?php echo $theaterName; ?></strong>
    </p>

    <form method="POST" action="../handlers/tickets-save.php">

        <!-- Movie -->
        <label>Select Movie</label>
        <select name="movie_id" onchange="location.href='box-office.php?movie_id='+this.value" style="width:100%;padding:10px;">
            <option disabled <?php echo !$selectedMovie ? 'selected' : ''; ?>>--- Choose Movie ---</option>
            <?php while ($m = $movieList->fetch_assoc()): ?>
                <option value="<?php echo $m['movie_id']; ?>" <?php echo ($selectedMovie == $m['movie_id']) ? 'selected' : ''; ?>>
                    <?php echo $m['title']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <?php if ($selectedMovie): ?>
            <input type="hidden" name="movie_id" value="<?php echo $selectedMovie; ?>">

            <!-- Customer -->
            <label>Customer Name</label>
            <input type="text" name="customer_name" required style="width:100%;padding:10px;">

            <!-- Showtime -->
            <label>Select Showtime</label>

            <?php if ($showtimes && $showtimes->num_rows > 0): ?>
                <select name="screening_id" required style="width:100%;padding:10px;">
                    <?php while ($s = $showtimes->fetch_assoc()): ?>
                        <option value="<?php echo $s['id']; ?>">
                            <?php echo date("g:i A", strtotime($s['start_time'])); ?>
                            (<?php echo $s['capacity']; ?> seats left)
                        </option>
                    <?php endwhile; ?>
                </select>
            <?php else: ?>
                <p style="color:red;">No available showtimes.</p>
            <?php endif; ?>

            <!-- Quantity -->
            <label>Quantity</label>
            <input type="number" name="tickets" value="1" min="1" required style="width:100%;padding:10px;">

            <button type="submit" style="width:100%;margin-top:15px;padding:12px;background:red;color:white;border:none;">
                COMPLETE SALE
            </button>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
