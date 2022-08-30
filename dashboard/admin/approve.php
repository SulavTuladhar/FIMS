<?php
    require('../../helpers/auth_session.php');
    require('../../helpers/admin_route.php');
    require('../../helpers/db_config.php');

    $validUsername = $_SESSION['username'];
    $id = $_SESSION['id'];
    $query = "SELECT * FROM fims . users WHERE verified = 0";

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)>0){
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }else{
        $data = [];
    }

    // Approve
    if (isset($_GET['approve'])) {
		$id = $_GET['approve'];
		$udpateQuery = "UPDATE `fims` . `users` SET verified = 1 WHERE id=$id";
        $response = mysqli_query($conn, $udpateQuery);
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>=0){
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
            echo "<div class='toastMsg successMsg'> <div class='line'> </div> <p> Success <br> User verified successfully </p> </div>";

        }

	}

    // Delete
    if (isset($_GET['delete'])) {
		$id = $_GET['delete'];
		$deleteQuery = "DELETE FROM `fims` . `users` WHERE id = $id";
        $response = mysqli_query($conn, $deleteQuery);
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>=0){
            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../style/dashboard_style.css">
    <link rel="stylesheet" href="../../style/toast_style.css">
    <link rel="stylesheet" href="../../style/auth_style.css">
    <link rel="stylesheet" href="../../style/setting_style.css">
    <link rel="stylesheet" href="../../style/approve_style.css">
    <title> Approve </title>
</head>
<body>
    <main>
    <div class="side-bar">
            <h2 style="color: #fff; padding: 2rem;"> FIMS </h2>
            <div class="options">
                <div class="hover"  onclick="location.href='./home.php'">
                    <img src="../../images/home.svg" alt="home-img">
                </div>
                <div class="hover" onclick="location.href='./add.php'">
                    <img src="../../images/plus.svg" alt="plus-img">
                </div>
                <div class="selected"  onclick="location.href='./approve.php'">
                    <img src="../../images/profile.svg" alt="profile-img">
                </div>
                <div class="hover" onclick="location.href='./setting.php'">
                    <img src="../../images/settings.svg" alt="settings-img">
                </div>
            </div>
                <img src="../../images/logout.svg"  onclick="location.href='../../helpers/logout.php'" class="logout" >
        </div>

        <div class="main-container">
            <h1 class="heading-text"> Approve Page </h1>
            <table>
                <thead>
                    <tr>
                        <th> Name </th>
                        <th> Role </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if(empty($data)): ?>
                            <td> Users Not Found </td>
                        <?php endif; ?>
                    </tr>
            <?php foreach($data as $item): ?>
                        <tr>
                            <form action="" method="post">
                            <?php    
                            $name = $item['name'];
                            $role = $item['role'];
                            $id = $item['id'];
                            echo "
                            <td>
                                <input type='text' value='$name' name='names' disabled/>
                            </td>
                            <td>
                                <input type='text' value='$role' name='names' disabled/>
                            </td>
                            <td> 
                            <a href='approve.php?approve=$id'> 
                                <span>
                                    Approve 
                                </span>
                            </a>    
                            <a href='approve.php?delete=$id'> 
                                <span class='delete'>
                                    Delete 
                                </span>
                            </a>        
                            </td>
                            ";
                                ?>
                            </form>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>                
           
        </div>
        </div>
    </main>
</body>
</html>