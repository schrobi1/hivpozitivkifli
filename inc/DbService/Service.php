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

		function GetMainPageNews(){
			$stmt = $this->con->prepare("SELECT `id`, `newsName`, `topicName`, `ShortPost` FROM `news` WHERE 1 ORDER BY `id` DESC LIMIT 5;");
			$stmt->execute();
			$array = $stmt->get_result();
			$dbdata = array();
			while ( $row = $array->fetch_assoc())  {
				$dbdata[]=$row;
            }
		    return $dbdata;
		}

		function GetTopicNews($Topic){
			$stmt = $this->con->prepare("SELECT `id`, `newsName`, `topicName`, `ShortPost` FROM `news` WHERE `topicName` = ? ORDER BY `id` DESC LIMIT 20;");
			$stmt->bind_param("s", $Topic);
			$stmt->execute();
			$array = $stmt->get_result();
			$dbdata = array();
			while ( $row = $array->fetch_assoc())  {
				$dbdata[]=$row;
            }
		    return $dbdata;
		}

		function GetTopics(){
			$stmt = $this->con->prepare("SELECT `topicName` FROM `news` WHERE 1 GROUP BY `topicName`;");
			$stmt->execute();
			$array = $stmt->get_result();
			$dbdata = array();
			while ( $row = $array->fetch_assoc())  {
				$dbdata[]=$row;
            }
		    return $dbdata;
		}

		function Getfirst2ByTopic($Topic){
			$stmt = $this->con->prepare("SELECT `id`, `newsName` FROM `news` WHERE `topicName` = ? ORDER BY `id` DESC LIMIT 2;");
			$stmt->bind_param("s", $Topic);
			$stmt->execute();
			$array = $stmt->get_result();
			$dbdata = array();
			while ( $row = $array->fetch_assoc())  {
				$dbdata[]=$row;
            }
		    return $dbdata;
		}

		function GetNewsById($Id){
			$stmt = $this->con->prepare("SELECT `news`.*,`users`.`pubname`  FROM `news` INNER JOIN `users` ON `users`.`id` = `news`.`userId` WHERE `news`.`id` = ?;");
			$stmt->bind_param("i", $Id);
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