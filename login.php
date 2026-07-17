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