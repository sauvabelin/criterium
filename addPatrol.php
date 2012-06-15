<?php
	/*
		file: 	addPatrol.php
		author: Benoît Uffer
		
		Ici on affiche un formulaire qui permet à l'utilisateur d'ajouter une patrouille à la troupe courante
	*/

include_once("globals.php");
include_once("sql.php");      

$bsNum = getParameterGET("bsNum");

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		<?php
		echo '<form action="addPatrolDone.php" method="GET">';
		echo '<input type="hidden" name="bsNum" value="'.$bsNum.'">';
		echo '<label for="patrolNameId">Nom de la patrouille:</label>';
		echo '<input type="text" name="patrolName" id="patrolNameId" value="">';
		echo '<br>';
		echo '<input type="Submit">';
		echo '</form>';
		
		
		// affichage du pied de page
		displayFooter();
		?>
		
	</body>
</html>