<div class="maiside">
    <?php
        if(isset($_GET['page'])) {
            $file = "pages/page-bytopic.php";        
            if(is_file($file)) {
                include $file;
            }
        } else {
            $file = "pages/page-home.php";        
            if(is_file($file)) {
                include $file;
            }
        }
    ?>
    <aside>
        <?php
            $db = new Service();
            $Topics = $db->GetTopics();
            foreach($Topics as &$Topic) {
                $News = $db->Getfirst2ByTopic($Topic["topicName"]);
                echo '
                <section>
                    <h2>' . $Topic["topicName"] . '</h2>';

                    foreach($News as &$New) {
                        echo '<ul>
                        <li><a href="?id=' . $New["id"] . '">' . $New["newsName"] . '</a></li>
                        </ul>';
                    }
                    
                echo '</section>';
            }
        ?>
        
    </aside>
</div>