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
<?php include "config/header.php"; ?>
<head>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
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
                <a class="nav-link active bg-danger" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/GetTickets.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="pages/About-us.php">About Us</a>
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
 <div class="container text-center mt-5 jumbotron">
    <h2 class="text-center mb-4">Welcome to Team Popcorn Movie Site From Dallas College!</h2>
    <p>Find our selection of Movies currently shown Down here!</p>
    <a href="pages/Current-Movielist.php" class="btn btn-outline-primary btn-lg">Explore More Movies</a>
 </div>
<div class="container-xl mt-5">
    <div class="row ">
        <div class="col jumbotron">
            <h2 class="text-center mb-4">Current Movie Showtime Calendar!</h2>
            <div class="bg-white h-75 p-4" id="calendar"></div>
        </div>

        <div class="col jumbotron">
            <h2 class="text-center mb-4">Featured Movies</h2>
            <div class="card">  
                <img class="card-img-top p-3" src="assets/images/<?php echo $image; ?>" alt="Card image cap">
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

<script>
    var calendar;
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'listWeek',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek,dayGridMonth'
            },
            events:  'includes/get-screening.php' ,

            dateClick: function(info) {
                if (calendar.view.type === 'dayGridMonth') {
                    calendar.changeView('listDay', info.dateStr);
                } else {
                    calendar.changeView('listWeek');
                }
            }
        });
        calendar.render();
    });
    
</script>
</body>


</html>

