<?php

include "includes/config.php";

cekLogin();

/*==========================================
    DATA GRAFIK 7 HARI TERAKHIR
==========================================*/

$dataGrafik=query("

SELECT

DATE(tanggal) AS tanggal,

SUM(total) AS pendapatan

FROM transaksi

WHERE tanggal>=DATE_SUB(CURDATE(),INTERVAL 6 DAY)

GROUP BY DATE(tanggal)

ORDER BY DATE(tanggal)

");

$label=[];

$nilai=[];

while($row=fetch($dataGrafik)){

    $label[]=date("d/m",strtotime($row['tanggal']));

    $nilai[]=(int)$row['pendapatan'];

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1">

<title>Grafik Penjualan</title>

<link rel="stylesheet"
href="assets/css/style.css">

<link rel="stylesheet"
href="assets/css/grafik.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

<div class="container">

<?php include "components/sidebar.php"; ?>

<div class="content">

<?php include "components/navbar.php"; ?>

<div class="page-title">

<h2>

📈 Grafik Penjualan

</h2>

<p>

Pendapatan 7 hari terakhir

</p>

</div>

<div class="card">

<canvas id="grafikPenjualan"></canvas>

</div>

<div class="footer">

© <?= date("Y") ?>

<?= APP_NAME ?>

</div>

</div>

</div>

<script>

const labels=<?= json_encode($label) ?>;

const dataPendapatan=<?= json_encode($nilai) ?>;

</script>

<script src="assets/js/grafik.js"></script>

</body>

</html>