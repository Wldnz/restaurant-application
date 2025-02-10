<?php
    require_once '../../config/db.php';
    require_once '../../utils/helper.php';
    require_once '../../model/cart.php';
    session_start();
    if(!isCashier()) goToLoginPage();
    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if(!isset($_GET["id"]) && !isset($_SESSION["currentMeja"])|| empty($_GET["id"]) && !isset($_SESSION["currentMeja"])) return goToCashierPage();
   

    if(isset($_GET["id"])){
        $_SESSION["customer"] = [];
        $_SESSION['cart'] = [];
        $_SESSION['deletedProducts']= [];
        $_SESSION['currentMeja'] = $_GET['id'];
        $_SESSION['sudahOrder'] = false;


        $_SESSION["customer"] = $conn->query("SELECT * FROM meja where id='" . $_SESSION['currentMeja'] ."'")->fetch_assoc();
    }

    $url = rootLocation();
    

    $customer = $_SESSION['customer'];
    $id_meja = $_SESSION['currentMeja'];

    if(isset($_GET["status"]) && $_GET['status']){
        $_SESSION["id_detailPesanan"] = $conn->query("SELECT * FROM detailpesanan where id_meja='". $_SESSION['currentMeja'] . "' and status='0'")->fetch_assoc()["id"];
        $_SESSION["sudahOrder"] = true;
        $id_detailPesanan = $_SESSION['id_detailPesanan'];
        $result = $conn->query("SELECT produk.*,pesanan.qty as qty FROM detailpesanan INNER JOIN pesanan on pesanan.id_detailpesanan = detailpesanan.id INNER JOIN produk on pesanan.id_produk = produk.id WHERE detailpesanan.id = '$id_detailPesanan' and detailpesanan.status = 0;");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                array_push($_SESSION["cart"],new Cart($row["id"],$row["nama"],$row["qty"],$row['harga'],$row['image_url']));
            }
        }
    }
    if(isset($_GET['indexCart'])){
        $index = $_GET['indexCart'];
        if(!isset($_SESSION['cart'][$index])) return refreshPage();
        executePesanan($index);
        header('Location: '.clearParamsCurrentUrl('indexCart'));
    }
    if(isset($_GET['tambah-skrng'])){
        if(count($_SESSION['cart']) == 0) return refreshPage();
        insertAllPesanan($id_meja,$customer['nama_pengguna'],$customer['jumlah_orang'],'0',$conn);
        goToCashierPage();
    }
    else if(isset($_GET['update-skrng'])){
        if(isset($_SESSION['id_detailPesanan'])){
           
            if(count($_SESSION['cart']) == 0) clearAllProduct($_SESSION['id_detailPesanan'],$id_meja,$conn);
            updateDataProduct($_SESSION['id_detailPesanan'],$_SESSION['cart'],$conn);
            goToCashierPage();
        }
    }
    elseif(isset($_GET["clear-skrng"])){
        if(isset($_SESSION["id_detailPesanan"])){
            clearAllProduct($_SESSION['id_detailPesanan'],$id_meja,$conn);
            goToCashierPage();
        }
    }  

    // function internal
        // function pesanan
    function makeProduk(){
        $nama_produk = $_GET['nama_produk'];
        $image_url = $_GET['image_produk'];
        $price_produk = $_GET['price_produk'];
        $id_produk = $_GET['id_produk'];
        $produk = new Cart($id_produk,$nama_produk,1,$price_produk,$image_url);
        return $produk;
    }
    function refreshPage(){
        $url = rootLocation();
        $id_meja = $_SESSION["currentMeja"];
        $currentLocation = "$url/cashier/meja/detailMeja.php?id=$id_meja"; 
        header("Location: $currentLocation");
    }

    if(isset($_GET['pesanan'])){

        $produk = makeProduk();
        if(ifExist($produk->getId())){
            $_SESSION['cart'][getIndexArray($produk->getId())]->increaseQty();
        }else{
            array_push($_SESSION['cart'],$produk);
        }
        // refreshPage();
    }

     //end function pesanan
       function getHarga(){
        $harga = 0;
        $carts = $_SESSION['cart'];
        for($i = 0; $i < count($_SESSION['cart']); $i++){
            $harga += $carts[$i]->getQty() * $carts[$i]->getHarga();
        }
        return $harga;
    }

    function getTotalHarga($biayaAdmin){
        $harga = getHarga() + getPpn() + $biayaAdmin;
        return $harga;
    }

    function getPpn(){
        $harga = getHarga();
        return ($harga / 100) * 12;
    }
       
       // increaseDecreasePesanan start
       function ifExist($id){
           $isTrue = false;
           foreach($_SESSION['cart'] as $cart){
               if($id == $cart->getId()) return $isTrue = true;
            }
            return $isTrue;
        }
        
        function getIndexArray($id){
            $indexOf = 0;
            foreach($_SESSION['cart'] as $cart){
                if($id == $cart->getId()) break;
                $indexOf++;
            }
            return $indexOf;
        }
        
        //increase,decrease,delete cart;
        
        function increeaseDecreasePesanan($index,$mode){
            $currentProduct = $_SESSION['cart'][$index];
            
            switch($mode){
                case 'tambah':
                    $currentProduct->increaseQty(); 
                    break;
                case 'kurang':
                    if(
                        $currentProduct->getQty() > 1) {
                            $currentProduct->decreaseQty();
                        }
                    else{
                        array_splice($_SESSION['cart'],$index,1);
                        array_push($_SESSION['deletedProducts'],$currentProduct);
                    }
                    break;
                    case 'hapus':
                        array_splice($_SESSION['cart'],$index,1);
                        array_push($_SESSION['deletedProducts'],$currentProduct);
                    break;
                }
                        
        }
                    
        function executePesanan($index){
            if(isset($_GET['increase'])){
                increeaseDecreasePesanan($index,'tambah');
            }
            elseif(isset($_GET['decrease'])){
                increeaseDecreasePesanan($index,'kurang');
            }
            elseif(isset($_GET['close_btn'])){
                increeaseDecreasePesanan($index,'hapus');
            }
        }
    
    
    
    function clearParamsCurrentUrl($params){
        $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = preg_replace('~(\?|&)'. $params .'=[^&]*~', '$1', $link);
        return $url;
    }
    
    // increaseDecreasePesanan end

    // end function internal
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Meja</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <?php include "../../layout/navbar.php"?>
    <div class="main">
        <aside class="left">

            <form action="<?php $_SERVER["PHP_SELF"] ?> " class="searchBar">
                <input type="text" placeholder="Cari Produk..." name="produk">
                <button type="submit">SEARCH</button>
            </form>

           <form action="<?php $_SERVER["PHP_SELF"] ?>" method="get" class="filter-makanan">
                <select name="kategori" id="">
                    <option value="semua">Makanan & Minuman</option>
                    <option value="makanan">Makanan</option>
                    <option value="minuman">Minuman</option>
                </select>
                <button type="submit" class="btn btn-warn">FILTER PRODUK</button>
           </form>

            <div class="pembungkus-card">
                <?php
                   
                    $result = $conn->query(getKategoriProduk());
                    if($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                ?>
                <form action="<?php $_SERVER['PHP_SELF'] ?>" class="card-produk">
                    <img src="<?= $row['image_url']?>" alt="Mie Ayam">
                    <div class="deskripsi">
                        <p name="nama_produk"><?= $row['nama']?></p>
                        <b name="">Price : <?= $row['harga']?></b>
                        <button type="submit" name="pesanan">Tambahkan Pesanan</button>
                    </div>
                    <input type="number" name="id_produk" value="<?= $row['id']?>" hidden readonly>
                    <input type="text" name="image_produk" value="<?= $row['image_url']?>" hidden readonly>
                    <input type="text" name="nama_produk" value="<?= $row['nama']?>" hidden readonly>
                    <input type="number" name="price_produk" value="<?= $row['harga']?>" hidden readonly>
                </form>
                <?php }}else{echo '<h2>Produk Tidak Ditemukan!</h2>';} ?>
            </div>

        </aside>
        <aside class="right">
            <div class="pengguna-data">
                <b>Meja : <?= $customer["nama"] ?></b>
                <p>Nama : <?= $customer["nama_pengguna"] ?></p>
                <p>Jumlah : <?= $customer["jumlah_orang"] ?> Orang</p>
                <?php
                    if($customer["status"]){
                    
                    ?>
                        <a href="#" onclick="removeUser('<?= $url?>','<?= $customer['id'] ?>','<?= getTotalHarga(2500) ?>',<?= $customer['status'] ?>)">Selesaikan Pesanan</a>
                    <?php }else{
                        ?>
                        <a href="#"><s>Selesaikan Pesanan</s></a>
                    <?php } 
                    ?>
                <a href="#" onclick="changeData('<?= $url?>','<?= $customer['id'] ?>',<?php echo count($_SESSION['cart']) > 0? 1 : 0 ?>)">Ganti Data?</a>
            </div>
           

            <div class="list-makanan">
                <h4>List Pesanan</h4>
                <div class="pembungkus-pesanan">
                    <?php
                    
                        for($i = 0; $i < count($_SESSION['cart']); $i++){
                        ?>
                        <div class="pesanan">
                            <img src="<?= $_SESSION['cart'][$i]->getImage_url()?>" alt="<?= $_SESSION['cart'][$i]->getNama()?>">
                            <div class="profile-makanan">
                                <p><?= $_SESSION['cart'][$i]->getNama()?></p>
                                <b>Price : <?= $_SESSION['cart'][$i]->getHarga()?></b>
                            </div>
                            <form action="<?php $_SERVER['PHP_SELF'] ?>" class="kurangTambah" method="get">
                                <button type="submit" name="decrease">-</button>
                                <input type="text" inputmode="numeric" name="qty" id="qty" value="<?= $_SESSION['cart'][$i]->getQty()?>" min="1" readonly>
                                <input type="text" inputmode="numeric" name="indexCart" id="qty" value="<?= $i?>" min="1" hidden readonly>
                                <button type="submit" name="increase">+</button>
                                <button type="submit" name="close_btn">X</button>
                            </form>
                        </div>
                        
                    <?php } ?>
                </div>
                <div class="harga">
                    <p>Jumlah Pesanan : <?= count($_SESSION['cart'])?></p>
                    <p>Harga : <?= getHarga() ?> </p>
                    <p>PPN 12% : <?= getPpn() ?> </p>
                    <p>Biaya Admin : 2500 </p>
                    <p>Total Harga : <?= getTotalHarga(2500) ?></p>
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" class="byr-skrng" method="get">
                        <input type="text"  name="harga" value="<?= getHarga() ?>" hidden>
                        <input type="text"  name="ppn" value="<?= getPpn() ?>" hidden>
                        <input type="text"  name="totalHarga" value="<?= getTotalHarga(2500) ?>" hidden>
                        <div class="btn-wrapper">
                            <?php 
                                    if(!isset($_SESSION['sudahOrder']) || !$_SESSION['sudahOrder']){
                                        ?>
                                        <button class="btn btn-add" type="submit" name="tambah-skrng">Tambah Pesanan</button>
                                    <?php } ?>
                                <button class="btn btn-upd" type="submit" name="update-skrng">Update Pesanan</button>
                                <button class="btn btn-clr" type="submit" name="clear-skrng">Clear Pesanan</button>
                        </div>
                    </form>
                </div>
            </div>

        </aside>
    </div>



    <script>
        function changeData(rootUrl,id,boolean){
            location.href=`${rootUrl}/cashier/customer/changeUser.php?id=${id}&sudahPesan${boolean}`;
        }

        function removeUser(rootUrl,id,harga,status){
            if(confirm("Are You Sure Want To Clear This Table?")){
                location.href=`${rootUrl}/cashier/pesanan/selesaikanPesanan.php?id=${id}&harga=${harga}&status=${status}`;
            }
        }

    </script>
    
</body>
</html>