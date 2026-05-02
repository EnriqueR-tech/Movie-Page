<?php
session_start();
include "../config/connection.php";

$theater = $_SESSION['theater'] ?? "Select Theater";
$displayTheater = is_array($theater)
    ? ($theater['name'] ?? "Select Theater")
    : $theater;

$stmt = $connection->prepare("
    SELECT 
        t.id,
        t.customer_name,
        t.tickets,
        t.theater_loc,
        t.show_date,
        t.show_time,
        t.ticket_code,
        m.title,
        m.image
    FROM tickets t
    JOIN movies m ON t.movie_id = m.movie_id
    ORDER BY t.id DESC
");

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <?php include "../config/header.php"; ?>
    <link rel="stylesheet" href="../config/style.css">
    <title>Ticket History</title>
</head>

<body>

<div class="container-fluid bg-dark text-white text-center py-3">
    <h3>🎬 Team Popcorn</h3>
</div>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark justify-content-center">
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item"><a class="nav-link text-white" href="../index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="movie-cards.php">Movies</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="tickets-purchase.php">Get Tickets</a></li>
        <li class="nav-item"><a class="nav-link active bg-danger" href="tickets-history.php">History</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="about-us.php">About Us</a></li>
    </ul>
</nav>

<div class="top-bar">
    📍 <?php echo htmlspecialchars($displayTheater); ?>
    <a href="theater-select.php">CHANGE</a>
</div>

<div class="container mt-4">

    <?php while ($row = $result->fetch_assoc()): ?>

        <div class="ticket-history-card">

            <img src="../assets/images/<?php echo $row['image']; ?>" class="ticket-history-img">

            <div class="ticket-history-info">

                <h4 class="movie-title"><?php echo $row['title']; ?></h4>

                <p><span class="label">Name:</span> <span class="value"><?php echo $row['customer_name']; ?></span></p>

                <p><span class="label">Tickets:</span> <span class="value"><?php echo $row['tickets']; ?></span></p>

                <p><span class="label">Theater:</span> <span class="value"><?php echo $row['theater_loc']; ?></span></p>

                <p><span class="label">Ticket Code:</span> <span class="value"><?php echo $row['ticket_code']; ?></span></p>

                <p class="time">
                    <?php
                        echo date("M d, h:i A", strtotime($row['show_date'] . " " . $row['show_time']));
                    ?>
                </p>

            </div>

        </div>

    <?php endwhile; ?>

</div>

</body>
</html>