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