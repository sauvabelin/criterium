<?php
	/*
		file: 	deleteTroop.php
		author: Benoît Uffer
		
		Si on arrive à ce fichier, ça veut dire que l'utilisateur a cliqué sur le lien "supprimer" à coté d'une troupe
		dans la page d'admin.
		
		On prend dans la DB le nom de la troupe, et on demande confirmation à l'utilisateur de la supprimer
	*/
include_once("globals.php");
include_once("sql.php");

// on récupère les variables GET dans des variables locales pour ce script
$bsNum = getParameterGET("bsNum");

// connection à la base de données:
connect();

// On récupère le nom de la patrouille qu'on veut afficher pour l'utilisateur:
$query = 'select name from t_troop where bsNum="'.$bsNum.'"';
$res = mysql_query($query);
// on regarde si on a bien 1 et 1 seul patrouille avec cet id:
$number_of_troop = mysql_num_rows($res);
if($number_of_troop!=1)
{
	exit('error: Il y a '.$number_of_patrol.' patrouille avec id="'.$id.'" dans la base de donnée (alors qu\'il devrait y en avoir 1)');
}
$row = mysql_fetch_assoc($res);
$name = $row["name"];

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	<?php
		// on affiche une demande de confirmation de la suppression à l'utilisateur:
		echo '<h2>Etes-vous sur de vouloir supprimer la troupe '.$name.'?</h2>';
		echo '<br><br>';
		echo '<a href="deleteTroopConfirmed.php?bsNum='.$bsNum.'">OUI, SUPPRIMER</a>';
		echo '<br><br>';
		echo '<a href="admin.php">NON, ANNULER</a>';
	?>
	</body>
</html>