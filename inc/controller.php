<?php
    ini_set('display_errors', 0);

	$response = array();

    if (isset($_POST['type'])) {
        switch ($_POST['type']) {
            case 0: Login(); break;
            case 1: Logout(); break;
            case 2: Registration(); break;
            case 3: GetNews(); break;

            case 4: ChangeUsername(); break;
            case 5: ChangePass(); break;
            case 6: ChangePubName(); break;

            case 7: CreateNews(); break;

            case 8: GetUserInfo(); break;

            case 9: InserComment(); break;
            case 10: GetComments(); break;

            case 11: GetUsers(); break;
            case 12: SetPermissionLevel(); break;

            default: Error("Invalid request: 'type'=" . $_POST['type'] . " does not exist."); break;
        }
    } else {
        Error("Invalid request: 'type' parameter missing.");
    }

    echo json_encode($response, JSON_UNESCAPED_UNICODE);





    function Login() {
        global $response;
        $db = new Service();
        
        if (IsSetAllParameter(array("Email", "Password"))) {
            
			$logindata = $db->GetUserByEmail($_POST['Email']);
            if (empty($logindata) or md5("Password123" . $_POST['Password']) != $logindata["pwd"]) {
                Error("Hibás felhasználónév vagy jelszó.");
            } else {
                $response['error'] = false;
                $response['data'] = "Sikeres bejelentkezés!";
                $_SESSION["LoggedIn"] = true;
                $_SESSION["User"] = $logindata['username'];
                $_SESSION["PName"] = $logindata['pubname'];
                $_SESSION["Level"] = $logindata['level'];
                $_SESSION["Id"] = $logindata['id'];
            }
        }
    }

    function Registration() {
        global $response;
        $db = new Service();
        
        if (IsSetAllParameter(array("Email", "Password", "Username")) and IsParametersNotEmpty(array("Email", "Password", "Username"))) {
            $users = $db->GetUserByEmail($_POST['Email']);
            if (!empty($users)) {
                Error("Ez az email már regisztrálva van");
            } else {
                $regdata = $db->InsertUser($_POST['Email'], md5("Password123" . $_POST['Password']), $_POST['Username'], $_POST['Username'], 0, date("Y-m-d H:i:s"));
                if ($regdata == 0) {
                    $response['error'] = false;
                    $response['data'] = "Sikeres Regisztráció!";
                } else {
                    $response['error'] = true;
                    $response['data'] = "Sikertelen Regisztráció!";
                }
            }
        }
    }

    function Logout() {
        $_SESSION["LoggedIn"] = false;
        session_destroy ();
        $response['error'] = false;
        $response['data'] = "Sikeres kijelentkezés!";
    }

    function GetNews() {
        global $response;
        $db = new Service();
        
        if (IsSetAllParameter(array("id"))) {
			$news = $db->GetNewsById($_POST['id']);
            if (empty($news)) {
                $response['error'] = true;
                $response['data'] = "Hír nem található!";
            } else {
                $response['error'] = false;
                $response['data'] = $news;
            }
        }
    }

    function ChangeUsername() {
        global $response;

        $db = new Service();
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if (IsSetAllParameter(array("Username")) and IsParametersNotEmpty(array("Username"))) {
                $regdata = $db->ChangeUsername($_POST["Username"],$_SESSION["Id"]);
                if ($regdata == 0) {
                    $response['error'] = false;
                    $response['data'] = "Sikeres frissítés!";
                    $_SESSION["User"] = $_POST["Username"];
                } else {
                    $response['error'] = true;
                    $response['data'] = "Sikertelen frissítés!";
                }
            }
        } else {
                $response['error'] = true;
                $response['data'] = "Nem vagy bejelentkezve!";
        }
        
    }

    function ChangePass() {
        global $response;

        $db = new Service();
        
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if (IsSetAllParameter(array("Password")) and IsParametersNotEmpty(array("Password"))) {
                $regdata = $db->ChangePassword(md5("Password123" . $_POST['Password']),$_SESSION["Id"]);
                if ($regdata == 0) {
                    $response['error'] = false;
                    $response['data'] = "Sikeres frissítés!";
                } else {
                    $response['error'] = true;
                    $response['data'] = "Sikertelen frissítés!";
                }
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function ChangePubName() {
        global $response;

        $db = new Service();
        
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if ($_SESSION["Level"] == 1) {
                if (IsSetAllParameter(array("Pubname")) and IsParametersNotEmpty(array("Pubname"))) {
                    $regdata = $db->ChangePubname($_POST["Pubname"],$_SESSION["Id"]);
                    if ($regdata == 0) {
                        $response['error'] = false;
                        $response['data'] = "Sikeres frissítés!";
                    } else {
                        $response['error'] = true;
                        $response['data'] = "Sikertelen frissítés!";
                    }
                }
            } else {
                $response['error'] = true;
                $response['data'] = "Hozzáférés megtagadva";
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function CreateNews() {
        global $response;

        $db = new Service();
        
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if ($_SESSION["Level"] == 1) {
                if (IsSetAllParameter(array("Newname", "topicName","ShortPost","Post")) and IsParametersNotEmpty(array("Newname", "topicName","ShortPost","Post"))) {
                    $regdata = $db->CreateNews($_SESSION["Id"], $_POST["Newname"],$_POST["topicName"],$_POST["ShortPost"],$_POST["Post"], date("Y-m-d"));
                    if ($regdata == 0) {
                        $response['error'] = false;
                        $response['data'] = "Sikeres feltöltés!";
                    } else {
                        $response['error'] = true;
                        $response['data'] = "Sikertelen feltöltés!";
                    }
                }
            } else {
                $response['error'] = true;
                $response['data'] = "Hozzáférés megtagadva";
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function GetUserInfo() {
        global $response;
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            $Data = array();
            $Data["Username"] = $_SESSION["User"];
            $Data["PName"] = $_SESSION["PName"];

            $response['error'] = false;
            $response['data'] = $Data;
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function InserComment() {
        global $response;

        $db = new Service();
        
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if (IsSetAllParameter(array("NewsId", "Comment")) and IsParametersNotEmpty(array("NewsId", "Comment"))) {
                $regdata = $db->CreateComment($_POST["NewsId"],$_SESSION["Id"], $_POST["Comment"]);
                if ($regdata == 0) {
                    $response['error'] = false;
                    $response['data'] = "Sikeres közzététel!";
                } else {
                    $response['error'] = true;
                    $response['data'] = "Sikertelen közzététel!";
                }
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function GetComments() {
        global $response;
        $db = new Service();
        
        if (IsSetAllParameter(array("id"))) {
			$news = $db->GetCommentsByNewsId($_POST['id']);
            $response['error'] = false;
            $response['data'] = $news;
        }
    }

    function GetUsers() {
        global $response;
        $db = new Service();
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if ($_SESSION["Level"] == 1) {
                $users = $db->GetUsers();
                $response['error'] = false;
                $response['data'] = $users;
            } else {
                $response['error'] = true;
                $response['data'] = "Hozzáférés megtagadva";
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }

    function SetPermissionLevel() {
        global $response;

        $db = new Service();
        
        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
            if (IsSetAllParameter(array("UserId", "Level")) and IsParametersNotEmpty(array("UserId", "Level"))) {
                if ($_POST["UserId"] == $_SESSION["Id"]) {
                    $response['error'] = true;
                    $response['data'] = "Saját magadnak nem állíthatod a jogosultságot.";
                } else {
                    if ($_SESSION["Level"] == 1) {
                        $regdata = $db->SetPermLevel($_POST["UserId"], $_POST["Level"]);
                        if ($regdata == 0) {
                            $response['error'] = false;
                            $response['data'] = "Sikeresen frissítve!";
                        } else {
                            $response['error'] = true;
                            $response['data'] = "Sikertelen frissítés!";
                        }
                    } else {
                        $response['error'] = true;
                        $response['data'] = "Hozzáférés megtagadva";
                    }
                }
            }
        } else {
            $response['error'] = true;
            $response['data'] = "Nem vagy bejelentkezve!";
        }
    }






    function IsParametersNotEmpty($Parameters) {
        foreach($Parameters as $Parameter) {
            if ($_POST[$Parameter] == "") {
                Error("Érvénytelen adat: '" . $Parameter . "' nem lehet üres.");
                return false;
            }
        }
        return true;
    }

    function Error($ErrorString) {
		global $response;
		$response['error'] = true;
		$response['data'] = $ErrorString;
	}

    function IsSetAllParameter($Parameters) {
        foreach($Parameters as $Parameter) {
            if (!isset($_POST[$Parameter])) {
                Error("Invalid request: '" . $Parameter . "' parameter missing.");
                return false;
            }
        }
        return true;
    }
?>