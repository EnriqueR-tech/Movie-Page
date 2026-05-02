<?php
session_start();
include "../config/connection.php";

if (!isset($_SESSION['theater'])) {
    header("Location: ../pages/theater-select.php");
    exit;
}

$movie_id = $_POST['movie_id'];
$screening_id = $_POST['screening_id'];
$customer_name = $_POST['customer_name'];
$tickets = (int)$_POST['tickets'];


$stmt = $connection->prepare("
    SELECT s.*, m.title
    FROM screenings s
    JOIN movies m ON s.movie_id = m.movie_id
    WHERE s.id = ?
");
$stmt->bind_param("i", $screening_id);
$stmt->execute();
$screening = $stmt->get_result()->fetch_assoc();


if (!$screening) {
    die("Invalid screening selected.");
}

[$date, $time] = explode(" ", $screening['start_time']);


$theater = $_SESSION['theater'];
$theaterName = is_array($theater) ? $theater['name'] : $theater;


$ticketCode = strtoupper(uniqid("TK-"));


$update = $connection->prepare("
    UPDATE screenings
    SET capacity = capacity - ?
    WHERE id = ? AND capacity >= ?
");

$update->bind_param("iii", $tickets, $screening_id, $tickets);
$update->execute();

if ($update->affected_rows === 0) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Booking Failed</title>
        <link rel="stylesheet" href="../config/style.css">

        <style>
            body {
                background: #0b0b0b;
                color: #fff;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
            }

            .error-card {
                background: #141414;
                border: 1px solid #222;
                padding: 40px;
                border-radius: 12px;
                text-align: center;
                max-width: 450px;
            }

            .error-title {
                color: #e50914;
                font-size: 24px;
                margin-bottom: 10px;
            }

            .btn-back {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 18px;
                background: #e50914;
                color: #fff;
                text-decoration: none;
                border-radius: 8px;
                font-weight: bold;
            }

            .btn-back:hover {
                background: #ff1a1a;
            }
        </style>
    </head>

    <body>

        <div class="error-card">

            <div class="error-title">❌ Not enough seats available</div>

            <p>Please choose a lower ticket quantity or another showtime.</p>

            <a href="javascript:history.back()" class="btn-back">
                ← Go Back
            </a>

            <br>

            <a href="../pages/movie-cards.php" class="btn-back">
                Browse Movies
            </a>

        </div>

    </body>
    </html>
    <?php
    exit;
}

$stmt = $connection->prepare("
    INSERT INTO tickets 
    (movie_id, screening_id, customer_name, tickets, theater_loc, show_date, show_time, ticket_code)
    VALUES (?, ?, ?, ?, ?, DATE(?), TIME(?), ?)
");


$stmt->bind_param(
    "iisissss",
    $movie_id,
    $screening_id,
    $customer_name,
    $tickets,
    $theaterName,
    $screening['start_time'],
    $screening['start_time'],
    $ticketCode
);

$stmt->execute();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Ticket Confirmed</title>
    <link rel="stylesheet" href="../config/style.css">
</head>

<body>

<div class="container text-center mt-5">

    <div class="movie-card p-4" style="max-width:520px;margin:auto;">

        <h2 style="color:#e50914;">🎟 Ticket Confirmed</h2>

        <p style="color:#aaa;">Your Ticket Code:</p>

        <p style="font-size:18px;font-weight:bold;color:#fff;">
            <?php echo $ticketCode; ?>
        </p>

        <hr style="border-color:#333;">

        <a href="../pages/tickets-history.php"
           style="display:block;padding:12px;margin-bottom:10px;
           background:#e50914;color:#fff;text-decoration:none;
           font-weight:bold;border-radius:6px;text-align:center;">
            View My Tickets
        </a>

        <a href="../pages/movie-cards.php"
           style="display:block;padding:12px;
           background:#e50914;color:#fff;text-decoration:none;
           font-weight:bold;border-radius:6px;text-align:center;">
            Back to Movies
        </a>

    </div>

</div>

</body>
</html>