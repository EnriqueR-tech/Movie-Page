<?php
/**
 * TEAM POPCORN - SPRINT 3
 * Feature: Filter Web Schedule by Theater Location
 * Description: Allows moviegoers to view showtimes specifically for Richardson or Dallas theaters.
 */

// 1. DATABASE CONNECTION: Pulls in your database credentials
include "config/connection.php";

/**
 * 2. DATA CAPTURE: 
 * We look for 'location' in the URL (sent by the <select> menu below).
 * If the user hasn't picked one yet, we default to 'all' so the page isn't blank.
 */
$selectedLocation = isset($_GET['location']) ? $_GET['location'] : 'all';

/**
 * 3. DYNAMIC SQL LOGIC:
 * If 'all' is selected, we want the full list.
 * If a specific city is selected, we add a "WHERE" clause to narrow it down.
 */
if ($selectedLocation == 'all') {
    // No filter applied - get everything
    $sql = "SELECT * FROM `movie details` ORDER BY Title ASC";
} else {
    /**
     * Filter applied - we only get rows where theater_location matches our variable.
     * Note: We use single quotes '$selectedLocation' because it is a text string.
     */
    $sql = "SELECT * FROM `movie details` WHERE theater_location = '$selectedLocation' ORDER BY Title ASC";
}

// 4. EXECUTION: Sends the query to MySQL
$result = $connection->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Filter by Location - Team Popcorn</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Search by Theater</h1>
    </div>

    <div class="container mt-5">
        <div class="jumbotron text-center">
            <form action="filter_schedule_by_location.php" method="GET" class="form-inline justify-content-center">
                <label class="mr-2 font-weight-bold">Select Theater:</label>
                
                <select name="location" class="form-control mr-2">
                    <option value="all">All Locations</option>
                    
                    <option value="Richardson" <?php if($selectedLocation == 'Richardson') echo 'selected'; ?>>Richardson North</option>
                    <option value="Dallas" <?php if($selectedLocation == 'Dallas') echo 'selected'; ?>>Dallas Downtown</option>
                </select>
                
                <button type="submit" class="btn btn-primary">Filter Location</button>
            </form>
        </div>

        <h2>Movies at: <?php echo ($selectedLocation == 'all') ? "All Theaters" : $selectedLocation; ?></h2>
        <hr>

        <?php 
        /**
         * 5. DISPLAY RESULTS:
         * We check if the query returned any rows.
         */
        if ($result->num_rows > 0): 
            // 6. WHILE LOOP: Creates a Bootstrap card for every movie found
            while($row = $result->fetch_assoc()): 
        ?>
                <div class="card mb-3 shadow-sm">
                    <div class="row no-gutters">
                        <div class="col-md-2 p-2">
                            <img src="assets/images/<?php echo $row['image']; ?>" class="img-fluid" alt="Poster">
                        </div>
                        <div class="col-md-10">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?php echo $row['Title']; ?></h5>
                                <p><strong>Location:</strong> <?php echo $row['theater_location']; ?></p>
                                <p><?php echo $row['Description']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        <?php 
            endwhile; 
        else: 
            // 7. EMPTY STATE: If the database is empty or no movies match the location
        ?>
            <p class='alert alert-warning'>No movies currently found for this theater location.</p>
        <?php endif; ?>
    </div>
</body>
</html>
