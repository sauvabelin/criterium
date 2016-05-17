<?php
	/*
		file: 	addTroop.php
		author: Benoît Uffer
		
		Ici on affiche un formulaire qui permet à l'utilisateur d'ajouter une troupe
	*/

include_once("globals.php");
include_once("sql.php");      

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		<?php
		echo '<form action="addTroopDone.php" method="GET">';
		
		echo '<table>';
		echo '<tr>';
		echo '<td align="right"><label for="troopNameId">Nom de la troupe: </label></td>';
		echo '<td><input type="text" name="troopName" id="troopNameId" value=""></td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td align="right"><label for="bsNumId">Numéro BS: </label></td>';
		echo '<td><input type="text" name="bsNum" id="bsNumId" value="" size="2"></td>';
		echo '</tr>';
		echo '</table>';
		
		echo '<h3>Type:</h3>';
		echo '<input type="radio" name="type" value="'.ECLAIREUR.'" id="eclaireurId" value="" size="2">';
		echo '<label for="eclaireurId">Eclaireur</label>';
		echo '<br>';
		echo '<input type="radio" name="type" value="'.ECLAIREUSE.'" id="eclaireuseId" value="" size="2">';
		echo '<label for="eclaireuseId">Eclaireuse</label>';
		echo '<br>';
		echo '<input type="radio" name="type" value="'.ROUGE_G.'" id="rougegId" value="" size="2">';
		echo '<label for="rougegId">Rouge (garçons)</label>';
		echo '<br>';
		echo '<input type="radio" name="type" value="'.ROUGE_F.'" id="rougefId" value="" size="2">';
		echo '<label for="rougefId">Rouge (filles)</label>';
		echo '<br><br>';
		echo '<input type="Submit">';
		echo '</form>';
		
		
		// affichage du pied de page
		displayFooter();
		?>
		
	</body>
</html>
