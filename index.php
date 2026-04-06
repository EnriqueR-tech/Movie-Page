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

<?php include "config/header.php" ;?>

<body>
    <!-- Title -->
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <!-- Links -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active bg-danger" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/GetTickets.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="pages/Movie-Database.php">Add Movie</a>
                    <a class="dropdown-item" href="pages/Create-calendar.php">Schedule Screening</a>

                </div>
            </li>
        </ul>
    </nav>



<!-- Page layout -->
<div class="container-xl mt-5">
    <div class="row ">
        <div class="col jumbotron">
            <h2>Welcome to Team Popcorn Movie Site!</h2>
            <p>Find our selection of Movies currently shown on the right!</p>
            <a href="pages/Current-Movielist.php" class="btn btn-outline-primary">Explore More Movies</a>
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

