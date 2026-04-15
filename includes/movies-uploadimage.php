<?php
//connect to database
include "../config/connection.php";

//get the id from url
$id = $_GET["id"];

//select the movie details table and get the row with the matching ID
$sql = "SELECT * FROM `movie details` WHERE movie_id=$id";  
$result = $connection->query($sql);

if (!$result){
    die("Invalid query: " . $connection->error);
}
else {
    $row = $result->fetch_assoc();
    $title = $row["Title"];
    $runtime = $row["Runtime"];
    $rating = $row["Rating"];  
    $description = $row["Description"];
    $image = $row["image"];

}
echo "<h1>Upload Image for Movie ID: " . $id . "</h1>";
echo "<p>Title: " . $title . "</p>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
</head>
<body>
<div class="container jumbotron">
    <p> Enter the image you want to upload:</p>

    <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <input type="file" name="image" id="image" required>
    <button type="submit" class="btn btn-primary" name="upload">Upload Image</button>
    </form>
</div>

//display image
<?php
if (isset($_POST["upload"])){
    $id = $_POST["id"];
    $image = $_FILES["image"]["name"];
    $target = "../assets/images/" . basename($image);

    //move the uploaded file to the target directory
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)){
        echo "<p>Image uploaded successfully</p>";
    }
    else {
        echo "<p>Failed to upload image</p>";
    }

    //update the database with the image name
    $sql = "UPDATE `movie details`
            SET image='$image'
            WHERE movie_id=$id";
    
    if ($connection->query($sql) === TRUE){
        echo "<p>Image name updated in database</p>";
    }
    else {
        echo "<p>Error updating database: " . $connection->error . "</p>";
    }
}
?>
</body>

