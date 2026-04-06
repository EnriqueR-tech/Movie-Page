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
                    <a class="dropdown-item active bg-danger" href="Movie-Database.php">Add Movie</a>
                    <a class="dropdown-item " href="Create-calendar.php">Schedule Screening</a>

                </div>
            </li>

        </ul>
    </nav>

    <!-- Page layout -->
    <div>
        <div class="container-xl">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Runtime (HH:MM)</th>
                    <th>Rating</th>
                    <th>Description</th>
                </tr>
                <tbody>
                    <?php
                    
                    //connect to database
                    include "../config/connection.php";

                    //read all row from database -> movie details table
                    $sql = "SELECT * FROM `movie details`";
                    $result = $connection->query($sql);

                    //Read data of each row -> contains 5 rows
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>" . $row["movie_id"] ."</td>
                            <td>" . $row["Title"] ."</td>
                            <td>" . $row["Runtime"] ."</td>
                            <td>" . $row["Rating"] ."</td>
                            <td>" . $row["Description"] ."</td>
                            <td>
                            <a href='../includes/edit-TableData.php?id=" . $row["movie_id"] . "' class='btn btn-primary'>Edit</a>
                            <a href='../includes/delete-TableData.php?id=" . $row["movie_id"] . "' onclick='return confirm(\"Delete this movie?\")' class='btn btn-danger'>Delete</a>
                            <a href='../includes/upload-TableImage.php?id=" . $row["movie_id"] . "' class='btn btn-link'>Upload Image</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container jumbotron" >
        <p> Enter the movie you want to add:</p>
        <form action="../includes/process-form.php" method="post">
            <label for="title">Title: </label>
            <input type="text" id="title" name="title" required >
            
            <label for="rating">Rating</label>
            <input type ="text" id="number" name="rating" min="0.0" step="0.1" max="10.0" required ></input>

            <label for="runtime">Runtime: </label>
            <input type="time" id="runtime" name="runtime" step="1" required>

            <label for="description">Description: </label>
            <input type="text"id="desc" name="description" required >

           <button type="submit">Send</button>
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
