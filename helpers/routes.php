<?php
    if(!$_SESSION['username']){
        header("Location: ../auth/login.php");
        exit();
    }else{
        exit();
    }
?>