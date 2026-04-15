<?php
include '../config/connection.php';

$sql = "SELECT s.id, m.title, s.start_time, s.end_time 
        FROM screenings s
        JOIN `movies` m ON s.movie_id = m.movie_id";

$result = $connection->query($sql);

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'id'    => $row['id'],
        'title' => 'Screening: ' . $row['title'],
        'start' => $row['start_time'],
        'end'   => $row['end_time']
    ];
}

header('Content-Type: application/json');
echo json_encode($events);

$connection->close();
?>
