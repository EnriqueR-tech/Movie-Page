<?php

include "../config/connection.php";

//Grabbing the table ID from the URL and matching it with the database to get the data of the specific row
if (isset($_GET["id"])){
    $id = $_GET["id"];

    //select the movie details table and get the row with the matching ID
    $sql = "SELECT * FROM movies WHERE movie_id=$id";
    $result = $connection->query($sql);
    if (!$result){
        die("Invalid query: " . $connection->error);
    }
    else {
        $row = $result->fetch_assoc();
        print_r($row);
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST["id"];
    $title = $_POST["title"];
    $runtime = $_POST["runtime"];
    $rating = $_POST["rating"];
    $description = $_POST["description"];

    $stmt = $connection->prepare("UPDATE `movies` SET `title` = ?, `runtime` = ?, `rating` = ?, `description` = ? WHERE `movie_id` = ?");
    $stmt->bind_param("ssssi", $title, $runtime, $rating, $description, $id);
    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        $errorMessage = "Error updating data: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div>
        <h2> Edit Movie Data </h2>
        <form action="movies-edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label>Title</label>
            <input type="text" name="title" value="<?php echo $row['title']; ?>">
        
            <label>Runtime</label>
            <input type="time" name="runtime" step="1" value="<?php echo $row['runtime']; ?>">

            <label>Rating</label>
            <input type="text" name="rating" value="<?php echo $row['rating']; ?>">

            <label>Description</label>
            <input type="text" name="description" value=" <?php echo $row['description']; ?>">

            <?php
            if (!empty($successMessage)){
                echo "Data is success";
            }
            ?>
            <button type="submit" href="../pages/movie-database.php">Update</button>
            <a href="../pages/movie-database.php" role="button">Cancel</a>
        </form>
    </div>
</body>