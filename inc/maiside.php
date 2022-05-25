<div class="maiside">
    <?php
        $page = "home";
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
        }        
        $file = "pages/page-". $page .".php";        
        if(is_file($file)) {
            include $file;
        } else {
            echo '<h1>A kért lap nem található</h1>';
        }
    ?>
    <aside>
        <section>
            <h2>Téma címe 1</h2>
            <ul>
                <li><a href="index.html">Cikk címe 1</a></li>
            </ul>
        </section>
    </aside>
</div>