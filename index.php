<?php


    session_start();
	mb_internal_encoding("UTF-8");
   // session_destroy();
    
	require_once 'inc/DbService/Service.php';

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        include "inc/controller.php";
    } else {
        include "inc/mainpage.php";
    }
?>		