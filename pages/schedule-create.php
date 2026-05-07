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
    <div class="container-fluid bg-dark text-white text-center pt-5 pb-5">
        <h1>Team Popcorn Movie Site</h1>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Home</a>
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="movie-cards.php">Movies</a></li>
            <li class="nav-item">
                <a class="nav-link text-white" href="tickets-purchase.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="aboutUs.php">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="movie-database.php">Add Movie</a>
                    <a class="dropdown-item active bg-danger" href="schedule-create.php">Schedule Screening</a>
                </div>
            </li>
        </ul>
    </nav>

    <div class="container-xl mt-5">
        <div class="row">
            <div class="col border p-4">    
                <div id="calendar"></div>
            </div>

            <div class="col-md-4 jumbotron border p-4">
                <h3 class="text-center">Add a Movie to Schedule</h3>

                <button class="btn btn-primary btn-block mb-3" data-toggle="collapse" data-target="#addmovie" role="button">Add Movie Schedule</button>
                
                <div class="collapse" id="addmovie">

                    <!-- Movie Select -->
                    <label for="movieSelect">Movie</label>
                    <select class="custom-select mb-2" id="movieSelect">
                        <option value="">Choose Movie...</option>
                        <?php
                            include "../config/connection.php";
                            // =====================================================
                            // Load movie runtimes alongside titles
                            // so JS can calculate end_time automatically
                            // =====================================================
                            $sql = "SELECT movie_id, title, runtime FROM `movies`";
                            $result = $connection->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row["movie_id"] . "' 
                                          data-runtime='" . $row["runtime"] . "'>" 
                                          . $row["title"] . "</option>";
                                }
                            } else {
                                echo "<option disabled>No movies found</option>";
                            }
                            $connection->close();
                        ?>
                    </select>

                    <!-- Theater Select -->
                    <label for="addTheater">Theater</label>
                    <select class="custom-select mb-2" id="addTheater" name="theater_name">
                        <option value="">Choose Theater...</option>
                        <?php 
                            include "../config/theaters.php";
                            foreach ($theaters as $key => $theater) {
                                echo "<option value='" . $theater['name'] . "'>" . $theater['name'] . "</option>";
                            }
                        ?>
                    </select>

                    <!-- Date -->
                    <div class="input-group mt-3">
                        <input type="date" class="form-control" id="movieDate" placeholder="Select Date">
                    </div>

                    <!-- Start Time -->
                    <div class="input-group mt-3">
                        <input type="time" class="form-control" id="movieStart" placeholder="Start Time">
                    </div>

                    <!-- End Time — auto-calculated, but editable (Backlog #1440) -->
                    <div class="input-group mt-3">
                        <input type="time" class="form-control" id="movieEnd" placeholder="End Time (auto-calculated)">
                    </div>
                    <small class="text-muted">⏱ End time is calculated automatically from the movie runtime. You can override it if needed.</small>

                    <!-- Capacity -->
                    <div class="input-group mt-3">
                        <input type="number" class="form-control" id="movieCapacity" placeholder="Capacity (default: 100)" min="1" value="100">
                    </div>

                    <button class="btn btn-success btn-block mt-3" onclick="addEvent()">Add to Schedule</button>
                </div>
            </div>
        </div>        
    </div>
    
    <div class="container-fluid bg-dark text-white text-center p-3 mt-3">
        <footer>
            <p>Copyright &copy; 2024 Team Popcorn Movie</p>
            <p>Designed by Team Popcorn: Enrique, Jesus, Hans, Nayab</p>
        </footer>
    </div>

    <script>
        // =====================================================
        // Auto-calculate end_time from runtime
        // end_time = start_time + movie runtime
        // Manager can still override end_time manually
        // =====================================================

        var calendar;

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'listWeek',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listWeek,dayGridMonth'
                },
                events: '../handlers/screening-fetch.php',
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

        // Trigger recalculation when movie OR start time changes
        document.getElementById('movieSelect').addEventListener('change', calcularEndTime);
        document.getElementById('movieStart').addEventListener('change', calcularEndTime);
        document.getElementById('movieDate').addEventListener('change', calcularEndTime);

        function calcularEndTime() {
            var movieSelect = document.getElementById('movieSelect');
            var selectedOption = movieSelect.options[movieSelect.selectedIndex];
            var runtime = selectedOption.getAttribute('data-runtime'); // "HH:MM:SS"
            var startVal = document.getElementById('movieStart').value; // "HH:MM"
            var dateVal  = document.getElementById('movieDate').value;  // "YYYY-MM-DD"

            // Only calculate if we have all 3 values
            if (!runtime || !startVal || !dateVal) return;

            // Parse runtime "HH:MM:SS"
            var parts = runtime.split(':');
            var runtimeHours   = parseInt(parts[0], 10);
            var runtimeMinutes = parseInt(parts[1], 10);
            var runtimeSeconds = parseInt(parts[2] || 0, 10);

            // Build a Date object from date + start time
            var startDt = new Date(dateVal + 'T' + startVal + ':00');

            // Add runtime
            startDt.setHours(startDt.getHours()   + runtimeHours);
            startDt.setMinutes(startDt.getMinutes() + runtimeMinutes);
            startDt.setSeconds(startDt.getSeconds() + runtimeSeconds);

            // Format back to HH:MM for the input[type=time]
            var endHH = String(startDt.getHours()).padStart(2, '0');
            var endMM = String(startDt.getMinutes()).padStart(2, '0');

            // Set value — manager can still change it manually
            document.getElementById('movieEnd').value = endHH + ':' + endMM;
        }

        function addEvent() {
            var movieId    = document.getElementById('movieSelect').value;
            var movieDate  = document.getElementById('movieDate').value;
            var movieStart = document.getElementById('movieStart').value;
            var movieEnd   = document.getElementById('movieEnd').value;
            var theaterId  = document.getElementById('addTheater').value;
            var capacity   = document.getElementById('movieCapacity').value || 100;

            if (!movieId || !movieDate || !movieStart || !movieEnd || !theaterId) {
                alert("Please fill in all fields.");
                return;
            }

            var start_datetime = movieDate + "T" + movieStart + ":00";
            var end_datetime   = movieDate + "T" + movieEnd   + ":00";

            $.ajax({
                url: '../handlers/screening-save.php',
                type: 'POST',
                data: {
                    movie_id:     movieId,
                    theater_name: theaterId,
                    movie_date:   movieDate,
                    start_time:   start_datetime,
                    end_time:     end_datetime,
                    capacity:     capacity
                },
                success: function(response) {
                    alert(response);
                    if (response.includes("successfully")) {
                        var movieTitle = $('#movieSelect option:selected').text();
                        calendar.addEvent({
                            title: 'At: ' + theaterId + ' - ' + movieTitle,
                            start: start_datetime,
                            end:   end_datetime,
                            color: '#e50914'
                        });
                        // Reset form
                        document.getElementById('movieSelect').selectedIndex = 0;
                        document.getElementById('movieDate').value  = '';
                        document.getElementById('movieStart').value = '';
                        document.getElementById('movieEnd').value   = '';
                        document.getElementById('movieCapacity').value = 100;
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
