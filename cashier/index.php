<?php

// use function PHPSTORM_META\type;

    session_start();
    require_once '../utils/helper.php';
    $url = rootLocation();
    validateLogin();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Meja</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php include_once "../layout/navbar.php";?>

    <div class="pembungkus">
        <h2>Kelola Meja</h2>
        <div class="pembungkus-item">
        <?php
            require_once "../config/db.php";
            $sql = "SELECT * FROM meja";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){ 
                // jika blm terisi  
                if(!$row['nama_pengguna']){
        ?>
            <div class="item" onclick="clickMe('<?= $url ?>','<?= $row['id']?>','<?= $row['nama']?>')">
                <b><?= $row["nama"]?></b>
                <p><?php echo $row["nama_pengguna"]? "Nama : " . $row["nama_pengguna"] : ''  ?></p>
                <p><?= $row["jumlah_orang"]?> Orang</p>
                <p><?php echo $row["status"]? 'Sudah Pesan' : 'Belum Pesan' ?></p>
            </div>
            <?php }elseif($row['nama_pengguna'] && !$row['status']){ ?>
            <div class="item belum-pesan" onclick="belumPesan('<?= $url ?>','<?= $row['id']?>','<?= $row['nama']?>')">
                <b><?= $row["nama"]?></b>
                <p><?php echo $row["nama_pengguna"]? "Nama : " . $row["nama_pengguna"] : ''  ?></p>
                <p><?= $row["jumlah_orang"]?> Orang</p>
                <p><?php echo $row["status"]? 'Sudah Pesan' : 'Belum Pesan' ?></p>
            </div>      
        <?php }else{ ?>
            <div class="item sudah-terisi" onclick="sudahPesan('<?= $url ?>','<?= $row['id']?>','<?= $row['nama']?>')">
                <b><?= $row["nama"]?></b>
                <p><?php echo $row["nama_pengguna"]? "Nama : " . $row["nama_pengguna"] : ''  ?></p>
                <p><?= $row["jumlah_orang"]?> Orang</p>
                <p><?php echo $row["status"]? 'Sudah Pesan' : 'Belum Pesan' ?></p>
            </div>            
        <?php }} ?>
        </div>
    </div>
    <script>
        function clickMe(rootUrl,id,meja){
            const url = `${rootUrl}/cashier/customer/masukkinUser.php?id=${id}&meja=${meja}&status=false`;
            location.href = url;
        }

        function sudahPesan(rootUrl,id,meja){
            const url = `${rootUrl}/cashier/meja/detailMeja.php?id=${id}&meja=${meja}&status=true`;
            location.href = url;
        }

        function belumPesan(rootUrl,id){
            const url = `${rootUrl}/cashier/meja/detailMeja.php?id=${id}`;
            location.href = url;
        }
    </script>
</body>
</html>