<?php

include "../includes/config.php";

cekLogin();

if($_SERVER['REQUEST_METHOD']!="POST"){

    redirect("../kasir.php");

}

/*==========================================
    AMBIL DATA
==========================================*/

$customer = mysqli_real_escape_string($conn,$_POST['customer']);

$metode = mysqli_real_escape_string($conn,$_POST['metode']);

$subtotal = (int)$_POST['subtotal'];

$diskon = (int)$_POST['diskon'];

$pajak = (int)$_POST['pajak'];

$total = (int)$_POST['total'];

$cart = json_decode($_POST['cart'],true);

$kasir = $_SESSION['nama'];

/*==========================================
    VALIDASI KERANJANG
==========================================*/

if(empty($cart)){

    setFlash("Keranjang masih kosong.","danger");

    redirect("../kasir.php");

}

/*==========================================
    PEMBAYARAN
==========================================*/

if($metode=="Tunai"){

    $bayar = (int)$_POST['bayar'];

    if($bayar < $total){

        setFlash("Nominal pembayaran kurang.","danger");

        redirect("../kasir.php");

    }

    $kembalian = $bayar - $total;

}else{

    // QRIS

    $bayar = $total;

    $kembalian = 0;

}

/*==========================================
    MULAI TRANSAKSI
==========================================*/

mysqli_begin_transaction($conn);

/*==========================================
    SIMPAN TRANSAKSI
==========================================*/

$sql = "

INSERT INTO transaksi
(
tanggal,
customer,
kasir,
metode,
subtotal,
diskon,
pajak,
total,
bayar,
kembalian
)

VALUES
(
NOW(),
'$customer',
'$kasir',
'$metode',
'$subtotal',
'$diskon',
'$pajak',
'$total',
'$bayar',
'$kembalian'
)

";

if(!query($sql)){

    mysqli_rollback($conn);

    setFlash("Gagal menyimpan transaksi.","danger");

    redirect("../kasir.php");

}

$idTransaksi = mysqli_insert_id($conn);

/*==========================================
    SIMPAN DETAIL
==========================================*/

foreach($cart as $item){

    $idMenu = (int)$item['id'];

    $qty = (int)$item['qty'];

    $harga = (int)$item['harga'];

    $sub = $qty * $harga;

    $detail = "

    INSERT INTO detail_transaksi
    (
    transaksi_id,
    menu_id,
    qty,
    harga,
    subtotal
    )

    VALUES
    (
    '$idTransaksi',
    '$idMenu',
    '$qty',
    '$harga',
    '$sub'
    )

    ";

    if(!query($detail)){

        mysqli_rollback($conn);

        setFlash("Gagal menyimpan detail transaksi.","danger");

        redirect("../kasir.php");

    }

    $stok = "

    UPDATE menu
    SET stok = stok - $qty
    WHERE id = '$idMenu'

    ";

    if(!query($stok)){

        mysqli_rollback($conn);

        setFlash("Gagal mengurangi stok.","danger");

        redirect("../kasir.php");

    }

}

/*==========================================
    COMMIT
==========================================*/

mysqli_commit($conn);

redirect("../struk.php?id=".$idTransaksi);

?>