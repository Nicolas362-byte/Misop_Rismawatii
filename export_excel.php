<?php

include "includes/config.php";

cekLogin();

/*====================================
    FILTER
====================================*/

$tanggalAwal = $_GET['awal'] ?? "";
$tanggalAkhir = $_GET['akhir'] ?? "";

/*====================================
    QUERY
====================================*/

$sql = "SELECT * FROM transaksi";

if($tanggalAwal != "" && $tanggalAkhir != ""){

    $sql .= " WHERE DATE(tanggal)
              BETWEEN '$tanggalAwal'
              AND '$tanggalAkhir'";

}

$sql .= " ORDER BY tanggal DESC";

$data = query($sql);

/*====================================
    HEADER EXCEL
====================================*/

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Transaksi_".date("Ymd_His").".xls");

/*====================================
    OUTPUT
====================================*/

echo "<table border='1'>";

echo "<tr style='background:#198754;color:#ffffff;font-weight:bold;'>";

echo "<th>No</th>";
echo "<th>Kode</th>";
echo "<th>Tanggal</th>";
echo "<th>Customer</th>";
echo "<th>Kasir</th>";
echo "<th>Metode</th>";
echo "<th>Subtotal</th>";
echo "<th>Diskon</th>";
echo "<th>Pajak</th>";
echo "<th>Total</th>";
echo "<th>Bayar</th>";
echo "<th>Kembalian</th>";

echo "</tr>";

$no = 1;
$totalPendapatan = 0;

while($row = fetch($data)){

    $totalPendapatan += $row['total'];

    echo "<tr>";

    echo "<td>".$no++."</td>";
    echo "<td>".kodeTransaksi($row['id'])."</td>";
    echo "<td>".tanggalIndonesia($row['tanggal'])."</td>";
    echo "<td>".$row['customer']."</td>";
    echo "<td>".$row['kasir']."</td>";
    echo "<td>".$row['metode']."</td>";
    echo "<td>".$row['subtotal']."</td>";
    echo "<td>".$row['diskon']."</td>";
    echo "<td>".$row['pajak']."</td>";
    echo "<td>".$row['total']."</td>";
    echo "<td>".$row['bayar']."</td>";
    echo "<td>".$row['kembalian']."</td>";

    echo "</tr>";

}

echo "<tr>";

echo "<td colspan='9' align='right'><b>Total Pendapatan</b></td>";

echo "<td><b>".$totalPendapatan."</b></td>";

echo "<td colspan='2'></td>";

echo "</tr>";

echo "</table>";

exit;