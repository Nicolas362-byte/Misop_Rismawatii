<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
?>

<div class="navbar">

    <div class="navbar-left">

        <h3><?= APP_NAME ?></h3>

    </div>

    <div class="navbar-right">

        <span>

            <i class="fa-solid fa-user"></i>

            <?= e($_SESSION['nama']) ?>

        </span>

    </div>

</div>