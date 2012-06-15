<?php
	/*
		file: 	changeMinimalYear.php
		author: Benoît Uffer
		
	*/

include_once("globals.php");
include_once("sql.php");      


// connection à la base de donnée
connect();


// on récupère l'année minimale actuelle:
$minYear = getMinimalYear();

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		
		// on affiche un formulaire avec les champs déja remplis avec les champs actuels		
		echo '<form action="changeMinimalYearDone.php" method="post">';
		echo 'les gars et fille nés AVANT ';
		echo '<input type="text" name="minYear" id="minYearId" value="'.$minYear.'" size="4">';
		echo ' ne sont pas pris en compte pour les classement des patrouilles et des troupes<br>';
		echo 'pour les classement par gars/filles, ils sont considérés comme des rouges<br>';
		echo '<br>';
		echo '<input type="Submit" value="MODIFIER">';
		echo '</form>';
		
		displayFooter();
		
		?>
		
	</body>
</html>