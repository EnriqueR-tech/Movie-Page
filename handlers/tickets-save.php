<?php
session_start();
include "../config/connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $movie_id = intval($_POST['movie_id']);
    $customer = $connection->real_escape_string($_POST['customer_name']);
    $count = intval($_POST['tickets']);
    $date = $_POST['show_date'];
    $time = $_POST['show_time'];
    
    $theater_session = $_SESSION['theater'];
    $theater = is_array($theater_session) ? ($theater_session['name'] ?? "") : $theater_session;

    // 1. Verify Screening
    $stmt = $connection->prepare("SELECT id, capacity FROM screenings WHERE movie_id=? AND theater_name=? AND DATE(start_time)=? AND TIME(start_time)=? LIMIT 1");
    $stmt->bind_param("isss", $movie_id, $theater, $date, $time);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();

    if ($res) {
        if ($res['capacity'] >= $count) {
            // 2. Reduce Capacity
            $new_cap = $res['capacity'] - $count;
            $connection->query("UPDATE screenings SET capacity = $new_cap WHERE id = ".$res['id']);

            // 3. Save Ticket
            $ins = $connection->prepare("INSERT INTO tickets (movie_id, theater_loc, customer_name, tickets, show_date, show_time) VALUES (?, ?, ?, ?, ?, ?)");
            $ins->bind_param("ississ", $movie_id, $theater, $customer, $count, $date, $time);
            $ins->execute();

            echo "<script>alert('Success!'); window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Sold out!'); window.history.back();</script>";
        }
    } else {
        echo "Error: Screening not found.";
    }
}
?>