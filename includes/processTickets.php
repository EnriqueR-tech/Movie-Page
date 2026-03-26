<?php
include "../config/connection.php";

$movie_id = $_POST['movie_id'];
$name = $_POST['customer_name'];
$tickets = $_POST['tickets'];
$date = $_POST['show_date'];
$time = $_POST['show_time'];

// Insert into database (you need a tickets table)
$sql = "INSERT INTO tickets (movie_id, customer_name, tickets, show_date, show_time)
        VALUES ('$movie_id', '$name', '$tickets', '$date', '$time')";

if ($connection->query($sql) === TRUE) {
    echo "✅ Booking successful!";
} else {
    echo "❌ Error: " . $connection->error;
}
