<?php
session_start();
include "../config/connection.php";

$theater = $_SESSION['theater'] ?? '';

$query = "SELECT s.*, m.title 
          FROM screenings s 
          JOIN movies m ON s.movie_id = m.movie_id";


$result = $connection->query($query);
$events = [];

while($row = $result->fetch_assoc()) {
    $events[] = [
        'id' => $row['id'],
        'title' => 'At: ' . $row['theater_name'] . ' - ' . $row['title'],
        'start' => $row['start_time'],
        'end'   => $row['end_time'],
        'color' => '#e50914' // AMC Red
    ];
}

header('Content-Type: application/json');
echo json_encode($events);