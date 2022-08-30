<?php
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $db_name = "fims";

    $conn = mysqli_connect($hostName,  $userName, $password);

    // Checking connection
    if (!$conn)
    {
        die("connection failed " . mysqli_connect_error());
    }
?>
