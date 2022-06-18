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
			$stmt = $this->con->prepare("SELECT `topicName` FROM `news` WHERE 1 GROUP BY `topicName` ORDER BY `id` DESC LIMIT 4;");
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

		function ChangeUsername($Username, $Id){
			$stmt = $this->con->prepare("UPDATE `users` SET `username`=? WHERE `id` = ?;");
			$stmt->bind_param("si", $Username,$Id);
			$Error = !$stmt->execute();
			if ($Error) {
				return $stmt->error;
			} else {
				return 0;
			}
		}

		function ChangePassword($Pass, $Id){
			$stmt = $this->con->prepare("UPDATE `users` SET `pwd`=? WHERE `id` = ?;");
			$stmt->bind_param("si", $Pass,$Id);
			$Error = !$stmt->execute();
			if ($Error) {
				return $stmt->error;
			} else {
				return 0;
			}
		}

		function ChangePubname($Pubname, $Id){
			$stmt = $this->con->prepare("UPDATE `users` SET `pubname`=? WHERE `id` = ?;");
			$stmt->bind_param("si", $Pubname,$Id);
			$Error = !$stmt->execute();
			if ($Error) {
				return $stmt->error;
			} else {
				return 0;
			}
		}

		function CreateNews($Userid, $Newname, $topicName, $ShortPost,$Post,$datum){
			$stmt = $this->con->prepare("INSERT INTO `news`(`userId`, `newsName`, `topicName`, `ShortPost`, `Post`, `datum`) VALUES (?,?,?,?,?,?);");
			$stmt->bind_param("isssss", $Userid, $Newname, $topicName, $ShortPost,$Post,$datum);
			$Error = !$stmt->execute();
			if ($Error) {
				return $stmt->error;
			} else {
				return 0;
			}
		}
    }
?>