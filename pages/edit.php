<?
$title = "";
$runtime = "";
$rating = "";
$description = "";

if ( $_SERVER['REQUEST_METHOD'] == 'POST'){
    $title = $_POST["title"];
    $runtime = $_POST["runtime"];
    $rating = $_POST["rating"];
    $description = $_POST["description"];

    $errorMessage = "";
    $successMessage = "";

    do{
        if (empty($title) || empty($runtime) || empty($rating) || empty($description)){
            $errorMessage = "All the Fields are Required";
            break;
        }
        $title = "";
        $runtime = "";
        $rating = "";
        $description = "";
        $successMessage = 'Client Added Correctly';

    }while (false);
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
        <form method="post">
            <label>Title</label>
            <input name="title" value=" <?php echo $title; ?>">
        
            <label>Runtime</label>
            <input name="runtime" value="<?php echo $runtime; ?>">

            <label>Rating</label>
            <input name="rating" value="<?php echo $rating; ?>">

            <label>Description</label>
            <input name="description" value="<?php echo $description; ?>">



            <?php
            if (!empty($successMessage)){
                echo "Data is success";
            }
            ?>
            <button type="submit" href="">Send</button>
            <a href="index.php" role="button">Cancel</a>
        </form>
    </div>
</body>