 <?php
    require('./../helpers/db_config.php');
    require('./../helpers/form_validation.php');

    if (isset($_REQUEST['username'])){

        /* Getting the values from the form and storing them in variables. */
        $name = $_REQUEST['name'];
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $confirmPassword = $_REQUEST['confirm-password'];
        $email = $_REQUEST['email'];
        $role = $_REQUEST['role'];

       /* This is fetching all the users with the role of admin. */
        $fetchData = "SELECT * FROM fims . users WHERE role = 'admin'";
        $response = mysqli_query($conn, $fetchData);
        if(mysqli_num_rows($response) > 0){
            $data = mysqli_fetch_all($response, MYSQLI_ASSOC);
        }else{
            $data = [];
        }

        $validUsername = checkUsername($username);
        $validName = checkName($name);
        $validPassword = checkPassword($password);

        if($validUsername !== true ){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> $validUsername </p> </div>";
        }else if($validName !== true){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> $validName </p> </div>";
        }else if($validPassword !== true){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> $validPassword </p> </div>";
        }else if($confirmPassword != $password){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> Password & confirm Password doesn't match. </p> </div>";
        }else{
            $name = mysqli_real_escape_string($conn, $name);
            // $password = mysqli_real_escape_string($conn, $password);
            $email = mysqli_real_escape_string($conn, $email);
            
            // Password hashed
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            foreach($data as $item){
                $VerifiedAdmin = $item['verified'];
            }
            

            /* Checking if the user is an admin or not. */
            if($role == 'admin' && $VerifiedAdmin == 1){
                $query = "INSERT into `fims` . `users` (name, username , email, password, role, verified ) VALUE ('$name', '$username', '$email', '$hashed_password', '$role', 0)";
            }else if($VerifiedAdmin !== 1){
                $query = "INSERT into `fims` . `users` (name, username , email, password, role, verified ) VALUE ('$name', '$username', '$email', '$hashed_password', '$role', 1)";
            }else{
            $query = "INSERT into `fims` . `users` (name, username , email, password, role ) VALUE ('$name', '$username', '$email', '$hashed_password', '$role')";
            }
                
                /* This is checking if the query was successful or not. If the query was successful, then the user is redirected to the login page. If the query was not successful, then the user is shown
                an error message. */
            $res = mysqli_query($conn, $query);
            if($res){
                header('location: ./login.php');
            }else{
                echo 'error';
        }
        }
        // Closing the database connection
        $conn->close();
    }
?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../style/auth_style.css">
    <link rel="stylesheet" href="../style/toast_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FIMS </title>
</head>
<body>
    <main>
        <nav>
            <header>
                <h1>FIMS</h1>
                <p> Have an account? <a href="./login.php" style="text-decoration: none; color: blue;"> Login </a> </p>
            </header>
        </nav>


        <div class="container">
            <h1> Register </h1>
            <form action="" method="post">
                <label for="name"> Name </label>
                <input type="text" name="name" id="name" />

                <label for="username"> Username </label>
                <input type="text" name="username" id="username" />


                <label for="email"> Email </label>
                <input type="email" name="email" id="email" />

                <label for="number"> Phone number </label>
                <input type="number" name="number" id="number" />

                <label for="password"> Password </label>
                <input type="password" name="password" id="password" />

                <label for="confirm-password"> Confim password </label>
                <input type="password" name="confirm-password" id="confirm-password" />

                <label for="role"> Role </label>
                <select name="role" class="select">
                    <option value="admin" class="option"> admin </option>
                    <option value="user"> user </option>
                </select>

                <span class="checkbox">
                    <input type="checkbox" name="terms&conditions" id="terms&conditions" />
                    <label for="terms&conditions"> I agree to all the <span class="text-blue"> Terms, Privacy Policy </span> and <span class="text-blue"> Fees </span></label>
                </span>
                <button type="submit" name="submit"> Create Account </button>
            </form>
        </div>
    </main>
</body>
</html> 