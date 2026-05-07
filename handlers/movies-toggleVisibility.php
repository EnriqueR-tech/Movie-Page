<?php
/**
 * movies-toggle-visibility.php
 * Hides or restores a movie from customer view and scheduling.
 * Does NOT delete any data — uses is_hidden flag on the movies table.
 *
 * Usage:
 *   Hide:    movies-toggle-visibility.php?id=5&action=hide
 *   Restore: movies-toggle-visibility.php?id=5&action=show
 */

include "../config/connection.php";

// Validate inputs
if (!isset($_GET["id"], $_GET["action"])) {
    header("Location: ../pages/Movie-Database.php");
    exit();
}

$id     = (int)$_GET["id"];
$action = $_GET["action"];

if ($action === "hide") {
    $isHidden = 1;
    $msg      = "hidden";
} elseif ($action === "show") {
    $isHidden = 0;
    $msg      = "restored";
} else {
    // Unknown action — bail out safely
    header("Location: ../pages/Movie-Database.php");
    exit();
}

$stmt = $connection->prepare(
    "UPDATE movies SET is_hidden = ? WHERE movie_id = ?"
);
$stmt->bind_param("ii", $isHidden, $id);

if ($stmt->execute()) {
    header("Location: ../pages/Movie-Database.php?msg={$msg}");
} else {
    echo "Error updating movie visibility: " . $connection->error;
}

$stmt->close();
