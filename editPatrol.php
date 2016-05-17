<?php
	/*
		file: 	editPatrol.php
		author: Benoît Uffer
		
		C'est le fichier d'édition d'une troupe:
		l'id de la patrouille est passée en paramètre par la méthode GET (en cliquant sur le lien "modifier" dans le fichier editTroop.php
		On affiche une liste des gars/fille appartenant à cette patrouille avec un lien "supprimer"
		ET on affiche un lien qui permet de rajouter un gars/fille dans cette patrouille
	*/

include_once("globals.php");
include_once("sql.php");


// set local Variables from GET:
$patrolId = getParameterGET("patrol_id");


// connect to database:
connect();


// on recupère le nom de la patrouille:
$patrolName=getPatrolName($patrolId);

//get All the bikers of the patrol:
$query = 'select id,dossard,firstName,lastName,birthYear from t_biker where patrol_id="'.$patrolId.'"';
$res = mysql_query($query);
// get size:
$number_of_biker = mysql_num_rows($res);
for($i=0;$i<$number_of_biker;$i++)
{
	$row = mysql_fetch_assoc($res);
	$biker[$i]["dossard"] = $row["dossard"];
	if($biker[$i]["dossard"] == UNKNOWN)
	{
		// si le numero de dossard n'est pas inconnu, on affiche "inconnu" plutot que la valeur "-1"
		$biker[$i]["dossard"] = "inconnu";
	}
	$biker[$i]["firstName"] = $row["firstName"];
	$biker[$i]["lastName"] = $row["lastName"];
	$biker[$i]["birthYear"] = $row["birthYear"];
	if($biker[$i]["birthYear"] == UNKNOWN)
	{
		// si le numero de dossard n'est pas inconnu, on affiche "inconnu" plutot que la valeur "-1"
		$biker[$i]["birthYear"] = "inconnu";
	}
	$biker[$i]["id"] = $row["id"];
}


?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
	<?php	
	
	echo '<h2>Patrouille des '.$patrolName.'</h2>';
	
		if($number_of_biker > 0)
	{
		//display all bikers of this patrol in a table:
		echo '<span class ="prompt">Liste des gars/filles:</span><br>';
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>Dossard</td><td>Nom</td><td>Prénom</td><td>Année</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
		echo '</tr>';
		
		for($i=0;$i<$number_of_biker;$i++)
		{
			echo '<tr>';
			echo '<td>'.$biker[$i]["dossard"].'</td>';
			echo '<td>'.$biker[$i]["firstName"].'</td>';
			echo '<td>'.$biker[$i]["lastName"].'</td>';
			echo '<td>'.$biker[$i]["birthYear"].'</td>';
			echo '<td><a href="deleteBiker.php?id='.$biker[$i]["id"].'">Supprimer</a></td>';
			echo '<td><a href="editBiker.php?id='.$biker[$i]["id"].'">Modifier infos</a></td>';
			echo '<td><a href="editTimes.php?biker_id='.$biker[$i]["id"].'">Modifier temps</a></td>';
			echo '</tr>';
		}
	}
	else
	{
		echo '<div class="prompt">Il n\'y a encore aucun gars/filles dans cette patrouille!</div>';
	}
	
	echo '</table>';
	
	echo '<br><a href="addBiker.php?patrol_id='.$patrolId.'">ajouter un gars/fille à cette patrouille</a><br>';
	
	
	
	displayFooter();
	?>
		
	</body>
</html>