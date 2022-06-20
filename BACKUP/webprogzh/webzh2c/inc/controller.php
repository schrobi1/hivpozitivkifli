<?php
    ini_set('display_errors', 0);
    require_once 'DbService/Service.php';

	$response = array();

    if (isset($_POST['type'])) {
        switch ($_POST['type']) {
            case 0: Login(); break;
            case 1: Logout(); break;
            case 2: Registration(); break;

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
                $_SESSION["User"] = $_POST['Email'];
            }
        }
    }

    function Registration() {
        global $response;
        $db = new Service();
        
        if (IsSetAllParameter(array("Email", "Password", "Username"))) {
            //paramcheck TODO
			$regdata = $db->InsertUser($_POST['Email'], md5("Password123" . $_POST['Password']), $_POST['Username'], $_POST['Username'], 0, 0);
            if ($regdata == 0) {
                $response['error'] = false;
                $response['data'] = "Sikeres Regisztráció!";
            } else {
                $response['error'] = true;
                $response['data'] = "Sikertelen Regisztráció!";
            }
        }
    }

    function Logout() {
        $_SESSION["LoggedIn"] = false;
        session_destroy ();
        $response['error'] = false;
        $response['data'] = "Sikeres kijelentkezés!";
    }

    function IsSetAllParameter($Parameters) {
        foreach($Parameters as $Parameter) {
            if (!isset($_POST[$Parameter])) {
                Error("Invalid request: '" . $Parameter . "' parameter missing.", 1);
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
?>