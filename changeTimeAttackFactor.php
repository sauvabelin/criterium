<?php
	/*
		file: 	changeTimeAttackFactor.php
		author: Christian Muller
	*/

include_once("globals.php");
include_once("sql.php");      


// connection à la base de donnée
connect();


// on récupère le facteur:
$timeAttackFactor 	= getTimeAttackFactor();

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		
		// on affiche un formulaire avec les champs déja remplis avec les champs actuels		
		echo '<form action="changeTimeAttackFactorDone.php" method="post">';
		
		echo 'Les temps du contre la montre seront multipliés par  ';
		echo '<input type="text" name="timeAttackFactor" id="timeAttackFactorId" value="'.$timeAttackFactor.'" size="2">';
		echo ' dans le calcul des résultats<br>';
		
		echo '<input type="Submit" value="MODIFIER">';
		echo '</form>';
		
		displayFooter();
		
		?>
		
	</body>
</html>