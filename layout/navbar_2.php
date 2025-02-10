<?php
$url = rootLocation();
?>
<nav>
    <h3><a href="<?= "$url" ?>">Wildan Restaurant</a></h3>
    <ul> 
        <li>
            <a href="<?= $url."/products.php"  ?>">Products</a>
        </li>
        <li>
            <a href="<?= $url."/check-pesanan"  ?>">Check Pesanan</a>
        </li>
    </ul>
</nav>