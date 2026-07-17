<?php

include "includes/config.php";

cekLogin();
if($_SESSION['role']!="Admin"){

    header("Location: dashboard.php");

    exit;

}

$data=query("

SELECT *

FROM menu

ORDER BY kategori,nama

");

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Data Menu</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="assets/css/menu.css">

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

🍜 Data Menu

</h2>

<p>

Daftar menu Kedai Misop Nde Tigan

</p>

</div>

<div class="card">
    
<div class="search-box">

<input

type="text"

id="searchMenu"

placeholder="🔍 Cari nama menu...">

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Gambar</th>

<th>Nama</th>

<th>Kategori</th>

<th>Harga</th>

<th>Stok</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($menu=fetch($data)):

?>

<tr>

<td>

<?= $no++ ?>

</td>

<td>

<img

src="<?= gambarMenu($menu['gambar']) ?>"

width="70"

style="border-radius:10px;">

</td>

<td>

<?= e($menu['nama']) ?>

</td>

<td>

<?= e($menu['kategori']) ?>

</td>

<td>

<?= rupiah($menu['harga']) ?>

</td>

<td>

<span class="badge badge-success">

<?= angka($menu['stok']) ?>

</span>

</td>

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

<script src="assets/js/menu.js"></script>

</body>

</html>