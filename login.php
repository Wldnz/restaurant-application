<?php
    session_start();
    require_once "config/db.php";
    require_once "utils/helper.php";
    $information_username = "";
    $information_password = "";

    if(isset($_SESSION["isLogin"]) && $_SESSION["isLogin"]){
        redirectTo();
    };
    $url = rootLocation();
    function validateForm($username,$password){
        if(empty($username) && empty($password)){ 
            $information_username = "username harus di isi";
            $information_password = "password harus di isi";
            return false;
        }elseif (empty($username)){
            $information_username = "username harus di isi";
            return false;
        }elseif (empty($password)){
            $information_password = "password harus di isi";
            return false;
        }
        return true;
    }


    if(isset($_POST["login_dong"])){
        $username = $conn->real_escape_string($_POST['username']);;
        $password = $conn->real_escape_string($_POST['password']);;

       if(validateForm($username,$password)){
            // kosongkan value ini!
            $information_username="";
            $information_password="";

            // sha256
            $hash_pw = hash("sha256",$password);
            $sql = "SELECT * FROM pengguna where nama = '$username' and password='$hash_pw'";
            $result = $conn->query($sql)->fetch_assoc();
            if(!$result){
                echo '<script>alert("password / username is incorrect!")</script>';
            }else{
                if($username == $result['nama'] and $hash_pw == $result['password'] ){
                    
                    $_SESSION["name"] = $result["nama"];
                    $_SESSION["role"] = $result['role'];
                    $_SESSION["isLogin"] = true;
                    echo $result["role"];
                    $conn->close();
                    redirectTo();
                }
            }
           
        }
    }else if(isset($_POST['backDong'])){
        header("Location: $url");
    }

    function redirectTo(){
        if(isCashier()) 
        return goToCashierPage(); 
        else 
        return goToAdminPage();
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wildan Restaurant</title>
    <link rel="stylesheet" href="./style/style.css">
</head>
<body>

   <div class="container">
    <h2>Login Sekarang</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" class="login" method="post">
            <div class="fieldInput">
                <label for="username">Username : </label>
                <input type="text" name="username" id="username" placeholder="Username">
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="password">Password : </label>
                <input type="password" name="password" id="password" placeholder="password">
                <p><?= $information_password ?></p>
            </div>
            <button type="submit" name="login_dong">Login</button>
            <button type="submit" name="backDong">Back</button>
        </form>
   </div>


</body>
</html>