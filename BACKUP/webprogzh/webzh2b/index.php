<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Weblap - PHP</title>
	<link rel="stylesheet" href="res/style.css">
</head>
<body>
	
	<!-- 1. feladat -->
	
	<header>
		<?php
		$time1 = 4;
		$time2 = 12;
		$time3 = 20;
		
		$now = (int)date('H');
		$text = 'Kellemes estét';
		
		if($now < $time3 && $now >= $time2){
			$text = 'Szép napot';
		};
		if($now > $time1 && $now < $time2){
			$text = 'Jó reggelt';
		
			
		};
		echo 
		'<p>'. $text .'</p>';
	
		
		
		
		?>
	</header>
	
	<!-- Vége: 1. feladat -->
	
	<nav>
	<?php
	$file = "files/navigation.txt";
	$navs = file($file);
	$count = count($navs);
	
	
	for($i = 0; $i < $count ;$i++){
		$nav = $navs[$i];
	
	echo'<li>
				'.$nav.'
				<a href="index.php?page='.$i.'">Részletek</a>
			</li>';
			};
	
		?>
	</nav>
	
	<main>
		
		<!-- 3. feladat (ide kerüljön) -->
		<?php
		$page = 'home';
		if(isset($_GET['page'])){
			$page = $_GET['page'];
		}
		$file = "files/content-".$page.".php";
		if(is_file($file)){
			include $file;
		}
		
		?>
		
		
		<!-- 4-5. feladat -->
		
		<section>
			<?php
			if(isset($_GET['page'])){
			
		
		echo	'<h1>'.$title.'</h1>

			<p>'.$content.'</p>';
			}else{
				include "files/content-0.php";
				echo	'<h1>'.$title.'</h1>

			<p>'.$content.'</p>';
			}
			
			?>
		</section>
		
		
		<!-- Vége: 4-5. feladat -->
		
	</main>
	
</body>
</html>