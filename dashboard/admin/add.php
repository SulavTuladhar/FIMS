<?php
    require('../../helpers/auth_session.php');
    require('../../helpers/admin_route.php');
    require('../../helpers/db_config.php');

    if(isset($_POST['submit'])){ 
        // print_r($_POST);
        $dishName = $_POST['nameOfDish'];
        $ingredient = $_POST['ingredient'];
        $quantity = $_POST['quantity'];

        /* Inserting the dish name into the database. */
        if(empty($dishName)){
            echo "<div class='toastMsg errorMsg'> <div class='line'> </div> <p> Error <br> Dish Name is required. </p> </div>";
        }else{
            $query = "INSERT into `fims` . `dish` (name) VALUE ('$dishName')";
            $res = mysqli_query($conn,$query);
            if($res){
               /* Fetching the dish name from the database. */
                $fetchQuery = "SELECT * FROM fims . dish WHERE name = '$dishName'";
                $result = mysqli_query($conn, $fetchQuery);
                if(mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_array($result);
                    $D_Id = $row['D_Id'];
                    /* Inserting the ingredients and quantity into the database. */
                    foreach (array_combine($ingredient, $quantity) as $ingredient => $quantity) {
                        $ingredientQuery = "INSERT into `fims` . `ingredients` (name, quantity, D_Id) VALUE ('$ingredient', '$quantity', '$D_Id')";
                        $res = mysqli_query($conn,$ingredientQuery);
                    }
                }
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
    <link rel="stylesheet" href="../../style/add_style.css">
    <title> Add Ingredients </title>
</head>
<body>
    <main>
        <div class="side-bar">
            <h2 style="color: #fff; padding: 2rem;"> FIMS </h2>
            <div class="options">
                <div class="hover"  onclick="location.href='./home.php'">
                    <img src="../../images/home.svg" alt="home-img">
                </div>
                <div class="selected">
                    <img src="../../images/plus.svg" alt="plus-img">
                </div>
                <div class="hover"  onclick="location.href='./approve.php'">
                    <img src="../../images/profile.svg" alt="profile-img">
                </div>
                <div class="hover" onclick="location.href='./setting.php'">
                    <img src="../../images/settings.svg" alt="settings-img">
                </div>
            </div>
                <img src="../../images/logout.svg"  onclick="location.href='../../helpers/logout.php'" class="logout" >
        </div>

        <div class="main-container">
            <form action="" method="post">
                <input type="text" placeholder="Name Of Dish" name="nameOfDish" >
                <div class="ingredients-container">
                    <div class="ingredients">
                        <input type="text" placeholder="Name of Ingredient" name="ingredient[]">
                        <input type="number" placeholder="quantity" name="quantity[]">
                    </div>
                    <div class="ingredients">
                        <input type="text" placeholder="Name of Ingredient" name="ingredient[]">
                        <input type="number" placeholder="quantity" name="quantity[]">
                    </div>
                </div>
                <button class="add-ingredients" id="add-btn"> + </button>
                <input type="submit" name="submit" class="button" value="Submit" />
            </form>
        </div>
    </main>

    <script>
        const container = document.getElementsByClassName('ingredients-container')[0];
        const button = document.getElementsByClassName('add-ingredients')[0];
        
        button.addEventListener('click', (e)=> {
            e.preventDefault();
            let ingDiv = document.createElement('div');
            let formName = document.createElement('input');
            let formQuantity = document.createElement('input');
            formName.placeholder = "Name of Ingredients";
            formName.name = "ingredient[]";
            formQuantity.placeholder = "Quantity";
            formQuantity.name = "quantity[]";

            ingDiv.setAttribute('class', 'ingredients')
            ingDiv.appendChild(formName)
            ingDiv.appendChild(formQuantity)
            container.appendChild(ingDiv)
        })
    </script>
</body>
</html>