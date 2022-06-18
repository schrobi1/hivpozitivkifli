<?php
    //$db = new Service();
   // $News = $db->GetMainPageNews();

    echo 
        '<main>
            <div class="cikkkeszito">
                <label for="cikkname">Cikk címe:</label><br>
                <input type="text" id="cikkname" name="cikkname"><br>
                <label for="Eloszo" cols="100">Előszó:</label><br>
                <input type="text" id="Eloszo" name="Eloszo"><br>
                <label for="Cikktext">Cikk:</label><br>
                <textarea id="Cikktext" name="Cikktext" rows="20">Alma</textarea><br>
                <div class="temavalaszt">
                    <label for="tema0">Belföld</label>
                    <input type="radio" id="tema0" name="tema" checked="checked" value="Belföld">                
                    <label for="tema1">Külföld</label>
                    <input type="radio" id="tema1" name="tema" value="Külföld">
                    <label for="tema2">Sport</label>
                    <input type="radio" id="tema2" name="tema" value="Sport">
                    <label for="tema3">Tudomány</label>
                    <input type="radio" id="tema3" name="tema" value="Tudomány">
                    <label for="tema4">Tech</label>
                    <input type="radio" id="tema4" name="tema" value="Tech">                
                </div>
                <br>
                <button class="publikal">Publikáció</button>
            </div>
            <div class="hir"></div>
            <div class="inside"></div>
        </main><script src="log_reg/view/create.js"></script>';
?>