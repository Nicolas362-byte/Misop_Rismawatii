<?php

include "includes/config.php";

cekLogin();

/* ==============================
   TOTAL MENU
============================== */

$qMenu=query("SELECT COUNT(*) AS total FROM menu");
$totalMenu=fetch($qMenu)['total'];

/* ==============================
   TOTAL TRANSAKSI
============================== */

$qTrans=query("SELECT COUNT(*) AS total FROM transaksi");
$totalTransaksi=fetch($qTrans)['total'];

/* ==============================
   TOTAL PENDAPATAN
============================== */

$qPendapatan=query("SELECT SUM(total) AS total FROM transaksi");
$dataPendapatan=fetch($qPendapatan);

$totalPendapatan=$dataPendapatan['total'] ?? 0;

/* ==============================
   MENU TERLARIS
============================== */

$qBest=query("

SELECT

menu.nama,

SUM(detail_transaksi.qty) AS jumlah

FROM detail_transaksi

JOIN menu

ON menu.id=detail_transaksi.menu_id

GROUP BY menu.id

ORDER BY jumlah DESC

LIMIT 5

");

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Dashboard</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="assets/css/dashboard.css">

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

Dashboard

</h2>

<p>

Selamat datang,

<b><?= e($_SESSION['nama']) ?></b>

👋

</p>

</div>

<div class="dashboard-grid">

<div class="card statistik">

<i class="fa-solid fa-utensils"></i>

<h3>

<?= angka($totalMenu) ?>

</h3>

<p>Total Menu</p>

</div>

<div class="card statistik">

<i class="fa-solid fa-receipt"></i>

<h3>

<?= angka($totalTransaksi) ?>

</h3>

<p>Total Transaksi</p>

</div>

<div class="card statistik">

<i class="fa-solid fa-money-bill-wave"></i>

<h3>

<?= rupiah($totalPendapatan) ?>

</h3>

<p>Total Pendapatan</p>

</div>

</div>
<div class="card mt-3">

<h3>

🔥 Menu Terlaris

</h3>

<table>

<thead>

<tr>

<th>No</th>

<th>Nama Menu</th>

<th>Terjual</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=fetch($qBest)):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= e($row['nama']) ?></td>

<td><?= angka($row['jumlah']) ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<div class="footer">

© <?= date("Y") ?>

Kedai Misop Nde Tigan

</div>

</div>

</div>

<script src="assets/js/dashboard.js"></script>

</body>

</html>