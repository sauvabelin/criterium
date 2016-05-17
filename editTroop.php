<?php
	/*
		file: 	editTroop.php
		author: Benoît Uffer
		
		C'est le fichier d'édition d'une troupe:
		l'id de la troupe (bsNum) est passée en paramètre par la méthode GET
		On affiche une liste des patrouilles appartenant à cette troupe avec des liens "modifier" et "supprimer"
		ET on affiche un lien qui permet de rajouter une patrouille dans cette troupe
	*/
	
include_once("globals.php");
include_once("sql.php");

// on utilise une variable locale:
$bsNum = getParameterGET("bsNum");

// connection à la base de donnée:
connect();

// on récupère le nom de la troupe:
$troopName = getTroopName($bsNum);

// get all the patrol that are included in this troop (according to content of DB)
$query = 'select id,name from t_patrol where troop_id="'.$bsNum.'"';
$res = mysql_query($query);
// get size:
$number_of_patrol = mysql_num_rows($res);
for($j=0;$j<$number_of_patrol;$j++)
{
	$row = mysql_fetch_assoc($res);
	$patrol[$j]["id"] = $row["id"];
	$patrol[$j]["name"] = $row["name"];
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
	<?php
	echo '<h3>Troupe de '.$troopName.'</h3>';
	
	if($number_of_patrol > 0)
	{
		// ici on affiche un tableau avec toutes les patrouilles de le troupe:
		echo '<span class ="prompt">Liste des patrouilles:</span><br>';
		echo '<table border="1">';
		echo '<tr>';
		echo '<td>Patrouille</td><td>&nbsp;</td><td>&nbsp;</td>';
		echo '</tr>';		
		
		for($j=0;$j<$number_of_patrol;$j++)
		{
			echo '<tr>';
			echo '<td>'.$patrol[$j]["name"].'</td><td><a href="editPatrol.php?patrol_id='.$patrol[$j]["id"].'">éditer</a></td><td><a href="deletePatrol.php?id='.$patrol[$j]["id"].'&bsNum='.$bsNum.'">supprimer</a></td>';
			echo '</tr>';
		}
		
		echo '</table>';
	}
	else
	{
		echo '<div class="prompt">Il n\'y a encore aucune patrouille dans cette troupe!</div>';
	}
	
	// un lien qui permet d'ajouter une patrouille à la troupe:
	echo '<br><a href="addPatrol.php?bsNum='.$bsNum.'">ajouter une patrouille à cette troupe</a><br>';
	
	displayFooter();
	?>
				
	</body>
</html>