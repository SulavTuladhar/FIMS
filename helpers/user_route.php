<?php
// If admin access the user route then this will redirect admin to his/her dashboard
    if($_SESSION['role'] == 'admin'){
        header("Location: ../../dashboard/admin/home.php");
        exit();
    }
?>