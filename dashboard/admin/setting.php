<?php
    require('../../helpers/auth_session.php');
    require('../../helpers/admin_route.php');
    require('../../helpers/db_config.php');

    $validUsername = $_SESSION['username'];
    $id = $_SESSION['id'];
    $query = "SELECT * FROM fims . users WHERE username = '$validUsername' && id = '$id'";

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_array($result);
        $username = $row['username'];
        $email = $row['email'];
        $name = $row['name'];
        $password = $row['password'];
    }

    if(isset($_REQUEST['username'])){
        $newUsername = $_REQUEST['username'];
        $newName = $_REQUEST['name'];
        $newEmail = $_REQUEST['email'];
        $oldPassword = $_REQUEST['oldPassword'];
        $newPassword = $_REQUEST['newPassword'];

        if(empty($newPassword)){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> New password can't be empty </p> </div>";
        }
        else if(strlen($newPassword) < 8){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> New password must be 8 character long </p> </div>";
        }else{
            if(password_verify($oldPassword, $password)){
                $hashed_password = password_hash($newPassword, PASSWORD_DEFAULT);
                $query = "UPDATE fims . users SET username = '$newUsername', email = '$newEmail', name = '$newName', password = '$hashed_password' WHERE id = '$id'";
                $res = mysqli_query($conn, $query);
                if($res){
                    $_SESSION['username'] = $newUsername;
                    header("Location: ./setting.php");
                }
            }else{
                echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> Old password doesn't match </p> </div>";
            }
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
    <title> Settings </title>
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
                <div class="hover"  onclick="location.href='./approve.php'">
                    <img src="../../images/profile.svg" alt="profile-img">
                </div>
                <div class="selected" onclick="location.href='./setting.php'">
                    <img src="../../images/settings.svg" alt="settings-img">
                </div>
            </div>
                <img src="../../images/logout.svg"  onclick="location.href='../../helpers/logout.php'" class="logout" >
        </div>

        <div class="main-container">
            <h1> Edit Account Details </h1>
            <form action="" method="post">
                <?php
                    echo "
                    <label for='name'> Name </label>
                    <input type='text' name='name' id='name' value='$name'/>
                    <label for='username'> Username </label>
                    <input type='text' name='username' id='username' value='$username' />
                    <label for='email'> Email </label>
                    <input type='email' name='email' id='email' value='$email' />
                    <label for='password'> Old Password </label>
                    <input type='password' name='oldPassword' id='password' />
                    <label for='newPassword'> New Password </label>
                    <input type='password' name='newPassword' id='newPassword' />
                    "
                ?>
               
                <button type="submit" name="submit" id="submit"> Edit </button>
            </form>
        </div>
    </main>
</body>
</html>