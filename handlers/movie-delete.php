<?php
    include "../pages/Movie-Database.php";
    if (isset($_GET["id"])){
        $id = $_GET["id"];
        $sql = "DELETE FROM `movies` WHERE movie_id=$id";
        if ($connection->query($sql) === TRUE) {
            
            exit();
        } else {
            echo "Error deleting record: " . $connection->error;
        }
    }

?>