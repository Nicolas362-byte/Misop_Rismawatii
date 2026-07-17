
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
<?php

include "includes/config.php";

/*==========================================
    CEK LOGIN
==========================================*/

if(isset($_SESSION['login'])){

    header("Location: dashboard.php");

}else{

    header("Location: login.php");

}

exit;

?>
<?php

include "includes/config.php";

cekLogin();

// ===============================
// AMBIL DATA MENU
// ===============================

$menu = query("
SELECT *
FROM menu
WHERE stok > 0
ORDER BY kategori,nama
");

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kasir</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel="stylesheet" href="assets/css/kasir.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="container">

<?php include "components/sidebar.php"; ?>

<div class="content">

<?php include "components/navbar.php"; ?>

<div class="page-title">

<h2>💳 Kasir</h2>

<p>Silakan pilih menu yang akan dipesan.</p>

</div>

<form
action="proses/simpan_transaksi.php"
method="POST"
id="formKasir">

<div class="kasir-container">

<!-- ===================================
     MENU
=================================== -->

<div class="menu-area">

<?php while($m = fetch($menu)): ?>

<div
class="menu-card"
data-id="<?= $m['id'] ?>"
data-nama="<?= e($m['nama']) ?>"
data-harga="<?= $m['harga'] ?>"
data-stok="<?= $m['stok'] ?>">

<img
src="<?= gambarMenu($m['gambar']) ?>"
alt="<?= e($m['nama']) ?>">

<h4><?= e($m['nama']) ?></h4>

<p><?= e($m['kategori']) ?></p>

<h3><?= rupiah($m['harga']) ?></h3>

<span>

Stok :
<?= angka($m['stok']) ?>

</span>

<button
type="button"
class="btn btn-primary tambah">

Tambah

</button>

</div>

<?php endwhile; ?>

</div>

<!-- ===================================
     KERANJANG
=================================== -->

<div class="cart-area">

<h3>

🛒 Keranjang

</h3>

<div id="cartList">

<p class="empty">

Belum ada menu dipilih.

</p>

</div>

<hr>

<!-- ===================================
     CUSTOMER
=================================== -->

<div class="form-group">

<label>

Nama Customer

</label>

<input
type="text"
name="customer"
id="customer"
placeholder="Masukkan nama customer"
required>

</div>

<!-- ===================================
     METODE PEMBAYARAN
=================================== -->

<div class="form-group">

<label>

Metode Pembayaran

</label>

<select
name="metode"
id="metode"
required>

<option value="Tunai">

💵 Tunai

</option>

<option value="QRIS">

📱 QRIS

</option>

</select>

</div>

<hr>

<!-- ===================================
     RINGKASAN BELANJA
=================================== -->

<div class="total-box">

    <div>

        <span>Subtotal</span>

        <span id="subtotalText">Rp 0</span>

    </div>

    <div>

        <span>Diskon</span>

        <span id="diskonText">Rp 0</span>

    </div>

    <div>

        <span>Pajak (10%)</span>

        <span id="pajakText">Rp 0</span>

    </div>

    <div class="grand-total">

        <strong>Total</strong>

        <strong id="totalText">Rp 0</strong>

    </div>

</div>

<hr>

<!-- ===================================
     PEMBAYARAN
=================================== -->

<div class="form-group">

    <label>Bayar</label>

    <input

        type="number"

        name="bayar"

        id="bayar"

        min="0"

        placeholder="Masukkan nominal pembayaran"

        required>

</div>

<div class="form-group">

    <label>Kembalian</label>

    <input

        type="text"

        id="kembalian"

        value="Rp 0"

        readonly>

</div>

<!-- ===================================
     HIDDEN INPUT
=================================== -->

<input
type="hidden"
name="subtotal"
id="subtotal">

<input
type="hidden"
name="diskon"
id="diskon">

<input
type="hidden"
name="pajak"
id="pajak">

<input
type="hidden"
name="total"
id="total">

<input
type="hidden"
name="cart"
id="cartData">

<button

type="submit"

class="btn btn-primary w-100"

id="btnSimpan">

<i class="fa-solid fa-floppy-disk"></i>

Simpan Transaksi

</button>

</div>

</div>

</form>

<!-- ===================================
        MODAL QRIS
=================================== -->

<div
id="qrisModal"
class="qris-modal"
style="display:none;">

<div class="qris-content">

<h2>

Pembayaran QRIS

</h2>

<p class="merchant">

Kedai Misop Nde Tigan

</p>

<img

src="assets/img/Qris.png"

alt="QRIS"

class="qris-image">

<div class="qris-total">

Total Pembayaran

<h3 id="totalQris">

Rp 0

</h3>

</div>

<div class="timer-box">

Sisa Waktu

<h1 id="timerQris">

01:00

</h1>

</div>

<p class="status-qris">

Silakan scan QR Code menggunakan

Mobile Banking atau E-Wallet.

</p>

<div class="qris-button">

<button

type="button"

class="btn btn-success"

id="btnKonfirmasi">

<i class="fa-solid fa-circle-check"></i>

Saya Sudah Menerima Pembayaran

</button>

<button

type="button"

class="btn btn-danger"

id="btnBatal">

<i class="fa-solid fa-xmark"></i>

Batalkan

</button>

</div>

</div>

</div>

<!-- ===============================
     FOOTER
================================ -->

<div class="footer">

© <?= date("Y") ?>

<?= APP_NAME ?>

</div>

</div>

</div>

<!-- ===============================
     JAVASCRIPT
================================ -->

<script src="assets/js/kasir.js"></script>

</body>

</html>
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
<?php

include "includes/config.php";

// Jika sudah login langsung ke dashboard
if(isset($_SESSION['login'])){
    redirect("dashboard.php");
}

// Proses Login
if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']);

    $query = query("
        SELECT *
        FROM user
        WHERE username='$username'
        AND password='$password'
    ");

    if(rows($query)>0){

        $user = fetch($query);

        $_SESSION['login'] = true;
        $_SESSION['id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        redirect("dashboard.php");

    }else{

        setFlash("Username atau Password salah!","danger");

    }

}

?>

<!DOCTYPE html>

<html lang="id">

<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login | <?= APP_NAME ?></title>

<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/login.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

</head>

<body>

<div class="login-container">

    <div class="login-box">

    <div class="login-logo">

        <img src="assets/logo.png" alt="Logo Kedai">

    </div>

    <h2>Kedai Misop Nde Tigan</h2>

    <p>Silakan login untuk melanjutkan</p>

        <?php tampilFlash(); ?>

        <form method="POST">

            <div class="form-group">

                <label>Username</label>

                <input
                type="text"
                name="username"
                placeholder="Masukkan Username"
                required>

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                type="password"
                name="password"
                placeholder="Masukkan Password"
                required>

            </div>

            <button
            class="btn btn-primary w-100"
            type="submit"
            name="login">

                <i class="fa-solid fa-right-to-bracket"></i>

                Login

            </button>

        </form>

    </div>

</div>

</body>

</html>
<?php

session_start();

session_unset();

session_destroy();

header("Location: index.php");

exit;

?>
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
