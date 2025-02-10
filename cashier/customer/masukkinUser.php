
<?php
    session_start();
    require_once "../../config/db.php";
    require_once "../../utils/helper.php";
    if(!isCashier()) goToLoginPage();

    if(!isset($_GET["id"]) || empty($_GET["id"])) return goToCashierPage();
    $information_username = "";
    $information_jumlah = "";

    function validateForm($nama,$jumlah){
        if(empty($nama) && empty($jumlah)){ 
            $information_username = "nama harus di isi";
            $information_jumlah = "jumlah harus di isi";
            return false;
        }elseif (empty($nama)){
            $information_username = "nama harus di isi";
            return false;
        }elseif (empty($jumlah) || $jumlah <= 0){
            $information_jumlah = "jumlah orang minimal 1";
            return false;
        }
        return true;
    }


  if(isset($_POST['submit'])){
    $nama = $conn->real_escape_string($_POST['nama']);
    $jumlah = $conn->real_escape_string($_POST['jumlah_orang']);
    $id = $conn->real_escape_string($_GET['id']);
    if(validateForm($nama,$jumlah)){
        $sql = "UPDATE meja SET nama_pengguna='$nama',jumlah_orang='$jumlah' , status='0' WHERE meja.id='$id'";
        $result = $conn->query($sql);
        if(updateMeja($id,$nama,$jumlah,0,$conn)){
            backToDetailMeja($id,false);
        }
    }
  }elseif(isset($_POST['cancel'])){
    goToCashierPage();
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
        <form action="<?php $_SERVER["PHP_SELF"]?>" class="login" method="post">
            <div class="fieldInput">
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan Nama">
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="jumlah_orang">Jumlah Orang : </label>
                <input type="number" name="jumlah_orang" id="jumlah_orang" placeholder="jumlah_orang" min="1" value="1">
                <p><?= $information_jumlah ?></p>
            </div>
            <button type="submit" name="submit">Next</button>
            <button type="submit" name="cancel">Cancel</button>
        </form>
    </div>

    <script>
    </script>
</body>
</html>