<?php
// includes/searchMovies.php
include "../config/connection.php";

$q = $_GET['q'] ?? '';
$q = trim($q);
$q = $connection->real_escape_string($q);

if ($q === '') {
    // Nothing to search
    exit;
}

// Fetch top 5 matching movies
$sql = "SELECT movie_id, title, image FROM movies WHERE title LIKE '%$q%' ORDER BY title ASC LIMIT 5";
$result = $connection->query($sql);

if ($result->num_rows == 0) {
    echo "<div class='text-white p-2'>No movies found</div>";
    exit;
}

// Output mini preview links
while ($row = $result->fetch_assoc()) { 
?>
    <a href="../pages/currentMovieDetails.php?movie_id=<?php echo $row['movie_id']; ?>" 
       class="search-preview d-flex align-items-center text-decoration-none text-white mb-2" 
       style="gap:10px; padding:5px; border-radius:4px; transition:background 0.2s;">
        <img src="../assets/images/<?php echo htmlspecialchars($row['image']); ?>" 
             alt="<?php echo htmlspecialchars($row['title']); ?>" 
             style="width:50px; height:75px; object-fit:cover; border-radius:3px;">
        <span><?php echo htmlspecialchars($row['title']); ?></span>
    </a>
<?php
}
?>