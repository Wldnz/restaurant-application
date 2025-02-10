<?php
require_once "../utils/helper.php";
require_once  "../config/db.php";
require_once "../components/table.php";

$url = rootLocation();
$id_detailPesanan = 0;
$sql = "";
$isFound = false;
if(isset($_POST["order_pesanan"]) && $_POST["order_pesanan"]){
    $order_pesanan = $_POST["order_pesanan"];
    $isFound = false;
    $result = $conn->query("SELECT * FROM pesanan where id='$order_pesanan'");
    if($result->num_rows > 0){
        $isFound = true;
        $id_detailPesanan = $result->fetch_assoc()["id_detailpesanan"];
        $sql = "SELECT id_detailpesanan as id FROM pesanan where id='$order_pesanan'";
    }
}

$laporanStructure = [
    ["ID","action_name" => "Lihat Detail...","isMany" => false,"Action" => "$url/check-pesanan/detail?detailPesanan=$23"],
    ["id"]
]

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Pesanan</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
    <?php require_once "../layout/navbar_2.php" ?>
    <div class="container">
       <?php
            if($isFound){ ?>
                <?php createTable($laporanStructure[0],$laporanStructure[1],$sql,$conn)?>
            <?php
                }else{
                ?>
                 <form action="<?php $_SERVER["PHP_SELF"] ?> " class="searchBar" style="padding:10px;" method="post">
                        <input type="text" placeholder="Cari pesanan..." name="order_pesanan">
                        <button type="submit">SEARCH</button>
            </form>
            <?php
                }
            ?>
    </div>
</body>
</html>