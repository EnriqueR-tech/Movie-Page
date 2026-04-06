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

    <!-- FullCalendar -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@calendarjs/ce/dist/style.min.css" />
<script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@calendarjs/ce/dist/index.min.js"></script>
    
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
            <div class="col border p-4" id="root">
                <div> <h1>Selected Date:</h1> <h3 id="display"></h3></div>
            </div>

            <div class="col-md-4">
                <h3 class="text-center"> Add a Movie to Schedule</h3>

                <button class="btn btn-primary btn-block mb-3" data-toggle="collapse" data-target="#addmovie" role="button">Add Movie Schedule</button>
                
                <div class="collapse" id="addmovie">
                    <select class="custom-select" id="movieSelect">
                        <option selected>Choose Movie...</option>
                        <option value="1">Movie 1</option>
                        <option value="2">Movie 2</option>
                        <option value="3">Movie 3</option>
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
    
    <div class="container-fluid  bg-dark text-white text-center p-3 mt-3 ">
        <footer>
        <p>Copyright &copy; 2024 Team Popcorn Movie</p>
        <br>
        <p> Designed by Team Popcorn: Enrique, Jesus, Hans, Nyab</p>
        </footer>
    </div>
</body> 

</html>
<script>
const { Schedule } = calendarjs;

const schedule = Schedule(document.getElementById('root'), {
    type: 'week',
    weekly: true,
    validRange: ['8:00', '24:00'],
    data: [
        { guid: '1', title: 'Morning Meeting', weekday: 1, start: '08:00', end: '09:00', color: '#3498db' },
        { guid: '2', title: 'Lunch Break', weekday: 1, start: '12:00', end: '13:00', color: '#95a5a6' },
        { guid: '3', title: 'Project Work', weekday: 2, start: '09:00', end: '12:00', color: '#2ecc71' }
    ],
});
function addEvent() {
    const movieSelect = document.getElementById('movieSelect');
    const movieDate = document.getElementById('movieDate');
    const movieStart = document.getElementById('movieStart');
    const movieEnd = document.getElementById('movieEnd');   

     schedule.addEvents({
        guid: crypto.randomUUID(),
        title: movieSelect.options[movieSelect.selectedIndex].text,

        start: movieStart.value,
        end: movieEnd.value,
        color: '#39e47b'
    });
}

</script>