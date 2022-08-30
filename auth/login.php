<?php
    require('./../helpers/db_config.php');
    session_start();

    // Checking id user is already logged in to the system
    if(isset($_SESSION['username'])){
        if($_SESSION['role'] == 'user'){
            header("Location: ../dashboard/user/home.php");
            exit();
        }
        else if($_SESSION['role'] == 'admin'){
                header("Location: ../dashboard/admin/home.php");
                exit();
        }
    }

    // Loggin in  
    if(isset($_REQUEST['username'])){
    
       $username = $_REQUEST['username'];
       $password = $_REQUEST['password'];

        /* Checking if the username and password is empty. If it is empty, it will display an error message. */
       if(empty($username)){
        echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> username is required </p> </div>";
       }
       else if(empty($password)){
        echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> password is required </p> </div>";
       }

      /* This is the code that is responsible for checking if the user is already registered in the
      database. If the user is already registered, it will redirect the user to the dashboard. If
      the user is not registered, it will display an error message. */
       else{
        $query = " SELECT * FROM fims . users WHERE username = '$username'";

        $result = mysqli_query($conn, $query);

        
        if(mysqli_num_rows($result) > 0){
            
            $row = mysqli_fetch_array($result);
            $hashed_password = $row['password'];
            if(password_verify($password, $hashed_password)){
                if($row['verified'] == 1){
                    if($row['role'] == 'admin'){
                       $_SESSION['username'] = $row['username'];
                       $_SESSION['role'] = $row['role'];
                       $_SESSION['id'] = $row['id'];
                       header('location: ../dashboard/admin/home.php');       
                    }
                    elseif($row['role'] == 'user'){
                       $_SESSION['username'] = $row['username'];
                       $_SESSION['role'] = $row['role'];
                       $_SESSION['id'] = $row['id'];
                       header('location: ../dashboard/user/home.php');
                    }
                    }else{
                     echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Wait <br> User is not verified yet. </p> </div>";
                    }
            }else{
                echo "eror password";
            }
        }else{
           echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> Incorrect username or password </p> </div>";
        }
       }
    };

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="../style/auth_style.css">
    <link rel="stylesheet" href="../style/toast_style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> FIMS </title>
    <style>
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <main>
        <nav>
            <header>
                <h1>FIMS</h1>
                <p> Don't have an account? <a style="text-decoration: none; color: blue;" href="../auth/register.php"> Create Account </a> </p>
            </header>
        </nav>


        <div class="container">
            <h1> Welcome Back </h1>
            <form action="" method="post">
                <label for="username"> Username </label>
                <input type="text" name="username" id="username" />
                <p id="usernameErrorLabel" class="error">  </p>
                <label for="password"> Password </label>
                <input type="password" name="password" id="password" />
                <p id="passwordErrorLabel" class="error">  </p>

                <span class="checkbox">
                    <input type="checkbox" name="remember_me" id="remember_me" />
                    <label for="remember_me">Remember me</label>
                </span>
                <button type="submit" name="submit" id="submit"> Login </button>
            </form>
        </div>
    </main>
    <!-- <script>
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('password');
        const btn = document.getElementById('submit');
        const usernameLabel = document.getElementById('usernameErrorLabel')
        const passwordLabel = document.getElementById('passwordErrorLabel')
        let usernameError;
        let passwordError;
        btn.addEventListener('click', (e)=> {
            // e.preventDefault()
            console.log('username >> ', usernameInput.value);
            if(usernameInput.value == ''){
                usernameError = "required field*"
            }else{
                usernameError = ''
            }
            if(passwordInput.value == ''){
                passwordError = "required field*"
            }else{
                passwordError = ''
            }
            if(usernameError != ''){
                usernameLabel.innerHTML = usernameError
            }
            if(passwordError != ''){
                passwordLabel.innerHTML = passwordError
            }

            if(usernameError && passwordError){
                return false
            }
        })

        usernameInput.addEventListener('input', ()=>{
            usernameError = ''
            usernameLabel.innerHTML = ''
        })

        passwordInput.addEventListener('input', ()=>{
            passwordError = ''
            passwordLabel.innerHTML = ''
        })

</script> -->
</body>
</html>