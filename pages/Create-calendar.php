<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

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
                <a class="nav-link text-white" href="../index.php">Home</a>
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
                    <a class="dropdown-item active bg-danger" href="Create-calendar.php">Schedule Screening</a>

                </div>
            </li>
        </ul>
    </nav>

    <!-- Create a movie schedule -->
    <div class="container-xl mt-5">
        <div class=" row">
            <div class="col border p-4 ">    
                <div id="calendar"></div>
            </div>

            <div class="col-md-4 jumbotron border p-4">
                <h3 class="text-center"> Add a Movie to Schedule</h3>

                <button class="btn btn-primary btn-block mb-3" data-toggle="collapse" data-target="#addmovie" role="button">Add Movie Schedule</button>
                
                <div class="collapse " id="addmovie" >
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
                    
                    <div class="input-group mt-3">
                        <input type="date" class="form-control" id="movieDate" placeholder="Select Date">

                    </div>
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" id="movieStart" placeholder="Start Time (e.g. 14:00)">
                    </div>
                    <div class="input-group mt-3">
                        <input type="text" class="form-control" id="movieEnd" placeholder="End Time (e.g. 16:00)">
                    </div>
                    <button class="btn btn-success btn-block mt-3" onclick="addEvent()">Add to Schedule</button>
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
            events:  '../includes/get-screening.php' ,
        });
        calendar.render();
    });
    function addEvent() {
        var movieId = document.getElementById('movieSelect').value;
        var movieDate = document.getElementById('movieDate').value;
        var movieStart = document.getElementById('movieStart').value;
        var movieEnd = document.getElementById('movieEnd').value;

        if (movieId === "Choose Movie..." || !movieDate || !movieStart || !movieEnd) {
            alert("Please fill in all fields.");
            return;
        }
        var start_datetime = movieDate + "T" + movieStart + ":00";
        var end_datetime = movieDate + "T" + movieEnd + ":00";
        $.ajax({
            url: '../includes/save-screening.php',
            type: 'POST',
            data: {
                movie_id: movieId,
                movie_date: movieDate,
                start_time: start_datetime,
                end_time: end_datetime
            },
            success: function(response) {
                alert(response);
                if (response.includes("successfully")) {
                    calendar.addEvent({
                        title: 'Movie Screening: ' + $('#movieSelect option:selected').text(),
                        start: start_datetime,
                        end: end_datetime
                    });
                }
            },
            error: function() {
                alert('Error saving screening.');
            }
        });
    }
</script>

</body> 
</html>
