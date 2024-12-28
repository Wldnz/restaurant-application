
<?php


function rootLocation(){
    $servername = $_SERVER['SERVER_NAME'];
    $protocol = strtolower(str_split($_SERVER['SERVER_PROTOCOL'],4)[0]);
   // $folder_name = "folder_name" {optional}
    // if using folder_name => "$protocol://$servername/$folder_name";
    $url = "$protocol://$servername";
    return $url;
}


function backToDetailMeja($id,$status){
    header("Location: ". rootLocation()."/cashier/meja/detailMeja.php?id=$id&status=$status");
  }

  function kosongkanMeja($currentMeja,$mysql){
    $sql = "UPDATE meja SET nama_pengguna='',jumlah_orang='0' , status='0' WHERE meja.id='$currentMeja'";
    return $mysql->query($sql);
  }

  function updateMeja($id,$nama,$jumlah,$status,$mysql){
    $sql = "UPDATE meja SET nama_pengguna='$nama',jumlah_orang='$jumlah' , status='$status' WHERE meja.id='$id'";
    return $mysql->query($sql);
}

function updateDetailPesanan($currentMeja,$id_meja,$nama,$jumlah,$mysql){
    $sql = "UPDATE detailpesanan set id_meja='$id_meja', nama_pengguna='$nama', jumlah_orang = '$jumlah' where id_meja='$currentMeja' and status ='0'";
    return  $mysql->query($sql);
  }

  function validateLogin(){
    $url = rootLocation();
    if(!isset($_SESSION["isLogin"]) || !$_SESSION["isLogin"]) return header("Location: $url/login.php");
  }

  function goToCashierPage(){
    $url = rootLocation()."/cashier";
    header("Location: $url");
  }

  function insertIntoDetailPesanan($id,$nama,$jumlah,$status,$mysql){
    $tanggal = date('Y-m-d');
    $sql = "INSERT INTO detailpesanan(id_meja,nama_pengguna,jumlah_orang,tanggal,status) VALUES('$id','$nama','$jumlah','$tanggal','$status')";
    if($mysql->query($sql)){
        return $id_detailPesanan = $mysql->insert_id;
    }
}

function insertAllPesanan($id,$nama,$jumlah,$status,$mysql){
    $idDetailPesanan = insertIntoDetailPesanan($id,$nama,$jumlah,$status,$mysql);
    $cart = $_SESSION["cart"];
    function createManyValuesSql($array,$idDetailPesanan){
        $newSql = $sql2 = "INSERT INTO pesanan(id_detailpesanan,id_produk,qty) values";;
        for($i = 0; $i < count($array); $i++){
            $idProduk = $array[$i]->getId();
            $jumlah = $array[$i]->getQty();
            if(count($array) != ($i+1)){
                $newSql .= "('$idDetailPesanan','$idProduk','$jumlah'),";
            }else{
                $newSql .= "('$idDetailPesanan','$idProduk','$jumlah');";
            }
        }
        return $newSql;
    }


    if($mysql->query(createManyValuesSql($cart, $idDetailPesanan))){
        if($mysql->query("UPDATE meja set status='1' where id='$id'")) return $_SESSION['cart'] = []; 
    } 
}


function deletedDataFromCartToDatabase($idDetailPesanan,$mysql){
    $oldCart = $_SESSION['deletedProducts'];
    $result = $mysql->query("SELECT * FROM pesanan where id_detailpesanan='$idDetailPesanan'");
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $index = 0;
            foreach($oldCart as $cart){
                $idPesanan = $cart->getId();
                if($row["id_produk"] == $idPesanan){
                    $mysql->query("DELETE FROM pesanan WHERE id_produk='$idPesanan' AND id_detailpesanan='$idDetailPesanan'");
                    array_splice($_SESSION['deletedProducts'],$index,1);
                }
                $index++;
            }
        }
    }
}

function updateDataProduct($idDetailPesanan,$cart,$mysql){
    $result = $mysql->query("SELECT * FROM pesanan where id_detailpesanan='$idDetailPesanan'");
    if($result->num_rows == 0) return;
    //update terjadi jika sudah ada produknya di database dan valuenya (qty) berbeda
    while($row = $result->fetch_assoc()){
        for($i = 0; $i < count($cart); $i++){
            $idPesanan = $cart[$i]->getId();
            $qtyPesanan = $cart[$i]->getQty();
            if($row['id_produk'] == $idPesanan && $row['qty'] != $qtyPesanan){
                if($mysql->query("UPDATE pesanan set qty='$qtyPesanan' where id_produk='$idPesanan'")){
                    array_splice($cart,$i,1);
                };
            }else if($row['id_produk'] == $idPesanan){
                array_splice($cart,$i,1);
            }
        }
    }

    if(isset($_SESSION['deletedProducts']) && count($_SESSION['deletedProducts']) > 0){
        deletedDataFromCartToDatabase($idDetailPesanan,$mysql);
    }

    $countCart = count($cart);
    if(count($cart) > 0){
        $sql = "INSERT INTO pesanan(id_detailpesanan,id_produk,qty) VALUES";
        for($i=0; $i < $countCart; $i++){
            $idPesanan = $cart[$i]->getId();
            $qtyPesanan = $cart[$i]->getQty();
            if(($countCart-1) != $i){
                $sql .= "('$idDetailPesanan','$idPesanan','$qtyPesanan'),";
            }else{
                $sql .= "('$idDetailPesanan','$idPesanan','$qtyPesanan');";
            }
        }
        return $mysql->query($sql);
    }
}

function clearAllProduct($idDetailPesanan,$idMeja,$mysql){
    $mysql->query("DELETE from detailpesanan where id='$idDetailPesanan'");
    $mysql->query("UPDATE meja set status ='0' where id='$idMeja'");
}
