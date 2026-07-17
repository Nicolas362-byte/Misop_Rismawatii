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