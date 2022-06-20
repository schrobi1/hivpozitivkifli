<?php


session_start();
	mb_internal_encoding("UTF-8");

    
	

    if ($_SERVER['REQUEST_METHOD']=='POST') {
        include "inc/controller.php";
    } else {
        include "inc/functions.php";
        include "inc/begin.php";
        include "inc/maiside.php";
        include "inc/end.php";
    }

?>		