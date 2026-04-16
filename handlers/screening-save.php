<?php
 include '../config/connection.php';
    $movie_id = $_POST['movie_id'];
    $theater_name = $_POST['theater_name'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    if (empty($theater_name)) {
        echo "Error: Theater name is required.";
        exit;
    }

    $check = $connection->prepare("
    SELECT * FROM screenings 
    WHERE theater_name = ?
    AND NOT (end_time <= ? OR start_time >= ?)");

    $check->bind_param("sss", $theater_name, $start_time, $end_time);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "Conflict: Screening overlaps with an existing one.";
    } else {
        $stmt = $connection->prepare("INSERT INTO screenings (movie_id, theater_name, start_time, end_time) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $movie_id, $theater_name, $start_time, $end_time);

        if ($stmt->execute()) {
            echo "Screening added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $connection->close();
?>