<?php
session_start();
require_once "../../utils/helper.php";
require_once "../../config/db.php";

if(!isAdmin()) {goToLoginPage(); die();}

$url = rootLocation();

if(isset($_POST["id"]) && $_POST["id"]){
    $result = $conn->query("DELETE from produk where id='$id'");

    if($result){
        header("location: $url/admin/product");
        die();
    }

}else{
    header("location: $url/admin/product");
    die();
}


?>