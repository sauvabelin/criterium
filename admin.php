<?php

	/*
		file: 	admin.php
		author: Benoît Uffer
		
		Ce fichier est le point d'entrée de "l'admisintration"	
		On peut y ajouter/supprimer une troupe, ou aller à l'édition de la troupe (pour ajouter/supprimer une patrouille)
		On peut afficher le contenu de la base de donnée	
	*/
	
include_once("sql.php");
include_once("globals.php");

// connection à la base de données:
connect();


// On chercher la liste de toutes les troupes qui existent dans la base de données
$query = 'select * from t_troop order by "bsNum"';
$res = mysql_query($query);
// get size:
$fieldsNum = mysql_num_fields($res);
$number_of_troop = mysql_num_rows($res);
for($j=0;$j<$number_of_troop;$j++)
{
	$row = mysql_fetch_assoc($res);
	$troupe[$j]["bsNum"] = $row["bsNum"];
	$troupe[$j]["name"] = $row["name"];
}


?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>


		
	<?php
	echo '<h3>Edition des troupes</h3>';
	
	// on affiche un tableau avec toutes les troupes , et des liens pour les editer ou supprimer:
	echo '<span class ="prompt">Liste des troupes:</span><br>';
	echo '<table border="1">';
	echo '<tr>';
	echo '<td>Troupe</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
	echo '</tr>';	
	
	for($j=0;$j<$number_of_troop;$j++)
	{
		echo '<tr>';
		echo '<td>'.$troupe[$j]["name"].'</td><td><a href="editTroop.php?bsNum='.$troupe[$j]["bsNum"].'">éditer</a></td><td><a href="deleteTroop.php?bsNum='.$troupe[$j]["bsNum"].'">supprimer</a></td><td><a href="displayTroop.php?bsNum='.$troupe[$j]["bsNum"].'">afficher</a></td>';
		echo '</tr>';
	}
	
	echo '</table>';
	
	// un lien qui permet d'ajouter une troupe:
	echo '<br><a href="addTroop.php">ajouter une troupe à la liste</a>';
	
	echo '<hr>';
	echo '<h3>Tests</h3>';
	echo '<a href="testUnknownDossard.php">Rechercher les participants dont les dossard sont inconnus</a><br>';
	echo '<a href="testUnknownYear.php">Rechercher les participants dont l\'année de naissance est inconnue</a><br>';
	echo '<a href="testUnknownTimes.php">Rechercher les participants dont les temps sont inconnus</a><br>';
	echo '<hr>';
	echo '<h3>Outils</h3>';
	echo '<a href="changeMinimalYear.php">Changer l\'année limite pour le classement ('.getMinimalYear().')</a><br>';
	echo '<a href="changeLimits.php">Changer les nombre limites de participants (minimum: '.getMinBiker().' bikers, maximum: '.getMaxBiker().' bikers, bonus: '.getBonus().' sec)</a><br>';
	echo '<a href="changeTimeAttackFactor.php">Changer le facteur de multiplication du contre la montre ('.getTimeAttackFactor().')</a><br>';
	echo '<a href="INFO_displayTables.php">Afficher le contenu des tables</a><br>';
	echo '<a href="INFO_systemTime.php">conversions heure systeme</a>';
	
	echo '<hr>';
	echo '<span class="alert">Attention:</span>';
	echo 'ces fonctions vont détruire toute la base de donnée.<br>';
	echo '<a href="WARNING_dropAllTables_check.php">(0) Détruire toutes les tables</a><br>';
	echo '<a href="WARNING_createVirginDB_check.php">(1) Initialiser Base de Donnée</a><br>';
	echo '<a href="WARNING_createDummyBikersForTest_check.php">(2) Remplir la base avec des bikers aleatoires (faire étape 1 d\'abord)</a><br>';
	echo '<a href="WARNING_createDummyBikersForTestWithTimes_check.php">(3) Remplir les temps des bikers aléatoires (faire étape 1 et 2 d\'abord)</a><br>';

	
	// afficher le pied de page
	displayFooter();
	?>
		
	</body>
</html>
