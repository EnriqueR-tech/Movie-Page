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
        'extendedProps' => [
            'movie_id' => $row['movie_id'],
            'theater_name' => $row['theater_name'],
            'date' => date('Y-m-d', strtotime($row['start_time'])),
            'time' => date('H:i', strtotime($row['start_time']))
        ],
        'color' => '#e50914' // AMC Red
    ];
}

header('Content-Type: application/json');
echo json_encode($events);