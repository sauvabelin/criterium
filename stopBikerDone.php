<?php
/*
	file:		stopBikerDone.php
	author: Benoît Uffer
	
	Si on arrive ici, c'est qu'on peut modifier la DB (soit il n'y a pas encore de temps d'arrivée pour CE dossard pour CETTE etape,
	soit l'utilisateur a confirmé qu'on peut écraser la valeur
*/

include_once("sql.php");
include_once("globals.php");

// On récupère les variables GET (timeField, dossard, arrivalTime
$dossard = getParameterGET("dossard");
$arrivalTime = getParameterGET("arrivalTime");
$timeField = getParameterGET("timeField");

// connection à la base de donnée
connect();


// On modifie la base de donnée pour y mettre l'heure d'arrivée
$query = 'update t_biker set '.$timeField.'="'.$arrivalTime.'"  where dossard="'.$dossard.'"';
if(!mysql_query($query))
{
	exit('request failed: '.$query);
}

// On compte le nombre de dossards qui ne sont pas encore arrivés à cette étape:
$query = 'select count(*) from t_biker where '.$timeField.'="-1"';
$res = mysql_query($query);
$row = mysql_fetch_row($res);
$notArrived = $row[0];

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		
		<meta HTTP-EQUIV="Refresh" CONTENT="0;URL=stopBiker.php?timeField=<?php echo $timeField?>">
	</head>
	
	<body>
		
	<?php	

	//on écrit l'heure dans un format "Human-readable", et on notifie l'utilisateur de l'heure qu'on a ajouté dans la DB:
	$arrivalTimeHuman = date("H:i:s",$arrivalTime);
	echo 'le biker avec le dossard '.$dossard.' est arrivé a: <h3>'.$arrivalTimeHuman,'</h3>';
	
	
	
/*
		ce formulaire redirige simplement vers la page qui permet d'entrer le dossard suivant pour une arrivée à la même étape
		(Il n'y a aucune valeur envoyée)
*/
	echo '<form action="stopBiker.php" method="GET">';
	echo '<input type="hidden" name="timeField" value="'.$timeField.'">';
	echo '	<input type="submit" value="PROCHAIN">';
	echo '</form>';
	
	
		if($notArrived == 0)
		{
			echo 'tous les bikers sont arrivés à cette étape';
		}
		else
		{
			echo 'il reste encore '.$notArrived.' biker(s) qui ne sont pas arrivés à cette étape';
		}
	
		// affichage du pied de page
		displayFooter();
		
		
	?>
		
	</body>
</html>