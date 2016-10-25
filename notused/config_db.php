<?php
session_start();
require_once("_kernel/dbclass.php");
require_once("_kernel/pagination.class.php");
/*ORM::configure('mysql:host=localhost;dbname=mynfmcom_beta');
ORM::configure('username', 'mynfmcom_beta');
ORM::configure('password', '7GC0YgpHB');*/
ORM::configure('mysql:host=localhost;dbname=mynfmcom');
ORM::configure('username', 'mynfmcom');
ORM::configure('password', 'X2f6j+yf');
/*
ORM::configure('mysql:host=localhost;dbname=mynfmcom');
ORM::configure('username', 'root');
ORM::configure('password', '');
*/
ORM::configure('return_result_sets', true);
ORM::configure('logging', true);
ORM::configure('logger', function($log_string, $query_time) {
    //echo $log_string . ' in ' . $query_time;
});
include("config_function.php");
include ("_kernel/class.image.php");
include ("_kernel/mail/PHPMailerAutoload.php");
$mail = new PHPMailer;
?>