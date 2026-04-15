<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Title -->
    <div>
        <h1 >Team Popcorn Movie</h1>
        <h2>Authorized user: Edit Movie Data CRUD</h2>
    </div>

    <!-- Links -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark justify-content-center"> 
        <ul class="nav  nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link text-white" href="../index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">Get Tickets</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="#">About Us</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white disabled active bg-danger" href="pages/database.php">Add Movie (Authorized Users Only)</a>
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
                            <a href='../includes/edit.php?id=" . $row["movie_id"] . "' class='btn btn-primary'>Edit</a>
                            <a href='../includes/delete.php?id=" . $row["movie_id"] . "' onclick='return confirm(\"Delete this movie?\")' class='btn btn-danger'>Delete</a>
                            <a href='../includes/uploadimage.php?id=" . $row["movie_id"] . "' class='btn btn-link'>Upload Image</a>
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
        <form action="process-form.php" method="post">
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
