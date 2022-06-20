<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Híroldal</title>
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="Bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand">Híroldal</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <ul class="nav nav-tabs ms-5">
                <li class="nav-item">
                    <a class="nav-link <?php if(!isset($_GET["page"])) {echo "active";} ?>" aria-current="page" href="?">Főoldal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "belfold") {echo "active";} ?>" href="?page=belfold">Belföld</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "kulfold") {echo "active";} ?>" href="?page=kulfold">Külföld</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "sport") {echo "active";} ?>" href="?page=sport">Sport</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "tudomany") {echo "active";} ?>" href="?page=tudomany">Tudomány</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "tech") {echo "active";} ?>" href="?page=tech">Tech</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "politika") {echo "active";} ?>" href="?page=politika">Politika</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if(isset($_GET["page"]) and $_GET["page"] == "pletyka") {echo "active";} ?>" href="?page=pletyka">Pletyka</a>
                </li>
            </ul>

            <div class="collapse navbar-collapse flex-grow-1 text-right" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto flex-nowrap">
                    <?php
                        if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
                            if ($_SESSION["Level"]==1) {
                                echo '<li class="nav-item dropdown dropstart">
                                <a class="nav-link dropdown-toggle dropdown-min" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ' . $_SESSION["User"] . '
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" id="SettingsButton" onclick="showSettingsForm()"><i class="bi bi-gear-fill"></i> Beállítások</a></li>
                                    <li><a class="dropdown-item" id="SettingsButton" onclick="NewArticle()"><i class="bi bi-pencil"></i> Új cikk írása</a></li>
                                    <li><a class="dropdown-item" id="SettingsButton" onclick="showUsers()"><i class="bi bi-person-fill"></i> Felhasználók</a></li>
                                    <li><a class="dropdown-item" id="LogOutButton" onclick="logOut()"><i class="bi bi-box-arrow-right"></i> Kijelentkezés</a></li>
                                </ul>
                            </li>';
                            } else {
                                echo '<li class="nav-item dropdown dropstart">
                                <a class="nav-link dropdown-toggle dropdown-min" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    ' . $_SESSION["User"] . '
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" id="SettingsButton" onclick="showSettingsForm()"><i class="bi bi-gear-fill"></i> Beállítások</a></li>
                                    <li><a class="dropdown-item" id="LogOutButton" onclick="logOut()"><i class="bi bi-box-arrow-right"></i> Kijelentkezés</a></li>
                                </ul>
                            </li>';
                            }
                        } else {
                            echo '<button type="button" class="btn btn-outline-secondary pull-right" onclick="ShowLoginForm()">Bejelentkezés</button>';
                        }
                    ?>
                    
                    
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">
        <div class="row">
            <div class="col-8">
                <div id="NewsList" class="row justify-content-md-center">

                    <?php
                        $db = new Service();
                        

                        if (isset($_GET["page"])) {
                            LoadByCategory();
                        } else {
                            LoadMainPage();
                        }

                        function LoadMainPage() {
                            global $db;
                            $News = $db->GetMainPageNews();

                            foreach($News as &$New) {
                                echo '
                                <div class=col>
                                    <div class="card">
                                        <h5 class="card-header">' . $New["topicName"] . '</h5>
                                        <div class="card-body">
                                            <h5 class="card-title">' . $New["newsName"] . '</h5>
                                            <p class="card-text">' . $New["ShortPost"] . '</p>
                                            <a onclick="ShowNews(' . $New["id"] . ')" class="btn btn-secondary">Részletek</a>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }

                        function LoadByCategory() {
                            global $db;
                            $News = $db->GetTopicNews($_GET['page']);

                            foreach($News as &$New) {
                                echo '
                                <div class=col>
                                    <div class="card">
                                        <h5 class="card-header">' . $New["topicName"] . '</h5>
                                        <div class="card-body">
                                            <h5 class="card-title">' . $New["newsName"] . '</h5>
                                            <p class="card-text">' . $New["ShortPost"] . '</p>
                                            <a onclick="ShowNews(' . $New["id"] . ')" class="btn btn-secondary">Részletek</a>
                                        </div>
                                    </div>
                                </div>
                                ';
                            }
                        }
                    ?>
                </div>
            </div>

            <div class="col">
                <div class="accordion">
                    <?php
                        $db = new Service();
                        $Topics = $db->GetTopics();
                        foreach($Topics as &$Topic) {
                            $News = $db->Getfirst4ByTopic($Topic["topicName"]);
                            echo '
                                <div class="accordion-item">
                                <h2 class="accordion-header" id="' . $Topic["topicName"] . '_accordionHeader">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#' . $Topic["topicName"] . '_accordionCollapse" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    ' . $Topic["topicName"] . '
                                </button>
                                </h2>
                                <div id="' . $Topic["topicName"] . '_accordionCollapse" class="accordion-collapse collapse show" aria-labelledby="' . $Topic["topicName"] . '_accordionHeader">
                                <div class="accordion-body">
                                <ul class="list-group list-group-flush">
                            ';

                            foreach($News as &$New) {
                                echo '<a onclick="ShowNews(' . $New["id"] . ')" class="list-group-item">' . $New["newsName"] . '</a>';
                            }

                            echo '  </ul>
                            </div>
                            </div>
                        </div>';
                        }

                    ?>
            </div>
        </div>
    </div>



    <div class="modal fade" id="LoginForm" tabindex="-1" aria-labelledby="LoginFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="LoginFormLabel">Bejelentkezés</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="EmailInput" class="form-label">Email:</label>
                        <input type="text" class="form-control" id="EmailInput">
                    </div>
                    <div class="mb-3">
                        <label for="JelszoInput" class="form-label">Jelszó:</label>
                        <input type="password" class="form-control" id="JelszoInput">
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary" id="LogButton">Bejelentkezés</button>
                    </div>
                    <div id="LoginErrorPlaceholder">
                            
                    </div>
                    <p class="small fw-bold mt-2 pt-1 mb-0">Nincsen regisztrálva? <a class="link-danger" href id="ShowRegForm">Regisztráljon!</a></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="RegForm" tabindex="-1" aria-labelledby="RegFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RegFormLabel">Regisztrálás</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="UserInput" class="form-label">Felhasználónév:</label>
                <input type="text" class="form-control" id="UserInput">
            </div>
            <div class="mb-3">
                <label for="EmailRInput" class="form-label">Email:</label>
                <input type="text" class="form-control" id="EmailRInput">
            </div>
            <div class="mb-3">
                <label for="JelszoRInput" class="form-label">Jelszó:</label>
                <input type="password" class="form-control" id="JelszoRInput">
            </div>
            <div class="mb-3">
                <label for="JelszoCoInput" class="form-label">Jelszó mégegyszer:</label>
                <input type="password" class="form-control" id="JelszoCoInput">
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="EULACheck">
                    <label class="form-check-label" for="EULACheck">
                        Elfogadom az EULA-t:
                    </label>
                </div>
            </div>
            <div id="RegErrorPlaceholder">
                        
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-primary" id="RegButton">Regisztrálás</button>
            </div>
            
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="SettingaForm" tabindex="-1" aria-labelledby="SettingaFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="SettingaFormLabel">Beállítások</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="input-group mb-3">
                    <label class="input-group-text" for="ChUsername">Felhasználónév:</label>
                    <input type="text" class="form-control" placeholder="Felhasználónév" aria-label="Felhasználónév" aria-describedby="ChangeUSername" id="ChUsername">
                    <button class="btn btn-outline-secondary" type="button" id="ChangeUSername">Módosít</button>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="ChPass1">Jelszó:</label>
                    <input type="password" class="form-control" placeholder="Jelszó" aria-label="Jelszó" aria-describedby="ChangePassword" id="ChPass1">
                    <input type="password" class="form-control" placeholder="Jelszó Újra" aria-label="Jelszó Újra" aria-describedby="ChangePassword" id="ChPass2">
                    <button class="btn btn-outline-secondary" type="button" id="ChangePassword">Módosít</button>
                </div>
                <?php
                    if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"] && $_SESSION["Level"]==1) {
                        echo '<div class="input-group mb-3">
                        <label class="input-group-text" for="ChPName">Publikációs név:</label>
                        <input type="text" class="form-control" placeholder="Publikációs név" aria-label="Publikációs név" aria-describedby="ChangePName" id="ChPName">
                        <button class="btn btn-outline-secondary" type="button" id="ChangePName">Módosít</button>
                        </div>';
                    }
                ?>
                    <div id="ChangeErrorPlaceholder">
                            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NewsPopup" tabindex="-1" aria-labelledby="NewsPopupLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="NewsPopupLabel">Betöltés...</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="NewsDetails"></p>
                <p id="News"></p>

                <?php 
                    if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]) {
                        echo '
                        <div class="WriteComment">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="ChUsername">Hozzászólás írása:</label>
                            <input type="text" class="form-control" placeholder="Hozzászólás" aria-label="Hozzászólás" aria-describedby="SendComment" id="CommentInput">
                            <button class="btn btn-outline-secondary" type="button" id="SendComment">Küldés</button>
                        </div>
                        </div>
                        ';
                    }
                ?>
                
                <div id="Comments"></div>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NewsWrite" tabindex="-1" aria-labelledby="NewsWriteLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="NewsWriteLabel">Cikk Írása</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="mb-3">
                <label for="NewsTitleInput" class="form-label">Cikk címe:</label>
                <input type="email" class="form-control" id="NewsTitleInput">
            </div>
            <div class="mb-3">
                <label for="NewsShortInput" class="form-label">Cikk összefogaló:</label>
                <input type="email" class="form-control" id="NewsShortInput">
            </div>
            <div class="mb-3">
                <label for="NewsInput" class="form-label">Cikk:</label>
                <textarea class="form-control" id="NewsInput" rows="10"></textarea>
            </div>
            <select class="form-select" id="NewsCategoryInput">
                <option value="Belföld" selected>Belföld</option>
                <option value="Külföld">Külföld</option>
                <option value="Sport">Sport</option>
                <option value="Tudomány">Tudomány</option>
                <option value="Tech">Tech</option>
                <option value="Politika">Politika</option>
                <option value="Pletyka">Pletyka</option>
            </select>
            <div id="SendErrorPlaceholder">
                            
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="NewArticleSave">Mentés</button>
             </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="UsersForm" tabindex="-1" aria-labelledby="UsersFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="UsersFormLabel">Felhasználók</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="bg-white shadow"><div class="table-responsive mb-4"><table class="table table-striped table-hover table-bordered m-0" id="UsersTable"><tr><td>Betöltés...</td></tr></table></div></div>
                </div>
            </div>
        </div>
    </div>

    

    <script src="Jquery/jquery-3.6.0.min.js"></script>
    <script src="Bootstrap/bootstrap.min.js"></script>
    
    <script src="script.js"></script>
</body>

</html>