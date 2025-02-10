<?php

   define("APP_TITLE","Wildan Resto");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_TITLE ?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="./style/style.css">
</head>
<style>

    .container{
        margin-top: 0;
       
    }

    .container > :nth-child(1){
        margin-top: 40px;
        text-align: center;
    }

    .container > :nth-child(2){
        width: 60%;
        min-width: 300px;
        text-align: center;
    }

    .wrapper{
        width: 100%;
        height: 200px;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        gap: 10px;

        /* background-color: red; */
    }

    .item{
        border-radius: 3px;
        max-width: 200px;
        height: 200px;
        display: flex;
        flex-direction: column;
    }

    .item:hover{
        background-color: blue !important;
    }

    a{
        text-decoration: none;
    }

    a:hover{
        color:white;
    }

    footer{
        margin-top: 20px;
        width: 100%;
        /* text-align: end; */
        padding: 0 10px;
       
    }


</style>
<body>
    
    <div class="container">
        <h2>Selamat Datang Di Wildan Restaurant!</h2>
        <p>Wildan Resto adalah Kafe yang dimulai oleh dua sepupu asal Indonesia pada tahun 2024. Berbasis di tempat yang paling banyak dikunjungi di Tangerang Selatan,Wildan Resto n menyajikan beragam Makanan, Dessert, dan Minuman Fresh berkualitas tinggi dalam suasana santai dan enjoy.</p>
        <div class="wrapper">
            <!-- <div class="item">
                <h3>High-Quality Dishes</h3>
                <p>Wildan Resto menyajikan makanan dan minuman berkualitas tinggi, dibuat dengan bahan-bahan segar untuk memberikan pengalaman kuliner terbaik.</p>
            </div>
            <div class="item">
                <h3>Relaxed Atmosphere</h3>
                <p>Nikmati suasana santai dan nyaman di Wildan Resto, tempat yang sempurna untuk bersantai bersama teman dan keluarga.</p>
            </div>
            <div class="item">
                <h3>Heart of Tangerang Selatan</h3>
                <p>Terletak di lokasi strategis, Wildan Resto menjadi destinasi favorit untuk mencicipi berbagai dessert dan minuman segar.</p>
            </div> -->
            <div class="login"><a  href="products.php">Lihat Makanan</a></div>
            <div class="login"><a  href="check-pesanan">Check Pesanan</a></div>
            
        </div>
    </div>


    <footer class="">
        <a href="login.php">Admin..</a>
    </footer>

    <script>
        
    </script>

</body>
</html>