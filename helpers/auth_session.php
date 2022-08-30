<?php
    /* Checking if the user is logged in. If not, it redirects them to the login page. */
    session_start();
    if(!isset($_SESSION['username'])){
        header("Location: ../../auth/login.php");
        exit();
    }

?>