<?php
session_start();
require_once "../../utils/helper.php";
require_once "../../config/db.php";

if (!isAdmin()) return goToLoginPage();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Produk</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>


    <?php require_once "../../layout/navbar.php";  ?>

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
        <button class="btn btn-add"><a href="add.php" style="color:inherit; text-decoration:none; font-weight:bold;">Tambahkan Produk</a></button>
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
                    <div style="display:flex; gap:10px">
                        <form action="edit.php">
                            <button type="submit" class="btn btn-warn">Edit</button>
                            <input type="number" name="id" value="<?= $row['id'] ?>" hidden readonly>
                            <input type="text" name="image_url" value="<?= $row['image_url'] ?>" hidden readonly>
                            <input type="text" name="nama" value="<?= $row['nama'] ?>" hidden readonly>
                            <input type="number" name="harga" value="<?= $row['harga'] ?>" hidden readonly>
                            <input type="text" name="tipe" value="<?= $row['kategori'] ?>" hidden readonly>
                        </form>
                        <form action="delete.php" method="post">
                            <button type="submit" class="btn btn-clr">Delete</button>
                            <input type="number" name="id" value="<?= $row['id'] ?>" hidden readonly>
                        </form>
                    </div>
                    
                </div>
        <?php }
        } else {
            echo '<h2>Produk Tidak Ditemukan!</h2>';
        } ?>
    </div>

</body>

</html>