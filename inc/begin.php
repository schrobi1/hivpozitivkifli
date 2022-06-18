<!DOCTYPE html>
<html>
	<head>
		<title>Cím</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<header>
			<div class="cimsav">
				<nav>
					<ul>
						<?php PrintMenu(); ?>
					</ul>
				</nav>
				<?php

					if(isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]){
						echo '<button class="btn">' . $_SESSION["User"] . '</button>';
					} else {
						echo '<button class="btn">Bejelentkezés</button>';
					}
				?>
				
				<?php
					if (isset($_SESSION["LoggedIn"]) && $_SESSION["LoggedIn"]){
						if ($_SESSION["Level"] == 1) {
							echo '<div class="dropdown">
							<button class="dropbtn"><img src="Ikonok\hamburger_button.png"></button>
							<div class="dropdown-content">
								<a href="index.php?mode=datas">Adatmódósítás</a>
								<a href="index.php?mode=create">Cikk írás</a>
								<a href="index.php?mode=editing">Cikkek szerkesztése</a>
								
								<a id="logoutButton">Kilépés</a>
							</div>
						</div>';
						} else {
							echo '<div class="dropdown">
							<button class="dropbtn"><img src="Ikonok\hamburger_button.png"></button>
							<div class="dropdown-content">
								<a href="index.php?mode=datas">Adatmódósítás</a>
								
								<a id="logoutButton">Kilépés</a>
							</div>
						</div>';
						}
					}
				?>

				
			</div>
		</header>