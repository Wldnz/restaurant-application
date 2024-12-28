
<?php
    session_start();
    require_once "../../config/db.php";
    require_once "../../utils/helper.php";
    validateLogin();
    if(!isset($_GET["id"]) || empty($_GET["id"])) return goToCashierPage();

    $information_username = "";
    $information_jumlah = "";
    function validateForm($nama,$jumlah,$meja){
        if(empty($nama) && empty($jumlah) && empty($meja)){ 
            $information_username = "nama harus di isi\n meja harus disii";
            $information_jumlah = "jumlah harus di isi";
            return false;
        }elseif (empty($nama)){
            $information_username = "nama harus di isi";
            return false;
        }elseif (empty($jumlah) || $jumlah <= 0){
            $information_jumlah = "jumlah orang minimal 1";
            return false;
        }elseif(empty($meja)){
            $information_username = "Meja Harus Diisi";
            return false;
        }
        return true;
    }

  if(isset($_POST['submit'])){
    
    $nama = $conn->real_escape_string($_POST['nama']);
    $jumlah = $conn->real_escape_string($_POST['jumlah_orang']);
    $current_meja = $conn->real_escape_string($_POST['id']);
    $meja =$conn->real_escape_string($_POST['meja']);
    $sudahPesan = $conn->real_escape_string($_POST['sudahPesan']);

    if(validateForm($nama,$jumlah,$meja)){
        if($current_meja == $meja){
           if($sudahPesan){
            if(updateMeja($meja,$nama,$jumlah,1,$conn)){
                if(updateDetailPesanan($current_meja,$meja,$nama,$jumlah,$conn)){
                    backToDetailMeja($meja,true);
                }
            }
            }else{
                if(updateMeja($meja,$nama,$jumlah,0,$conn)){
                    backToDetailMeja($meja,true);
                }
            }
        }else{
            if($sudahPesan){
                if(kosongkanMeja($current_meja,$conn)){
                    if(updateMeja($meja,$nama,$jumlah,1,$conn)){
                        if(updateDetailPesanan($current_meja,$meja,$nama,$jumlah,$conn)){
                            backToDetailMeja($meja,true);
                        }
                    }
                }
            }else{
                if(kosongkanMeja($current_meja,$conn)){
                    if(updateMeja($meja,$nama,$jumlah,0,$conn)){
                        backToDetailMeja($meja,true);
                    }
                }
            }
           
        }
    }
    
  }elseif(isset($_POST['cancel'])){
    $id = $_POST['id'];
    return backToDetailMeja( $id,false);
  }

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM meja where id='$id'");
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }
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
        <h2>Ganti Data Customer</h2>
        <form action="<?php $_SERVER["PHP_SELF"]?>" class="login" method="POST">
            <div class="fieldInput">
                <label for="nama">Nama : </label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan Nama" value="<?= $row['nama_pengguna'] ?>">
                <p><?= $information_username ?></p>
            </div>
            <div class="fieldInput">
                <label for="jumlah_orang">Jumlah Orang : </label>
                <input type="number" name="jumlah_orang" id="jumlah_orang" placeholder="jumlah_orang" min="1" value="<?= $row['jumlah_orang'] ?>">
                <p><?= $information_jumlah ?></p>
            </div>
            <div class="fieldInput">
                <label for="meja">Meja Tersedia : </label>
                <select name="meja" id="meja">
                    <?php
                       $result =  $conn->query('SELECT * FROM meja');
                       if($result->num_rows > 0){
                        while($row2 = $result->fetch_assoc()){
                            // && $row["nama"] != $row2["nama"]
                            if(!$row2['status']){
                            ?>
                            <option value="<?= $row2['id']?>" name="<?= $row2['nama']?>">
                                <?= $row2['nama'] ?> 
                            </option>
                        <?php
                            }elseif($row["nama"] == $row2["nama"]){
                        ?>
                            <option value="<?= $row2['id']?>" name="<?= $row2['nama']?>">
                                <?= $row2['nama'] ?> 
                            </option>
                        <?php 
                            }
                        }
                    }
                    ?>
                </select>
                <p>Current Position at Meja : <?= $row['nama'] ?></p>
            </div>
            <button type="submit" name="submit">Next</button>
            <button type="submit" name="cancel">Cancel</button>
            <input type="hidden" name="id" value="<?= $row['id'] ?>">
            <input type="hidden" name="sudahPesan" value="<?= $row['status'] ?>">
        </form>
    </div>

    <script>
    </script>
</body>
</html>