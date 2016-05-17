<?php
/*
	file: 	stopBikerPrompt.php
	author: Benoît Uffer
	
	ce fichier est automatiquement appelé (grâce à la fonction header) par le fichier "stopBiker.php" si l'utilisateur entre un dossard
	qui a déja été stoppé. On laisse à l'utilisateur le choix d'écraser (entrer un nouveau temps pour l'arrivée de ce même dossard) ou 
	d'annuler (on retourne à la page qui permet d'entrer le numero du dossard sans toucher à la base de donnée
*/

include_once("globals.php");

// On récupère le numéro du dossard qu'on est en train de traiter (pour affichage)
$dossard = getParameterGET("dossard");
$timeField = getParameterGET("timeField");
$arrivalTime = getParameterGET("arrivalTime");

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		<?php
		echo '<h2>Attention: le dossard '.$dossard.' est déja arrivé à cette étape. Voulez-vous l\'écraser?</h2>';
		echo '<br><br>';
		echo '<a href="stopBikerDone.php?timeField='.$timeField.'&dossard='.$dossard.'&arrivalTime='.$arrivalTime.'">OUI, ECRASER</a>';
		echo '<br><br>';
		echo '<a href="stopBiker.php?timeField='.$timeField.'>NON, ANNULER</a>';
		?>
	</body>
</html>