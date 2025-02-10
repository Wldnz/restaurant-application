<?php
    session_start();
    require_once "../utils/helper.php";
    if(!isAdmin()) return goToLoginPage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php require_once "../layout/navbar.php"; ?>
   <div class="container">
        <h2>Selamat Datang, <?= $_SESSION["name"] ?></h2>
   </div>
</body>
</html>