<!DOCTYPE html>
<html lang="en">

<?php include "../config/header.php" ;?>

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

    <!-- Page layout -->
    <div>
        <div class="container-xl mt-4 p-4 bg-white ">
            <table class="table table-bordered table-hover> ">
                <thead class="thead-dark">
                    <th>ID</th>
                    <th>Title</th>
                    <th>Runtime (HH:MM)</th>
                    <th>Rating</th>
                    <th>Description</th>
                </thead>
                <tbody>
                    <?php
                    //connect to database
                    include "../config/connection.php";

                    //read all row from database -> movie details table
                    $sql = "SELECT * FROM `movies`";
                    $result = $connection->query($sql);

                    //Read data of each row -> contains 5 rows
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>" . $row["movie_id"] ."</td>
                            <td>" . $row["title"] ."</td>
                            <td>" . $row["runtime"] ."</td>
                            <td>" . $row["rating"] ."</td>
                            <td>" . $row["description"] ."</td>
                            <td>
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
</body>
</html>
