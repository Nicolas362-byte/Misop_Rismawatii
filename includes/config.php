<?php

/*==================================================
    KONFIGURASI SISTEM
    Kedai Misop Nde Tigan
==================================================*/

session_start();

date_default_timezone_set("Asia/Jakarta");

/*==================================================
    DATABASE
==================================================*/

define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","misop_kasir");

$conn=mysqli_connect(

    DB_HOST,
    DB_USER,
    DB_PASS,
    DB_NAME

);

if(!$conn){

    die("Koneksi Database Gagal : ".mysqli_connect_error());

}

/*==================================================
    BASE URL
==================================================*/

define("BASE_URL","http://localhost/misop_kasir/");

/*==================================================
    NAMA APLIKASI
==================================================*/

define("APP_NAME","Kasir Kedai Misop Nde Tigan");

/*==================================================
    FORMAT RUPIAH
==================================================*/

function rupiah($angka){

    return "Rp ".number_format($angka,0,",",".");

}

/*==================================================
    FORMAT ANGKA
==================================================*/

function angka($angka){

    return number_format($angka,0,",",".");

}

/*==================================================
    FORMAT TANGGAL INDONESIA
==================================================*/

function tanggalIndonesia($tanggal){

    $bulan=[

        1=>"Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember"

    ];

    $time=strtotime($tanggal);

    $hari=date("d",$time);

    $bln=$bulan[(int)date("m",$time)];

    $tahun=date("Y",$time);

    $jam=date("H:i",$time);

    return

    $hari." ".$bln." ".$tahun." ".$jam;

}

/*==================================================
    ESCAPE HTML
==================================================*/

function e($text){

    return htmlspecialchars(

        $text,

        ENT_QUOTES,

        "UTF-8"

    );

}

/*==================================================
    REDIRECT
==================================================*/

function redirect($url){

    header("Location:".$url);

    exit;

}

/*==================================================
    LOGIN CHECK
==================================================*/

function cekLogin(){

    if(

        !isset($_SESSION['login'])

    ){

        redirect(BASE_URL."login.php");

    }

}

/*==================================================
    FLASH MESSAGE
==================================================*/

function setFlash($pesan,$tipe="success"){

    $_SESSION['flash']=[

        "pesan"=>$pesan,

        "tipe"=>$tipe

    ];

}

function tampilFlash(){

    if(isset($_SESSION['flash'])){

        $flash=$_SESSION['flash'];

        echo '

        <div class="alert alert-'.$flash["tipe"].'">

            '.$flash["pesan"].'

        </div>

        ';

        unset($_SESSION['flash']);

    }

}

/*==================================================
    HITUNG PAJAK
==================================================*/

function hitungPajak($subtotal){

    return round($subtotal*0.10);

}

/*==================================================
    HITUNG DISKON
==================================================*/

function hitungDiskon($subtotal){

    if($subtotal>=100000){

        return round($subtotal*0.05);

    }

    return 0;

}

/*==================================================
    GENERATE KODE STRUK
==================================================*/

function kodeTransaksi($id){

    return "TRX-".date("Ymd")."-".str_pad(

        $id,

        5,

        "0",

        STR_PAD_LEFT

    );

}

/*==================================================
    CEK FILE GAMBAR
==================================================*/

function gambarMenu($gambar){

    $path="assets/img/".$gambar;

    if(file_exists($path)){

        return $path;

    }

    return "assets/img/menu/default.jpg";

}

/*==================================================
    QUERY HELPER
==================================================*/

function query($sql){

    global $conn;

    return mysqli_query($conn,$sql);

}

/*==================================================
    FETCH DATA
==================================================*/

function fetch($query){

    return mysqli_fetch_assoc($query);

}

/*==================================================
    JUMLAH DATA
==================================================*/

function rows($query){

    return mysqli_num_rows($query);

}

?>