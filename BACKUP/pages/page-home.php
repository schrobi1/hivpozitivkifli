<?php
    $db = new Service();
    $News = $db->GetMainPageNews();

    echo '<main>';

    foreach($News as &$New) {
        echo '
        <h2>' . $New["newsName"] . " (" . $New["topicName"] . ")" . '</h2>
        <p>
        ' . $New["ShortPost"] . '
        </p>
            <div class="CikkLink">
                <a href="" name="' . $New["id"] . '">Részletek</a>
            </div>
        <div class="csik"></div>
        ';
    }

    echo '<div class="hir"></div><div class="inside"></div></main>';
?>