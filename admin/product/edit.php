<?php
session_start();
require_once "../../config/db.php";
require_once "../../utils/helper.php";
require_once "../../config/db.php";
$information_username = "";
$information_harga = "";

$id = $conn->real_escape_string($_GET['id']);
$nama = $conn->real_escape_string($_GET['nama']);
$harga = $conn->real_escape_string($_GET['harga']);
$image_url = $conn->real_escape_string($_GET['image_url']);
$tipe = $conn->real_escape_string($_GET['tipe']);

$url = rootLocation();

if (!isAdmin()) return goToLoginPage();

if(
   !isset($id)|| empty ($id) || 
   !isset($nama)|| empty($nama) ||
   !isset($harga )|| empty($harga) ||
   !isset($image_url) || empty($image_url) ||
   !isset($tipe) || empty($tipe)
) return header("location: $url/admin/product");
function validateForm($nama, $harga)
{
    if (empty($nama) && empty($harga)) {
        $information_username = "nama harus di isi";
        $information_harga = "harga harus di isi";
        return false;
    } elseif (empty($nama)) {
        $information_username = "nama harus di isi";
        return false;
    } elseif (empty($harga) || $harga <= 5000) {
        $information_harga = "harga orang minimal 5000";
        return false;
    }
    return true;
}

if(isset($_POST["submit"])){
    $id = $conn->real_escape_string($_POST['id']);
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $tipe = $conn->real_escape_string($_POST['tipe']);

    $result = $conn->query("UPDATE produk set nama='$nama',harga='$harga',image_url = '$image_url',kategori='$tipe' where id='$id'");
    if($result){
        header("location: $url/admin/product");
        die();
    }    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>
<body>
    <div class="container">
        <h2>Ganti Data Produk</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" class="login" method="post">
            <div class="fieldInput">
                <label for="id">Id : </label>
                <input type="number" name="id" id="id" placeholder="id" value="<?= $id ?>" readonly>
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" value="<?= $nama ?>">
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="harga">Harga : </label>
                <input type="number" name="harga" id="harga" placeholder="harga" min="1" value="<?= $harga ?>">
                <p><?= $information_harga ?></p>
            </div>
            <div class="fieldInput">
                <label for="image_url">image_url : </label>
                <input type="text" name="image_url" id="image_url" placeholder="image_url" min="1" value="<?= $image_url ?>">
                <p><?= $information_harga ?></p>
            </div>
            <div class="fieldInput">
                <label for="meja">Kategori : </label>
                <select name="tipe" id="tipe_product">
                    <option value="makanan">
                        Makanan
                    </option>
                    <option value="minuman">
                        Minuman
                    </option>
                </select>
                
            </div>
            <button type="submit" name="submit">Next</button>
            <a class="btn" href="./" name="cancel">Cancel</a>
        </form>
    </div>

    <script>
    </script>
</body>
</html>