<?php
/**
 * TEAM POPCORN - SPRINT 3
 * Feature: Filter Web Schedule by Date
 * Description: Connects to the database and retrieves movies based on a user-selected date.
 */

// 1. DATABASE CONNECTION: Brings in the $connection variable from your config file
include "config/connection.php";

/**
 * 2. DATA CAPTURE: 
 * isset($_GET['date']) checks if the user has actually clicked 'Filter' and sent a date.
 * If true, we use that date. If false (first time visiting), we use date('Y-m-d') for today.
 */
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

/**
 * 3. THE SQL QUERY:
 * CAST(show_date AS DATE) is the "Secret Sauce." It converts a full timestamp 
 * (like 2026-04-15 14:30:00) into just a simple date (2026-04-15).
 * This ensures the database can accurately match the user's simple date input.
 * ORDER BY Title ASC keeps the list alphabetical for the moviegoer.
 */
$sql = "SELECT * FROM `movie details` 
        WHERE CAST(show_date AS DATE) = '$selectedDate' 
        ORDER BY Title ASC";

// 4. EXECUTION: Runs the query against your MySQL database
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter by Date - Team Popcorn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Search by Date</h1>
    </div>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <form action="filter_schedule_by_date.php" method="GET" class="form-inline justify-content-center">
                <label class="mr-2 font-weight-bold">Select Date:</label>
                <input type="date" name="date" class="form-control mr-2" value="<?php echo $selectedDate; ?>">
                <button type="submit" class="btn btn-danger">Filter Date</button>
            </form>
        </div>

        <h2>Showtimes for <?php echo $selectedDate; ?></h2>
        <hr>

        <?php 
        /**
         * 5. LOGIC CHECK: 
         * num_rows > 0 checks if the database actually found any movies for that date.
         */
        if ($result->num_rows > 0): 
            // 6. LOOP: Repeats this HTML block for every movie found in the results
            while($row = $result->fetch_assoc()): 
        ?>
                <div class="card mb-3 shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-2 p-2">
                            <img src="assets/images/<?php echo $row['image']; ?>" class="img-fluid" alt="Poster">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title text-danger"><?php echo $row['Title']; ?></h5>
                                <p><?php echo $row['Description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php 
            endwhile; 
        else: 
            /**
             * 7. FALLBACK: 
             * If the database is empty for that day, we show this warning instead of a blank screen.
             * This satisfies the 'Stakeholder Verification' requirement.
             */
        ?>
            <p class='alert alert-warning'>No movies scheduled for this date. Please try another day!</p>
        <?php endif; ?>
    </div>
</body>
</html>
