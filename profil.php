<?php

include "includes/config.php";

cekLogin();

/*====================================
    JUDUL PROFIL
====================================*/

$role = strtolower(trim($_SESSION['role']));

$judulProfil = ($role == "admin")
    ? "Profil Admin"
    : "Profil Kasir";

/*====================================
    FOTO PROFIL
====================================*/

$fotoProfil = "assets/img/profil.jpg";

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $judulProfil ?></title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/profil.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include "components/sidebar.php"; ?>

<div class="content">

<?php include "components/navbar.php"; ?>

<div class="page-title">

<h2>

👤 <?= $judulProfil ?>

</h2>

<p>

Informasi akun yang sedang login.

</p>

</div>

<div class="card profile-card">

<div class="avatar">

<?php if(file_exists($fotoProfil)): ?>

<img
src="<?= $fotoProfil ?>"
alt="Foto Profil"
style="
width:120px;
height:120px;
border-radius:50%;
object-fit:cover;
border:4px solid #198754;
">

<?php else: ?>

<i class="fa-solid fa-user"></i>

<?php endif; ?>

</div>

<table>

<tr>

<td width="180">

Nama

</td>

<td>

: <?= e($_SESSION['nama']) ?>

</td>

</tr>

<tr>

<td>

Username

</td>

<td>

: <?= e($_SESSION['username']) ?>

</td>

</tr>

<tr>

<td>

Role

</td>

<td>

: <?= e($_SESSION['role']) ?>

</td>

</tr>

<tr>

<td>

Login Terakhir

</td>

<td>

: <?= date("d F Y H:i") ?>

</td>

</tr>

</table>

</div>

<div class="footer">

© <?= date("Y") ?>

<?= APP_NAME ?>

</div>

</div>

</div>

</body>

</html>