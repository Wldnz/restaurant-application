<?php

$url = rootLocation();



?>
<nav>
    <!-- Hello, <?= $_SESSION['name']?> -->
    <h3><a href="<?= "$url/cashier" ?>">Wildan Restaurant</a></h3>
    <ul>
        
        <li>
            <?php echo isAdmin()?"<a href='$url/admin/product?'>Manage Product</a>" : ''?>
        </li>
        <li>
            <?php echo isAdmin()?"<a href='$url/admin/pesanan/laporan.php?'>Laporan</a>" : ''?>
        </li>
        <li>
            <a href="<?= "$url/logout.php" ?>">Log-out</a>
        </li>
    </ul>
</nav>