<?php
    include "database.php";
    if (isset($_GET["id"])){
        $id = $_GET["id"];
        $sql = "DELETE FROM `movie details` WHERE movie_id=$id";
        if ($connection->query($sql) === TRUE) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    }

?>