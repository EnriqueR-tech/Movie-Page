<?php
    //To send datta from HTML/php page to MySQL database, we need to use $_POST method to get the data from the form and then use SQL query to insert the data into the database.

    //print_r($_POST);
    //recieve input from HTML/php page
    $title = $_POST["title"];
    $rating = $_POST["rating"];
    $runtime = $_POST["runtime"];
    $description = $_POST["description"];
    
    //Test to see what data type it sends to MySQL for debugging purpose
    var_dump($title, $rating, $runtime, $description);

    //connect to database
    $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "movielist";

    //create connection and test connection first
    $connection = new mysqli($servername, $username, $password, $dbname);
    if (!$connection) {
        die("Connection Failed: " . mysqli_connect_error());
    }
    
    //Finally Insert data to movie details TABLE
    //preparing anti-SQL injection attack with '?'
    $sql = "INSERT INTO `movie details` ( `Title`, `Runtime`, `Rating`, `Description`)
        VALUES (?,?,?,?)";
    
    $stmt = mysqli_stmt_init($connection);
    if( ! mysqli_stmt_prepare($stmt, $sql)){
         die(mysqli_error($connection));
    }
    
    //binding variables
    //4 strings from 
    mysqli_stmt_bind_param($stmt, "ssds", $title, $rating, $runtime, $description);
    mysqli_stmt_execute($stmt);
    
    echo "record have been saved";

?>