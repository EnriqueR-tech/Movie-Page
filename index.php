<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Popcorn Movie</title>
    <link rel="stylesheet" href="style.css">
    <!-- <script src="Moviedata_table.js" defer></script> -->
</head>
<body>
    <!-- Title -->
    <div class="title">
        <h1 id="title-text">Team Popcorn Movie</h1>
        <h2 id="title-text">Authorized user: Edit Movie Data CRUD</h2>
    </div>

    <!-- Links -->
    <div class="links">
        <a href="#">Home</a>
        <a href="#">Get Tickets</a>
        <a href="#">About Us</a>
        <a href="#">Menu/Food/Drinks</a>
    </div>

    <!-- Page layout -->
    <div class="page">
        <div>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Runtime (HH:MM)</th>
                    <th>Rating</th>
                    <th>Description</th>
                </tr>
                <tbody id="insert">
                    <?php
                    //connect to database
                    include "connection.php";

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
                            <a href='pages/edit.php?id=" . $row["movie_id"] . "'>Edit</a>
                            <a href='pages/delete.php?id=" . $row["movie_id"] . "' onclick='return confirm(\"Delete this movie?\")'>Delete</a>
                            </td>
                        </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div>
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

        <?php
            echo "hello world from team popcorn";
        ?>
    </div>        
</body>
</html>
