<?php
    require('../../helpers/auth_session.php');
    require('../../helpers/admin_route.php');
    require('../../helpers/db_config.php');

    // Fetching all data from dish table
    $query = "SELECT * FROM fims . dish";
    $res = mysqli_query($conn,$query);

    if(mysqli_num_rows($res) > 0){
        $data = mysqli_fetch_all($res, MYSQLI_ASSOC);
    }else{
        $data = [];
    }

    if(isset($_GET['search'])) {
        if($res){
            $searchId = $_GET['search'];
            $searchQuery = "SELECT * FROM fims . ingredients WHERE D_Id = $searchId";
            $response = mysqli_query($conn, $searchQuery);
            if(mysqli_num_rows($response) > 0){
                $ingredients = mysqli_fetch_all($response, MYSQLI_ASSOC);
            }else{
                $ingredients = [];
            }
        }
    }
    
    // Ingredient 
    if(isset($_POST['submit'])){ 

        /* Fetching the data from the form. */
        $name = $_POST['name'];
        $constName = $_POST['name'];
        $quantity = $_POST['quantity'];
        $constQuantity = $_POST['quantity'];
        $ingredientsArray = array();
        $quantityArray = array();
        $usedQuantity = array();
        $leftOver = array();
        $noOfDish;
        for($i = 0; $i < count($ingredients); $i++){
                // Phase 1: Finding minimum dish that can be cooked
                foreach($ingredients as $item){
                $Ing = $item['quantity'];
                array_push($ingredientsArray, $Ing);
                }
                $quantity[$i] = $quantity[$i] / $ingredientsArray[$i];
                array_push($quantityArray, $quantity[$i]);
                $min = min($quantityArray);
                
                if($quantityArray[$i] == $min){
                    $noOfDish = $quantityArray[$i];
                }
        }
        // Phase 2: Find leftover quantity of ingredients
        // finding out used quantity
        for($i = 0; $i < count($ingredients); $i++){
            $used = $ingredientsArray[$i] * $noOfDish;
            array_push($usedQuantity, $used);
        }

        // finding leftover
        for($i = 0; $i < count($ingredients); $i++){
            $leftoverIngredient = $constQuantity[$i] - $usedQuantity[$i];
            array_push($leftOver, $leftoverIngredient);
            // print_r($name);
            // echo "<br>";
            // echo $name[$i];
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
    <title> Home </title>
</head>
<body>
    <main>
        <div class="side-bar">
            <h2 style="color: #fff; padding: 2rem;"> FIMS </h2>
            <div class="options">
                <div class="selected">
                    <img src="../../images/home.svg" alt="home-img">
                </div>
                <div class="hover"  onclick="location.href='./add.php'">
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
            <?php
                echo "<h1 class='heading-text'> Welcome Back,<span style='color: #2D14C6'> ". $_SESSION['username'] . "</span> </h1>";
            ?>
            <div class="content">
                <form class="data_form" action="" method="post">
                    <input type="text" placeholder="Search" name="seach"/>
                    <!-- <input type="button" value="submit"> -->
                    <button class="search-btn"> <img src="../../images/search.svg" alt="search-icon" /> </button>
                </form>
                <div class="data">
                <table>
                <tbody>
                    <tr>
                        <?php if(empty($data)): ?>
                            <td> Users Not Found </td>
                        <?php endif; ?>
                    </tr>
                        <?php foreach($data as $item): ?>
                        <tr>
                            <?php    
                            $name = $item['name']; 
                            $id = $item['D_Id'];
                            echo "
                            <td>
                            <a href='./home.php?search=$id'> 
                                $name
                                </a>
                            </td>
                            ";
                                ?>
                        </tr>
                    </tbody>
                    <?php endforeach; ?>
                </table>                
                </div>
                 
            </div>
        </div>
        <?php if(!empty($ingredients)) : ?>
            <div class="ing">
                <h1 class="ingredient-header"> Feed Quantity </h1>
                <button class="close-btn" onclick="location.href='./home.php'">X</button>
                <form class="ingredient_form" action="" method="post">
                <?php foreach($ingredients as $item): ?>
                        <?php    
                            $name = $item['name']; 
                            $quantity = $item['quantity'];
                            echo "
                                <label for='$name'> $name </label>
                                <input type='text' id='$name' name='name[]' value='$name' readonly/>       
                                <input type='text' id='$name' placeholder='$quantity' name='quantity[]'/>       
                                ";
                                ?>
                <?php endforeach; ?>
                    <?php
                        if(!empty($leftOver)){
                            echo "Total No Of Dish  = " . $noOfDish . "<br>";
                            echo "<br>";
                            echo "<h4> Leftover </h4>";
                            for($i = 0; $i < count($ingredients); $i++){
                                echo "<br>";
                                echo $constName[$i] . " = " . $leftOver[$i];
                                echo "<br>";
                            }
                            echo "<br>";
                        }
                    ?>
                <input type='submit' name='submit' class='button' value='Submit' />
            </form>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>