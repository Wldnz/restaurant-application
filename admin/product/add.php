<?php
session_start();
require_once "../../config/db.php";
require_once "../../utils/helper.php";
require_once "../../config/db.php";
$information_username = "";
$information_harga = "";

if (!isAdmin()) return goToLoginPage();

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


if (isset($_POST['submit'])) {
    $url = rootLocation();
    $nama = $conn->real_escape_string($_POST['nama']);
    $harga = $conn->real_escape_string($_POST['harga']);
    $image_url = $conn->real_escape_string($_POST['image_url']);
    $tipe = $conn->real_escape_string($_POST['tipe_product']);
    if (validateForm($nama, $harga)) {
        $sql = "INSERT INTO produk(nama,deskripsi,harga,kategori,image_url) values('$nama','enak','$harga','$tipe','$image_url')";
        $result = $conn->query(query: $sql);
        if ($result) {
            header("location: $url/admin/product");
        }
    }
} elseif (isset($_POST['cancel'])) {
    goToAdminPage();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style/style.css">
</head>

<body>
    <div class="container">
        <form action="<?php $_SERVER["PHP_SELF"] ?>" class="login" method="post">
            <div class="fieldInput">
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" required>
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="harga">Harga Makanan : </label>
                <input type="number" name="harga" id="harga" placeholder="harga" min="5000" required>
                <p><?= $information_harga ?></p>
            </div>
            <div class="fieldInput">
                <label for="image_url">Image (URL) : </label>
                <input type="text" name="image_url" id="image_url" placeholder="image_url" required>
            </div>
            <div class="fieldInput">
                <select name="tipe_product" id="tipe_product">
                    <option value="makanan">
                        Makanan
                    </option>
                    <option value="minuman">
                        Minuman
                    </option>
                </select>
            </div>

            <button type="submit" name="submit">Next</button>
            <a href="./">Cancel</a>
        </form>
    </div>

    <script>
    </script>
</body>

</html>