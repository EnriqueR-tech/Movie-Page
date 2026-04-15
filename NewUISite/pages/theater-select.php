<?php
session_start();
include "../config/theaters.php";

// Capture movie_id from the URL if it exists
$mid = $_GET['movie_id'] ?? "";

if (isset($_POST['theater'])) {
    $key = $_POST['theater'];
    $_SESSION['theater_key'] = $key;
    
    // FIX: Only save the NAME string to avoid the "Array to string" warning
    $_SESSION['theater'] = $theaters[$key]['name']; 

    // Redirect back with the movie_id if we have it
    $target = "tickets-purchase.php";
    if (!empty($_POST['movie_id'])) {
        $target .= "?movie_id=" . urlencode($_POST['movie_id']);
    }
    
    header("Location: $target");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../config/header.php"; ?>
    <title>Select Theater</title>
</head>
<body>
    <div class="container mt-4">
        <div class="movie-card p-4">
            <h3 class="mb-3">🎬 Find a Theatre</h3>

            <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by city, zip or theatre">

            <form method="POST" id="theaterForm">
                <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($mid); ?>">

                <div id="theaterList">
                    <?php foreach ($theaters as $key => $t) { ?>
                        <button type="submit"
                            name="theater"
                            value="<?php echo $key; ?>"
                            class="theater-card w-100 mb-2"
                            style="text-align: left; padding: 15px; border: 1px solid #333; background: #1a1a1a; color: white; border-radius: 8px;"
                            data-search="<?php echo strtolower($t['name'] . ' ' . $t['city'] . ' ' . $t['zip']); ?>">
                            🎬 <?php echo $t['name']; ?> <br>
                            <small style="color: #888;"><?php echo $t['city']; ?>, <?php echo $t['zip']; ?></small>
                        </button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <script>
        const input = document.getElementById("searchInput");
        const cards = document.querySelectorAll(".theater-card");
        input.addEventListener("keyup", function() {
            const value = this.value.toLowerCase();
            cards.forEach(card => {
                const search = card.dataset.search;
                card.style.display = search.includes(value) ? "block" : "none";
            });
        });
    </script>
</body>
</html>?