<?php
session_start();
require_once "./utils/helper.php";
require_once "./config/db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Produk</title>
    <link rel="stylesheet" href="./style/style.css">
</head>

<body>


    <?php require_once "./layout/navbar_2.php";  ?>

    <form action="<?php $_SERVER["PHP_SELF"] ?> " class="searchBar" style="padding:10px;">
        <input type="text" placeholder="Cari Produk..." name="produk">
        <button type="submit">SEARCH</button>
    </form>

    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="get" class="filter-makanan" style="padding:10px;">
        <select name="kategori" id="">
            <option value="semua">Makanan & Minuman</option>
            <option value="makanan">Makanan</option>
            <option value="minuman">Minuman</option>
        </select>
        <button type="submit" class="btn btn-warn">FILTER PRODUK</button>
    </form>

    <div class="pembungkus-card-2" style="padding:10px;">
        <?php

        $result = $conn->query(getKategoriProduk());
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
                <div class="card-produk" style="padding:0 5px;">
                    <img src="<?= $row['image_url'] ?>" alt="Mie Ayam">
                    <div class="deskripsi">
                        <p name="nama_produk"><?= $row['nama'] ?></p>
                        <b name="">Price : <?= $row['harga'] ?></b>
                    </div>
                </div>
        <?php }
        } else {
            echo '<h2>Produk Tidak Ditemukan!</h2>';
        } ?>
    </div>

</body>

</html>