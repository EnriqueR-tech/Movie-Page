<?php
include "../config/connection.php";

// Get all movies for dropdown
$sql = "SELECT * FROM `movie details`";
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<?php include "../config/header.php" ;?>

<body>

    <!-- Header -->
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Get Movie Tickets 🎟️</h1>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active bg-danger" href="pages/GetTickets.php">Get Tickets</a>
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


    <!-- Form -->
    <div class="container mt-5">
        <div class="jumbotron">
            <h3>Book Your Tickets</h3>

            <form action="../includes/processTickets.php" method="POST">

                <!-- Movie dropdown -->
                <div class="form-group">
                    <label>Select Movie:</label>
                    <select name="movie_id" class="form-control" required>
                        <option value="">-- Choose Movie --</option>

                        <?php
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row['movie_id'] . "'>" . $row['Title'] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Name -->
                <div class="form-group">
                    <label>Your Name:</label>
                    <input type="text" name="customer_name" class="form-control" required>
                </div>

                <!-- Tickets -->
                <div class="form-group">
                    <label>Number of Tickets:</label>
                    <input type="number" name="tickets" class="form-control" min="1" required>
                </div>

                <!-- Date -->
                <div class="form-group">
                    <label>Select Date:</label>
                    <input type="date" name="show_date" class="form-control" required>
                </div>

                <!-- Time -->
                <div class="form-group">
                    <label>Select Time:</label>
                    <input type="time" name="show_time" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Confirm Booking</button>

            </form>
        </div>
    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark text-white text-center p-3 mt-3">
        <p>Team Popcorn Movie Site</p>
    </div>

</body>
</html>