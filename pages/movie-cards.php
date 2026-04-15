<?php
?>

<!DOCTYPE html>
<html lang="en">
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
        <h2>Current Movies List</h2>
    </div>

    <!-- Links -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active bg-danger" href="../index.php">Home</a>
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
                    <a class="dropdown-item" href="Movie-Database.php">Add Movie</a>
                    <a class="dropdown-item" href="Create-calendar.php">Schedule Screening</a>

                </div>
            </li>
        </ul>
    </nav>

<div class="container">
    <div class="row mt-5">

        <?php
        include "../config/connection.php";

        $sql = "SELECT * FROM `movies`";
        $result = $connection->query($sql);

        while($row = $result->fetch_assoc()){
            echo "
            <div class='col-md-6 col-lg-4 mb-4'>
                <div class='card h-100'>
                    <img class='card-img-top p-2 rounded' src='../assets/images/" . $row["image"] . "' alt='Movie Image'>
                    
                    <div class='card-body'>
                        <h5 class='card-title bg-danger text-white text-center p-2 font-weight-bold'> " . $row["title"] . "</h5>
                        <h6 class='bg-success text-white p-2'>Runtime: " . $row["runtime"] . "</h6>
                        <h6 class='bg-info text-white p-2'>Rating: " . $row["rating"] . "</h6>
                        <p class='card-text bg-secondary text-white p-4 '>" . $row["description"] . "</p>
                    </div>
                </div>
            </div>";
        }
        ?>

    </div>

</div>

</body>

</html>