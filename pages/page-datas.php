<?php
    //$db = new Service();
   // $News = $db->GetMainPageNews();

    if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"] && $_SESSION["Level"] == 1) {
        echo 
        '<main>
            <div class="adatmodositas">
                <h1>Felhasználónév módosítása</h1>
                <label for="newname">Új felhasználónév:</label>
                <input type="text" id="newname" name="newname">
                <button class="namechange">Módosítás</button>
                <br>
                <div class="csik"></div>
                <h1>Jelszó módosítása</h1>
                <label for="newpasswd">Új jelszó:</label>
                <input type="password" id="newpasswd" name="newpasswd">
                <button class="passwdchange">Módosítás</button>
                <br>
                <div class="csik"></div>
                <h1>Publikációsnév megadása/módosítása</h1>
                <label for="newpubname">Új publikációsnév:</label>
                <input type="text" id="newpubname" name="newpubname">
                <button class="pubnamechange">Létrehozás</button>
            </div>
            <div class="hir"></div>
            <div class="inside"></div>
        </main><script src="log_reg/view/datas.js"></script>';
    } else if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
        echo 
        '<main>
            <div class="adatmodositas">
                <h1>Felhasználónév módosítása</h1>
                <label for="newname">Új felhasználónév:</label>
                <input type="text" id="newname" name="newname">
                <button class="namechange">Módosítás</button>
                <br>
                <div class="csik"></div>
                <h1>Jelszó módosítása</h1>
                <label for="newpasswd">Új jelszó:</label>
                <input type="text" id="newpasswd" name="newpasswd">
                <button class="passwdchange">Módosítás</button>
                <br>
            
            </div>
            <div class="hir"></div>
            <div class="inside"></div>
        </main><script src="log_reg/view/datas.js"></script>';
    } else {
        echo "Nem vagy belépve!";
    }

    
?>