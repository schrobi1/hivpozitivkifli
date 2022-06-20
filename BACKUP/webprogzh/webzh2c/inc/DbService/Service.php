<?php
    class Service{
		public $con;
		
		function __construct(){
			require_once dirname(__FILE__).'/DBConnect.php';
			$db = new DBConnect();
			$this->con = $db->connect();
		}


        function GetUserByEmail($Email){
			$stmt = $this->con->prepare("SELECT * FROM `users` WHERE `email` = ?;");
			$stmt->bind_param("s", $Email);
			$stmt->execute();
			$array = $stmt->get_result();
			$dbdata = array();
			while ( $row = $array->fetch_assoc())  {
				$dbdata[]=$row;
            }
		    return $dbdata[0];
		}

		function InsertUser($Email, $Psw, $Username, $PubName, $Level, $Eula){
			$stmt = $this->con->prepare("INSERT INTO `users`(`pwd`, `email`, `username`, `pubname`, `level`, `eula`) VALUES (?,?,?,?,?,?);");
			$stmt->bind_param("ssssii", $Psw, $Email,$Username, $PubName, $Level, $Eula);
			$Error = !$stmt->execute();
			if ($Error) {
				return $stmt->error;
			} else {
				return 0;
			}
		}
    }
?>