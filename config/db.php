<?php


    $hostname = "your_host_name"; // localhost or any host
    $username = "mysql_user"; // don't using root (optional & depends on you)
    $password = "mysql_password";
    $database = "mysql_database";

    $conn = mysqli_connect($hostname,$username,$password,$database) or die("Connected Failed");

?>
