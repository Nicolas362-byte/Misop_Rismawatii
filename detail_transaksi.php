<?php

include "includes/config.php";

cekLogin();

if(!isset($_GET['id'])){

redirect("laporan.php");

}

$id=(int)$_GET['id'];

$trx=query("

SELECT *

FROM transaksi

WHERE id='$id'

");

$data=fetch($trx);

if(!$data){

redirect("laporan.php");

}

$detail=query("

SELECT

menu.nama,

detail_transaksi.qty,

detail_transaksi.harga,

detail_transaksi.subtotal

FROM detail_transaksi

JOIN menu

ON menu.id=detail_transaksi.menu_id

WHERE transaksi_id='$id'

");

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Detail Transaksi</title>

<link rel="stylesheet"
href="assets/css/style.css">

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

📋 Detail Transaksi

</h2>

<p>

<?= kodeTransaksi($id) ?>

</p>

</div>

<div class="card">

<div class="d-flex justify-between mb-2">

<div>

<b>Customer</b>

<br>

<?= e($data['customer']) ?>

</div>

<div>

<b>Kasir</b>

<br>

<?= e($data['kasir']) ?>

</div>

<div>

<b>Tanggal</b>

<br>

<?= tanggalIndonesia($data['tanggal']) ?>

</div>

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Menu</th>

<th>Harga</th>

<th>Qty</th>

<th>Subtotal</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

while($row=fetch($detail)):

?>

<tr>

<td><?= $no++ ?></td>

<td><?= e($row['nama']) ?></td>

<td><?= rupiah($row['harga']) ?></td>

<td><?= angka($row['qty']) ?></td>

<td><?= rupiah($row['subtotal']) ?></td>

</tr>

<?php endwhile; ?>

</tbody>

<tfoot>

<tr>

<th colspan="4">

Subtotal

</th>

<th>

<?= rupiah($data['subtotal']) ?>

</th>

</tr>

<tr>

<th colspan="4">

Diskon

</th>

<th>

<?= rupiah($data['diskon']) ?>

</th>

</tr>

<tr>

<th colspan="4">

Pajak

</th>

<th>

<?= rupiah($data['pajak']) ?>

</th>

</tr>

<tr>

<th colspan="4">

Grand Total

</th>

<th>

<?= rupiah($data['total']) ?>

</th>

</tr>

</tfoot>

</table>

<div class="mt-3">

<a

href="laporan.php"

class="btn btn-secondary">

← Kembali

</a>

 <div style="margin-top:15px; text-align:right;">

    <a
    href="struk.php?id=<?= $id ?>"
    class="btn btn-danger"
    target="_blank">

        <i class="fa-solid fa-file-pdf"></i>

        Cetak PDF

    </a>

</div>

</div>

<div class="footer">

© <?= date("Y") ?>

<?= APP_NAME ?>

</div>

</div>

</div>

</body>

</html>