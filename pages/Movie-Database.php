<!DOCTYPE html>
<html lang="en">


<?php include "../config/header.php" ;?>

<!-- Fetch tickets from ticket table -->

<body>
    <!-- Title -->
    <div>
        <h1 >Team Popcorn Movie</h1>
        <h2>Authorized user: Edit Movie Data CRUD</h2>
    </div>

    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">

            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Home</a>
            </li>
            <li class="nav-item"><a class="nav-link text-white" href="movie-cards.php">Movies</a></li>
            <li class="nav-item">
                <a class="nav-link text-white" href="tickets-purchase.php">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="aboutus.php">About Us</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link text-white dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Authorized Access
                </a>
                <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item active bg-danger" href="Movie-Database.php">Add Movie</a>
                    <a class="dropdown-item " href="schedule-create.php">Schedule Screening</a>

                </div>
            </li>

        </ul>
    </nav>

    <!-- To Do:
     1. Condense Database table with 3 action buttons for each movie: Edit, Delete, Make it unavailable for purchase 
        -1a. The action buttons when clicked should have a modal pop up to show the details of the movie, edit the movie details, delete the movie, and upload an image for the movie
        -1b. Include ticket sales for each movie and make it unavaliable for purchase if there are tickets sold for that movie
        -1c. On the action buttons, it should redirect to a new page that shows the details of the movie and have the option to edit the details, delete the movie, and upload an image for the movie
     2. Implement a search feature to find movies by title that also include 4 action buttons
     3. Add a prevention of movie deletion if there are tickets sold for that movie
        3a. Instead messing with the DB, make it unavaliable for purchase and add a note that says "This movie is no longer available for purchase"
        3b. Create a seperate table for authorized view that shows "Current avaliable movies and unavailable movies -->

    

    <!-- Page layout -->
    <div>
        <div class="container-xl mt-4 p-4 bg-white ">
            <table class="table table-bordered table-hover> ">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Runtime (HH:MM)</th>
                        <th>Total Tickets Sold</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //connect to database
                    include "../config/connection.php";

                    //read all row from database -> movie details table
                    $sql = "SELECT m.*, COALESCE(SUM(t.tickets), 0) as total_tickets_sold
                     FROM movies m
                     LEFT JOIN tickets t ON m.movie_id = t.movie_id
                     GROUP BY m.movie_id";
                    $result = $connection->query($sql);

                    //Read data of each row -> contains 5 rows
                    while($row = $result->fetch_assoc()){

                        $ticketCount = (int)$row["total_tickets_sold"];
                        $badgeClass = $ticketCount > 0 ? "badge-success" : "badge-secondary";

                        $id = $row["movie_id"];
                        $title = $row["title"];
                        $runtime = $row["runtime"];
                        $rating = $row["rating"];
                        $description = $row["description"];
                        $image = $row["image"];

                        echo "<tr>
                            <td>" . $row["movie_id"] ."</td>
                            <td class='font-weight-bold'>" . $row["title"] ."</td>
                            <td class='text-center'>" . $row["runtime"] ."</td>
                            <td class='text-center'>
                                <span class='badge p-2 {$badgeClass}'>" . $row["total_tickets_sold"] . "</span>
                            </td>
                            <td>
                            <a href='../handlers/movies-view.php?id=" . $row["movie_id"] . "' 
                            class='btn btn-dark mb-2'
                            data-toggle='modal' data-target='#movieModal'
                              data-movie-id='{$id}'
                              data-title='{$title}'
                              data-runtime='{$runtime}'
                              data-rating='{$rating}'
                              data-description='{$description}'
                              data-image='{$image}'>Details</a>
                            <a href='../handlers/movies-edit.php?id=" . $row["movie_id"] . "' class='btn mb-2' style='background-color: #2265e2; color: white;'>Edit</a>
                            <a href='../handlers/movies-delete.php?id=" . $row["movie_id"] . "' onclick='return confirm(\"Delete this movie?\")' class='btn btn-danger mb-2'>Delete</a>
                            <a href='../handlers/movies-uploadimage.php?id=" . $row["movie_id"] . "' class='btn btn-link'>Upload Image</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container jumbotron bg-dark text-white mt-4">
        <p> Enter the movie you want to add:</p>
        <form class="form-group " action="../handlers/movies-save.php" method="post">
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" required >
            
            <label for="rating">Rating</label>
            <input type ="text" id="number" name="rating" min="0.0" step="0.1" max="10.0" required ></input>

            <label for="runtime">Runtime: </label>
            <input type="time" id="runtime" name="runtime" step="1" required>

            <label for="description">Description: </label>
            <input type="text"id="desc" name="description" required >

           <button class="btn btn-success" type="submit">Send</button>
        </form>

    </div>        
<div class="container-fluid  bg-dark text-white text-center p-3 mt-3 ">
    <footer>
    <p>Copyright &copy; 2024 Team Popcorn Movie</p>
    <br>
    <p> Designed by Team Popcorn: Enrique, Jesus, Hans, Nyab</p>
    </footer>
</div>


<div class="modal fade" id="movieModal" tabindex="-1" aria-labelledby="movieModalCardLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content  mx-auto">

                <div class="modal-header bg-dark text-white">
                    <button type="button" class="close bg-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" >&times;</span>
                    </button>
                </div>

                <div class="modal-body bg-dark text-white">
                    <section class="movie-hero">
                            <div class="hero-content">

                                <div class="hero-poster">
                                    <img src="" id="moviePoster" alt="Movie Poster" class="img-fluid rounded">
                                </div>

                                <div class="hero-info">
                                    <h1 id="movieModalCardLabel"></h1>

                                    <div class="d-flex justify-content-start mb-3 ">
                                        <h4 class="mb-3 mr-4">
                                            <span class="badge badge-success p-2" id="movieRuntime"> </span>
                                        </h4>
                                        <h4 class="mb-3">
                                            <span class="badge badge-info p-2" id="movieRating"></span>
                                        </h4>
                                    </div>

                                    <p class="desc" id="movieOverview"></p>

                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

 <!-- Modal Cards button JS -->
 <script src="../assets/js/movie-databaseModal.js"></script>

</body>
</html>
