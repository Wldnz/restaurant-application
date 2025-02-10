<?php

    require_once '../../components/table.php';
    require_once '../../utils/helper.php';
    require_once '../../config/db.php';
    session_start();
    validateLogin();
    $url = rootLocation();
    $sql="SELECT detailpesanan.id, meja.nama as nama_meja, detailpesanan.nama_pengguna, detailpesanan.jumlah_orang, histori.total_harga, detailpesanan.tanggal as tanggal_masuk, histori.tanggal_selesai as tanggal_keluar FROM detailpesanan  INNER JOIN histori ON detailpesanan.id = histori.id_detailpesanan INNER JOIN meja ON detailpesanan.id_meja = meja.id;";
    $laporanStructure = [
        ["ID","Nama Meja","Customer","Jumlah","Total Harga","Tanggal Masuk","Tanggal Keluar","action_name" => "Lihat Detail...","isMany" => true,"Action" => "$url/admin/pesanan/detailPesanan.php"],
        ["id","nama_meja","nama_pengguna","jumlah_orang","total_harga","tanggal_masuk","tanggal_keluar"]
    ]

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - WildanResto</title>
    <link rel="stylesheet" href="<?= "$url/style/style.css" ?>">
</head>
<body>

    <?php include "../../layout/navbar.php" ?>
    
    <div class="container">
        <h2>Laporan Histori Pesanan</h2>
        <?php createTable($laporanStructure[0],$laporanStructure[1],$sql,$conn)?>
    </div>
</body>
</html>