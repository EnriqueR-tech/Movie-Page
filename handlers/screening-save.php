<?php
// =====================================================
//  screening-save.php
// end_time = start_time + movie runtime (auto-calculated)
// Manager can override end_time from the frontend.
// If end_time is missing/empty, server calculates it.
// =====================================================

include '../config/connection.php';

$movie_id     = $_POST['movie_id']     ?? '';
$theater_name = $_POST['theater_name'] ?? '';
$start_time   = $_POST['start_time']   ?? '';
$end_time     = $_POST['end_time']     ?? '';
$capacity     = (int)($_POST['capacity'] ?? 100);

// Basic validation
if (empty($theater_name)) {
    echo "Error: Theater name is required.";
    exit;
}
if (empty($movie_id) || empty($start_time)) {
    echo "Error: Movie and start time are required.";
    exit;
}

// =====================================================
// Server-side safety net:
// If frontend didn't send end_time (or it's blank),
// calculate it from the movie's runtime in the DB.
// =====================================================
if (empty($end_time)) {
    $movieStmt = $connection->prepare("SELECT runtime FROM movies WHERE movie_id = ?");
    $movieStmt->bind_param("i", $movie_id);
    $movieStmt->execute();
    $movieData = $movieStmt->get_result()->fetch_assoc();

    if (!$movieData) {
        echo "Error: Movie not found.";
        exit;
    }

    // Parse runtime "HH:MM:SS" and add to start_time
    list($h, $m, $s) = explode(':', $movieData['runtime']);
    $startDt = new DateTime($start_time);
    $startDt->add(new DateInterval("PT{$h}H{$m}M{$s}S"));
    $end_time = $startDt->format('Y-m-d H:i:s');
}

// Check for scheduling conflicts at same theater
$check = $connection->prepare("
    SELECT id FROM screenings 
    WHERE theater_name = ?
    AND NOT (end_time <= ? OR start_time >= ?)
");
$check->bind_param("sss", $theater_name, $start_time, $end_time);
$check->execute();
$conflict = $check->get_result();

if ($conflict->num_rows > 0) {
    echo "Conflict: Screening overlaps with an existing one at this theater.";
    exit;
}

// Insert the new screening
$stmt = $connection->prepare("
    INSERT INTO screenings (movie_id, theater_name, start_time, end_time, capacity) 
    VALUES (?, ?, ?, ?, ?)
");
$stmt->bind_param("isssi", $movie_id, $theater_name, $start_time, $end_time, $capacity);

if ($stmt->execute()) {
    echo "Screening added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$connection->close();
?>
