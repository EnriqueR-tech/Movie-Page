<?php
 include '../config/connection.php';
    $movie_id = $_POST['movie_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $check = $connection->prepare("
    SELECT * FROM screenings 
    WHERE NOT (end_time <= ? OR start_time >= ?)");

    $check->bind_param("ss", $start_time, $end_time);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Conflict: Screening overlaps with an existing one.";
    } else {
        $stmt = $connection->prepare("INSERT INTO screenings (movie_id, start_time, end_time) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $movie_id, $start_time, $end_time);
        
        if ($stmt->execute()) {
            echo "Screening added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $connection->close();
?>