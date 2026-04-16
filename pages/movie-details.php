<?php
session_start();
include "../config/connection.php";

$movie_id = $_GET['movie_id'] ?? null;
if (!$movie_id) {
    echo "Movie not found.";
    exit;
}

$stmt = $connection->prepare("SELECT * FROM movies WHERE movie_id = ?");
$stmt->bind_param("i", $movie_id);
$stmt->execute();
$result = $stmt->get_result();
$movie = $result->fetch_assoc();

if (!$movie) {
    echo "Movie not found.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../config/header.php"; ?>
    <link rel="stylesheet" href="../config/style.css">
    <title><?php echo htmlspecialchars($movie['title']); ?></title>
</head>
<body>

<div class="movie-hero-hero">
    <video class="hero-trailer" autoplay muted loop playsinline>
        <source src="../assets/videos/<?php echo htmlspecialchars($movie['trailer']); ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="poster-container container">
            <img class="w-50" src="../assets/images/<?php echo htmlspecialchars($movie['image']); ?>" alt="<?php echo htmlspecialchars($movie['title']); ?>">
        </div>
        <div class="movie-details">
            <h1> <?php echo htmlspecialchars($movie['title']); ?> </h1>
            <p class="text-muted"><?php
                $t = explode(":", $movie['runtime']);
                echo intval($t[0]) . " HR " . intval($t[1]) . " MIN | " . $movie['rating'];
            ?></p>
            <p><?php echo nl2br(htmlspecialchars($movie['description'])); ?></p>
            <a href="tickets-purchase.php?movie_id=<?php echo $movie['movie_id']; ?>" class="btn btn-danger btn-lg">Get Tickets</a>
        </div>
    </div>
</div>

</body>
</html>