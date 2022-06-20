<?php
    class DBConnect{
		
		private $con;
		
		function __construct() {
			
		}
		
		function connect() {
			include_once dirname(__FILE__).'/Constans.php';
			$this->con = new mysqli('localhost', 'root','', 'webprog2zh');
			if(mysqli_connect_errno()) {
				echo "Failed to connect with databade".mysqli_connect_err();
			}
			
			return $this->con;
		}
	}

?>