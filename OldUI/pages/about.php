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
    <div>
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/GetTickets.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white active bg-danger" href="#">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="Movie-Database.php">Add Movie</a>
                    <a class="dropdown-item" href="Create-calendar.php">Schedule Screening</a>

                </div>
            </li>
        </ul>
    </nav>
<div class="container jumbotron">
    <select class="custom-select" id="movieSelect">
        <option selected>Choose Movie...</option>
        <?php
            include "../config/connection.php";
            $sql = "SELECT movie_id, Title FROM `movie details`";
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["movie_id"] . "'>" . $row["Title"] . "</option>";
                }
            } else {
                echo "<option disabled>No movies found</option>";
            }
            $connection->close();
        ?>
    </select>
</div>

 

            <p>Find our selection of Movies currently shown on the right!</p>
            <a href="pages/Current-Movielist.php" class="btn btn-outline-primary">Explore More Movies</a>

</body>
</html>
