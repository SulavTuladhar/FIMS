<?php
// If user access the admin route then this will redirect user to his/her dashboard
    if($_SESSION['role'] == 'user'){
        header("Location: ../../dashboard/user/home.php");
        exit();
    }
?>