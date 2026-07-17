<?php

include "includes/config.php";

cekLogin();

/*==================================
    FILTER TANGGAL
==================================*/

$tanggalAwal=$_GET['awal'] ?? "";
$tanggalAkhir=$_GET['akhir'] ?? "";

$sql="SELECT * FROM transaksi";

if($tanggalAwal!="" && $tanggalAkhir!=""){

$sql.=" WHERE DATE(tanggal)
BETWEEN '$tanggalAwal'
AND '$tanggalAkhir'";

}

$sql.=" ORDER BY id DESC";

$data=query($sql);

?>
<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Laporan</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="assets/css/laporan.css">

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

📄 Laporan Transaksi

</h2>

<p>

Riwayat seluruh transaksi.

</p>

</div>

<div class="card">

<div class="laporan-header">

    <a
    href="export_excel.php"
    class="btn btn-success">

        <i class="fa-solid fa-file-excel"></i>

        Export Excel

    </a>

</div>


<form method="GET" class="filter">

<div>

<label>Tanggal Awal</label>

<input
type="date"
name="awal"
value="<?= e($tanggalAwal) ?>">

</div>

<div>

<label>Tanggal Akhir</label>

<input
type="date"
name="akhir"
value="<?= e($tanggalAkhir) ?>">

</div>

<div>

<label>&nbsp;</label>

<button
class="btn btn-primary">

Filter

</button>

</div>

</form>

<table>

<thead>

<tr>

<th>No</th>

<th>Kode</th>

<th>Tanggal</th>

<th>Customer</th>

<th>Kasir</th>

<th>Total</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

$totalPendapatan=0;

while($row=fetch($data)):

$totalPendapatan+=$row['total'];

?>

<tr>

<td><?= $no++ ?></td>

<td><?= kodeTransaksi($row['id']) ?></td>

<td><?= tanggalIndonesia($row['tanggal']) ?></td>

<td><?= e($row['customer']) ?></td>

<td><?= e($row['kasir']) ?></td>

<td><?= rupiah($row['total']) ?></td>

<td>

<a
href="detail_transaksi.php?id=<?= $row['id'] ?>"
class="btn btn-warning">

<i class="fa-solid fa-eye"></i>

Detail

</a>

</td>

</tr>

<?php endwhile; ?>

</tbody>

<tfoot>

<tr style="background:#198754;color:white;">

    <td></td>

    <td style="font-weight:bold;">
        💰 Total Pendapatan
    </td>

    <td></td>

    <td></td>

    <td></td>

    <td style="font-weight:bold;">
        <?= rupiah($totalPendapatan) ?>
    </td>

    <td>

      <a
href="export_excel.php?awal=<?= e($tanggalAwal) ?>&akhir=<?= e($tanggalAkhir) ?>"
class="btn btn-success">

    <i class="fa-solid fa-file-excel"></i>

    Export Excel

</a>

    </td>

</tr>

</tfoot>

</table>
 

</div>

<div class="footer">

© <?= date("Y") ?>

<?= APP_NAME ?>

</div>

</div>

</div>

<script src="assets/js/laporan.js"></script>

</body>

</html>