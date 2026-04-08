<?php
include '../config/connection.php';

$sql = "SELECT s.id, m.Title, s.start_time, s.end_time 
        FROM screening s
        JOIN `movie details` m ON s.movie_id = m.movie_id";

$result = $connection->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id'    => $row['id'],
        'title' => 'Screening: ' . $row['Title'],
        'start' => $row['start_time'],
        'end'   => $row['end_time']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);

$connection->close();
?>
