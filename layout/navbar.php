<?php

$url = rootLocation();

?>
<nav>
    <!-- Hello, <?= $_SESSION['name']?> -->
    <h3><a href="<?= "$url/cashier" ?>">Wildan Restaurant</a></h3>
    <ul>
        
        <li>
            <a href="<?= "$url/laporan.php" ?>">Laporan</a>
        </li>
        <li>
            <a href="<?= "$url/logout.php" ?>">Log-out</a>
        </li>
    </ul>
</nav>