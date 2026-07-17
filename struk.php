<?php

include "includes/config.php";

cekLogin();

if(!isset($_GET['id'])){

redirect("dashboard.php");

}

$id=(int)$_GET['id'];

$trx=query("

SELECT *

FROM transaksi

WHERE id='$id'

");

$data=fetch($trx);

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

<html>

<head>

<meta charset="UTF-8">

<title>Struk</title>

<link rel="stylesheet"

href="assets/css/style.css">

<style>

body{

background:#eee;

}

.struk{

width:380px;

margin:30px auto;

background:#fff;

padding:25px;

font-size:14px;

box-shadow:0 5px 15px rgba(0,0,0,.2);

}

.center{

text-align:center;

}

table{

width:100%;

margin-top:15px;

}

td{

padding:6px 0;

}

hr{

margin:15px 0;

}

</style>

</head>

<body>

<div class="struk">

<div class="center">

<h2>

🍜 Kedai Misop

</h2>

<p>

Nde Tigan

</p>

<hr>

</div>

<b>

<?= kodeTransaksi($id) ?>

</b>

<br>

<?= tanggalIndonesia($data['tanggal']) ?>

<br>

Kasir :

<?= e($data['kasir']) ?>

<br>

Customer :

<?= e($data['customer']) ?>

<hr>

<table>

<?php while($row=fetch($detail)): ?>

<tr>

<td>

<?= e($row['nama']) ?>

<br>

<small>

<?= rupiah($row['harga']) ?>

x

<?= angka($row['qty']) ?>

</small>

</td>

<td align="right">

<?= rupiah($row['subtotal']) ?>

</td>

</tr>

<?php endwhile; ?>

</table>

<hr>

<table>

<tr>

<td>

Subtotal

</td>

<td align="right">

<?= rupiah($data['subtotal']) ?>

</td>

</tr>

<tr>

<td>

Diskon

</td>

<td align="right">

<?= rupiah($data['diskon']) ?>

</td>

</tr>

<tr>

<td>

Pajak

</td>

<td align="right">

<?= rupiah($data['pajak']) ?>

</td>

</tr>

<tr>

<td>

<b>Total</b>

</td>

<td align="right">

<b>

<?= rupiah($data['total']) ?>

</b>

</td>

</tr>

<tr>

<td>

Bayar

</td>

<td align="right">

<?= rupiah($data['bayar']) ?>

</td>

</tr>

<tr>

<td>

Kembalian

</td>

<td align="right">

<?= rupiah($data['kembalian']) ?>

</td>

</tr>

<tr>

<td>

Metode

</td>

<td align="right">

<?= e($data['metode']) ?>

</td>

</tr>

</table>

<hr>

<div class="center">

<p>

Terima Kasih 😊

</p>

<p>

Selamat Menikmati

</p>

<br>

<button

onclick="window.print()"

class="btn btn-primary">

🖨 Cetak Struk

</button>

<a

href="kasir.php"

class="btn btn-secondary">

← Kembali

</a>

</div>

</div>

<script>

window.onload=function(){

window.print();

}

</script>

</body>

</html>