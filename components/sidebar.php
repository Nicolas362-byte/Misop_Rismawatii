<?php

$current = basename($_SERVER['PHP_SELF']);

function activeMenu($page, $current){
    return ($page == $current) ? "active" : "";
}

?>

<div class="sidebar">

    <div class="logo">

        <img src="assets/logo.png" alt="Logo">

        <h2>Kedai Misop</h2>

        <small>Nde Tigan</small>

    </div>

    <ul>

        <li class="<?= activeMenu('dashboard.php',$current) ?>">
            <a href="dashboard.php">
                <i class="fa-solid fa-house"></i>
                Dashboard
            </a>
        </li>

        <?php if($_SESSION['role']=="Admin"): ?>

<li class="<?= activeMenu('menu.php',$current) ?>">
    <a href="menu.php">
        <i class="fa-solid fa-utensils"></i>
        Data Menu
    </a>
</li>

<?php endif; ?>

        <li class="<?= activeMenu('kasir.php',$current) ?>">
            <a href="kasir.php">
                <i class="fa-solid fa-cash-register"></i>
                Kasir
            </a>
        </li>

        <?php if($_SESSION['role']=="Admin"): ?>

<li class="<?= activeMenu('laporan.php',$current) ?>">
    <a href="laporan.php">
        <i class="fa-solid fa-file-lines"></i>
        Laporan
    </a>
</li>

<?php endif; ?>

       <?php if($_SESSION['role']=="Admin"): ?>

<li class="<?= activeMenu('grafik.php',$current) ?>">
    <a href="grafik.php">
        <i class="fa-solid fa-chart-column"></i>
        Grafik
    </a>
</li>

<?php endif; ?>

        <li class="<?= activeMenu('profil.php',$current) ?>">
            <a href="profil.php">
                <i class="fa-solid fa-user"></i>
                Profil
            </a>
        </li>

        <li>
            <a href="logout.php"
               onclick="return confirm('Yakin ingin logout?')">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </a>
        </li>

    </ul>

</div>