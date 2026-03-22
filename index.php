<?php
include "config/connection.php";
$sql = "SELECT * FROM `movie details` where movie_id=6";
//execute the query and get the result
$result = $connection->query($sql);
while($row = $result->fetch_assoc()){
    $title = $row["Title"];
    $runtime = $row["Runtime"];
    $rating = $row["Rating"];  
    $description = $row["Description"];
    $image = $row["image"];
}
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
    <!-- Title -->
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <!-- Links -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link  active bg-danger" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/database.php">Add Movie (Authorized Users Only)</a>
            </li>
        </ul>
    </nav>

    <!-- Page layout -->
    <div class="container-xl mt-5">
        <div class="row ">
            <div class="col jumbotron">
                <h2>Welcome to Team Popcorn Movie Site!</h2>
                <p>Find our selection of Movies currently shown on the right!</p>
                <a href="pages/currentmovie.php" class="btn btn-outline-primary">Explore More Movies</a>
            </div>

            <div class="col jumbotron">
                <h2>Featured Movies</h2>
                <div class="card">  
                    <img class="card-img-top" src="assets/images/<?php echo $image; ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $title; ?></h5>
                        <p class="card-text"><?php echo "Runtime: " . $runtime; ?></p>
                        <p class="card-text"><?php echo "Rating: " . $rating; ?></p>
                        <p class="card-text"><?php echo "Description: " . $description; ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>

<div class="container-fluid  bg-dark text-white text-center p-3 mt-3 ">
    <footer>
    <p>Copyright &copy; 2024 Team Popcorn Movie</p>
    <br>
    <p> Designed by Team Popcorn: Enrique, Jesus, Hans, Nyab</p>
    </footer>
</div>
</body>


</html>
