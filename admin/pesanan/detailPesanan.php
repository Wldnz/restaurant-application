<?php
    require_once '../../config/db.php';
    require_once '../../utils/helper.php';
    session_start();
    if(!isAdmin()) goToCashierPage();
    if(!isset($_GET['detailPesanan']) || empty($_GET['detailPesanan'])) return goToCashierPage();
    $detailPesanan = $_GET['detailPesanan'];
    $url =  rootLocation();
    $sql = "SELECT detailpesanan.id, meja.nama as nama_meja,detailpesanan.nama_pengguna as customer,detailpesanan.jumlah_orang,detailpesanan.status,detailpesanan.tanggal as tanggal_masuk,produk.id as produk_id,produk.nama,produk.harga as harga_satuan,pesanan.qty as jumlah_dibeli,produk.kategori,produk.image_url FROM pesanan INNER JOIN detailpesanan ON pesanan.id_detailpesanan = detailpesanan.id INNER JOIN produk ON produk.id = pesanan.id_produk INNER JOIN meja ON meja.id = detailpesanan.id_meja WHERE detailpesanan.id = '$detailPesanan';";
    $detailPesananTableStructure = [["Nama Meja","Customer","Jumlah Orang","Tanggal Masuk","Status Pesanan",'action_name' => "Kembali","isMany" => false,"Action" => "./laporan.php"],["nama_meja","customer","jumlah_orang","tanggal_masuk","status"]];
    $pesananTableStructure = [["Nama","Harga","Jumlah","Kategori"],["nama","harga_satuan","jumlah_dibeli","kategori"]];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - WildanResto</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <?php include "../../layout/navbar.php" ?>
    <?php include "../../components/table.php" ?>
    <div class="container">
        <h2>Data Detail Dari</h2>
        <?= createTable($detailPesananTableStructure[0],$detailPesananTableStructure[1],$sql,$conn) ?>
        <h2>Laporan Penjualan Produk</h2>
        <?= createTable($pesananTableStructure[0],$pesananTableStructure[1],$sql,$conn) ?>
    </div>
</body>
</html>