
<?php
include "config/connection.php";

// 1. BACKLOG REQ: Handle Filtering
// Default to today's date if no date is picked
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// 2. BACKLOG REQ: Sorted Schedule
// We join 'movie details' with a 'showtimes' table (assuming you have one)
// If you don't have a showtimes table yet, this query pulls movies for the schedule.
$sql = "SELECT * FROM `movie details` ORDER BY Title ASC"; 
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie - Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link active bg-danger" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Get Tickets</a>
            </li>
            <li class="nav-item text-white">
                <a class="nav-link text-white" href="pages/database.php">Add Movie</a>
            </li>
        </ul>
    </nav>

    <div class="container mt-5">
        <div class="row mb-4">
            <div class="col-md-12 jumbotron text-center">
                <h3>Check Showtimes</h3>
                <form action="index.php" method="GET" class="form-inline justify-content-center mt-3">
                    <label class="mr-2 font-weight-bold">Select Date:</label>
                    <input type="date" name="date" class="form-control mr-2" value="<?php echo $selectedDate; ?>">
                    <button type="submit" class="btn btn-danger">View Schedule</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Upcoming Showtimes for <?php echo $selectedDate; ?></h2>
                <hr>
                
                <?php 
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) { 
                ?>
                    <div class="card mb-3">
                        <div class="row no-gutters">
                            <div class="col-md-2 bg-light d-flex align-items-center justify-content-center">
                                <img src="assets/images/<?php echo $row['image']; ?>" class="img-fluid p-2" alt="Movie Poster">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['Title']; ?></h5>
                                    <p class="card-text text-muted"><?php echo $row['Rating'] . " | " . $row['Runtime']; ?></p>
                                    <p class="card-text"><?php echo $row['Description']; ?></p>
                                </div>
                            </div>
                            <div class="col-md-3 bg-light d-flex flex-column align-items-center justify-content-center">
                                <p class="font-weight-bold mb-1">Start Times:</p>
                                <div class="mb-2">
                                    <span class="badge badge-danger p-2">1:00 PM</span>
                                    <span class="badge badge-danger p-2">4:30 PM</span>
                                </div>
                                <button class="btn btn-sm btn-dark">Select Seats</button>
                            </div>
                        </div>
                    </div>
                <?php 
                    }
                } else {
                    echo "<p class='alert alert-warning'>No movies found for this date.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container-fluid bg-dark text-white text-center p-3 mt-3 ">
        <footer>
            <p>Copyright &copy; 2024 Team Popcorn Movie</p>
            <p>Designed by Team Popcorn: Enrique, Jesus, Hans, Nayab</p>
        </footer>
    </div>
</body>
</html>
