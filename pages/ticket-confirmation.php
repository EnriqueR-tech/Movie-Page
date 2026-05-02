<?php
session_start();
include "../config/connection.php";

$code = $_GET['code'] ?? "";

if (!$code) {
    die("Invalid ticket.");
}

$stmt = $connection->prepare("
    SELECT t.*, m.title, s.start_time
    FROM tickets t
    JOIN movies m ON m.movie_id = t.movie_id
    JOIN screenings s ON s.movie_id = m.movie_id
    WHERE t.ticket_code = ?
    LIMIT 1
");

$stmt->bind_param("s", $code);
$stmt->execute();
$ticket = $stmt->get_result()->fetch_assoc();

if (!$ticket) {
    die("Ticket not found.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <?php include "../config/header.php"; ?>
    <link rel="stylesheet" href="../css/style.css">

    <style>
        body {
            background: #0b0b0b;
            color: #fff;
        }

        .confirm-wrapper {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .confirm-card {
            background: #141414;
            border: 1px solid #222;
            padding: 40px;
            border-radius: 12px;
            max-width: 500px;
            width: 100%;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.6);
        }

        .ticket-code {
            font-size: 26px;
            font-weight: bold;
            color: #e50914;
            margin-top: 10px;
            word-break: break-word;
        }

        .btn-home {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 20px;
            background: #e50914;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
        }

        .btn-home:hover {
            background: #ff0a16;
        }
    </style>

    <title>Ticket Confirmation</title>
</head>

<body>

<div class="confirm-wrapper">

    <div class="confirm-card">

        <h2>🎟 Ticket Confirmed</h2>

        <hr style="border-color:#333;">

        <h4><?php echo htmlspecialchars($ticket['title']); ?></h4>

        <p><strong>Name:</strong> <?php echo htmlspecialchars($ticket['customer_name']); ?></p>
        <p><strong>Theater:</strong> <?php echo htmlspecialchars($ticket['theater_loc']); ?></p>
        <p><strong>Tickets:</strong> <?php echo $ticket['tickets']; ?></p>

        <p><strong>Date:</strong> <?php echo $ticket['show_date']; ?></p>
        <p><strong>Time:</strong> <?php echo date("g:i A", strtotime($ticket['show_time'])); ?></p>

        <hr style="border-color:#333;">

        <p>Your Ticket Code:</p>

        <div class="ticket-code">
            <?php echo $ticket['ticket_code']; ?>
        </div>

        <a href="../index.php" class="btn-home">Back to Home</a>

    </div>

</div>

</body>
</html>