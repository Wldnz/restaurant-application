
<!-- jika tidak dikasih return maka script akan tetap berjalan walaupun sudah berganti page -->
<?php
    require_once '../../config/db.php';
    require_once '../../utils/helper.php';
    session_start();
    validateLogin();
    $url = rootLocation();

    if(!isset($_GET["id"]) || empty($_GET["id"]) || !isset($_GET["status"]) || empty($_GET["status"]) || !isset($_GET["harga"]) || empty($_GET["harga"]) ) return goToCashierPage();

    $id_meja = $conn->real_escape_string($_GET["id"]);
    $statusPesanan = $conn->real_escape_string($_GET["status"]); // => true = sudah pesan & false => blm pesan
    $harga = $conn->real_escape_string($_GET["harga"]);
    if(!$statusPesanan) return goToCashierPage();
    
    $result = $conn->query("SELECT * FROM detailPesanan where id_meja='$id_meja' and status='0'");
    if($result->num_rows > 0){
        $id_detailPesanan = $result->fetch_assoc()["id"];
        $tanggal = date("Y-m-d"); 
        // mysqli tidak support mutiple statement - gpt 2024
        $result = $conn->query("INSERT INTO histori(id_detailpesanan,total_harga,tanggal_selesai) VALUES('$id_detailPesanan','$harga','$tanggal')");
        $result = $conn->query("UPDATE meja set nama_pengguna='' , jumlah_orang='0' ,status='0' where id='$id_meja'");
        $result = $conn->query("UPDATE detailpesanan set status='1' where id='$id_detailPesanan'");
        goToCashierPage();
    }else{
        goToCashierPage();
    }    


    


    // id meja, detailPesanan.status => true, histori