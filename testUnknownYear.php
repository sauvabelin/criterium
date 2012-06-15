<?php
	/*
		file: 	testUnknownYear.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


// connection à la base de données:
connect();


// 1) on fait la liste de tous les bikers qui ont encore un birthYear UNKNONW
$query = 'select t_biker.id as id,firstName, lastName, t_troop.name as troopName, t_patrol.name as patrolName from t_biker join t_patrol on t_patrol.id=t_biker.patrol_id join t_troop on t_troop.bsNum = t_patrol.troop_id where birthYear="'.UNKNOWN.'"';
$res=mysql_query($query);
// get size:
$number_of_bikers = mysql_num_rows($res);
for($i=0;$i<$number_of_bikers;$i++)
{
	$row = mysql_fetch_assoc($res);
	$biker[$i]["id"] = $row["id"];
	$biker[$i]["lastName"] = $row["lastName"];
	$biker[$i]["firstName"] = $row["firstName"];
	$biker[$i]["patrolName"] = $row["patrolName"];
	$biker[$i]["troopName"] = $row["troopName"];
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	
	<?php
	if($number_of_bikers == 0)
	{
		echo '<br><br>';
		echo '<span class="prompt">C\'est bon! il n\'y a aucun gars/filles dans la base de donnée avec une année de naissance inconnue</span>';
		echo '<br><br>';
	}
	else
	{
	
		echo '<div class="alert">Liste des bikers dont l\'année de naissance est inconnue:</div>';
		br(2);
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Nom</td><td>Prénom</td><td>Troupe</td><td>Patrouille</td><td></td><td></td>';
		echo '</tr>';
		
	
		for($i=0;$i<$number_of_bikers;$i++)
		{
			echo '<tr>';
			echo '<td>'.$biker[$i]["lastName"].'</td>';
			echo '<td>'.$biker[$i]["firstName"].'</td>';
			echo '<td>'.$biker[$i]["troopName"].'</td>';
			echo '<td>'.$biker[$i]["patrolName"].'</td>';
			// sur les liens, on ajoute un paramètre GET "src" pour qu'apres la modif (ou la suppression), on se redirige automatiquement à cette page
			echo '<td><a href="editBiker.php?id='.$biker[$i]["id"].'&src=testUnknownYear">Modifier infos</a></td>';
			echo '<td><a href="deleteBiker.php?id='.$biker[$i]["id"].'&src=testUnknownYear">Supprimer</a></td>';
			echo '</tr>';
		}
	
		echo '</table>';	
	}
	displayFooter();
	?>	
		
	</body>
</html>