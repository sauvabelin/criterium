<?php
	/*
		file: 	deleteBiker.php
		author: Benoît Uffer
		
		Si on arrive à ce fichier, ça veut dire que l'utilisateur a cliqué sur le lien "supprimer" à coté d'un biker
		dans la page d'édition d'une patrouille.
		
		On prend dans la DB le nom et prénom du biker, et on demande à l'utilisateur de confirmer la suppression du biker
	*/
include_once("globals.php");
include_once("sql.php");

// on vérifie que le paramètre GET est présent (c'est l'id du biker à supprimer)
$id = getParameterGET("id");


// connection à la base de données:
connect();


// On récupère les infos du biker qu'on veut afficher pour l'utilisateur:
$query = 'select firstName,lastName,dossard,patrol_id from t_biker where id="'.$id.'"';
$res = mysql_query($query);
// on regarde si on a bien 1 et 1 seul biker avec cet id:
$number_of_biker = mysql_num_rows($res);
if($number_of_biker!=1)
{
	exit('error: Il y a '.$number_of_biker.' bikers avec id="'.$id.'" dans la base de donnée (alors qu\'il devrait y en avoir 1)');
}
$row = mysql_fetch_assoc($res);
$firstName = $row["firstName"];
$lastName = $row["lastName"];
$dossard = $row["dossard"];
$patrolId = $row["patrol_id"];

// si le dossard est inconnu, on affiche "inconnu" plutot que "-1"
if($dossard == UNKNOWN)
{
	$dossard = "\"inconnu\"";
}


?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	<?php
	// on affiche une demande de confirmation de la suppression à l'utilisateur:
		if(isset($_GET["src"]))
		{
			// il se peut qu'un paramètre de plus, src, soit présent.
			// c'est si on arrive ici en ayant fait admin->tests plutot que admin->edit troupe->edite patrouille->edit biker.
			// dans ce cas, on le passe pour que la redirection automatique se fasse au bon endroit:
			$src = $_GET["src"];
			
			echo '<h2>Etes-vous sur de vouloir supprimer le participant '.$firstName.' '.$lastName.' qui a le dossard '.$dossard.'?</h2>';
			echo '<br><br>';
			echo '<a href="deleteBikerConfirmed.php?id='.$id.'&src='.$src.'">OUI, SUPPRIMER</a>';
			echo '<br><br>';
			echo '<a href="'.$src.'.php">NON, ANNULER</a>';
		}
		else
		{
			echo '<h2>Etes-vous sur de vouloir supprimer le participant '.$firstName.' '.$lastName.' qui a le dossard '.$dossard.'?</h2>';
			echo '<br><br>';
			echo '<a href="deleteBikerConfirmed.php?id='.$id.'">OUI, SUPPRIMER</a>';
			echo '<br><br>';
			echo '<a href="editPatrol.php?patrol_id='.$patrolId.'">NON, ANNULER</a>';
		}
	?>
	</body>
</html>