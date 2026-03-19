<?php

include "connection.php";

if (isset($_GET["id"])){
    $id = $_GET["id"];
    $sql = "SELECT * FROM `movie details` WHERE movie_id=$id";
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
    $id = $_POST["movie_id"];
    $title = $_POST["title"];
    $runtime = $_POST["runtime"];
    $rating = $_POST["rating"];
    $description = $_POST["description"];

    $sql = "UPDATE `movie details` SET Title='$title', Runtime='$runtime', Rating='$rating', Description='$description' WHERE movie_id=$id";
    if ($connection->query($sql) === TRUE) {
        $successMessage = "Data updated successfully";
    } else {
        $errorMessage = "Error updating data: " . $connection->error;
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
    <!-- <script src="Moviedata_table.js" defer></script> -->
</head>
<body>
    <div>
        <h2> Edit Movie Data </h2>
        <form action="edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label>Title</label>
            <input type="text" name="title" value=" <?php echo $row['Title']; ?>">
        
            <label>Runtime</label>
            <input type="text" name="runtime" value=" <?php echo $row['Runtime']; ?>">

            <label>Rating</label>
            <input type="text" name="rating" value=" <?php echo $row['Rating']; ?>">

            <label>Description</label>
            <input type="text" name="description" value=" <?php echo $row['Description']; ?>">

            <?php
            if (!empty($successMessage)){
                echo "Data is success";
            }
            ?>
            <button type="submit" href="">Update</button>
            <a href="../index.php" role="button">Cancel</a>
        </form>
    </div>
</body>