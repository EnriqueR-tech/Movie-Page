<?php
session_start();
include "../config/connection.php";

$theater = $_SESSION['theater'] ?? '';

$query = "SELECT s.*, m.title 
          FROM screenings s 
          JOIN movies m ON s.movie_id = m.movie_id";

// This satisfies the "Filter by theater location" backlog item
if (!empty($theater)) {
    $safe_theater = $connection->real_escape_string($theater);
    $query .= " WHERE s.theater_name = '$safe_theater'";
}

$result = $connection->query($query);
$events = [];

while($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['title'],
        'start' => $row['start_time'],
        'end'   => $row['end_time'],
        'color' => '#e50914' // AMC Red
    ];
}

header('Content-Type: application/json');
echo json_encode($events);