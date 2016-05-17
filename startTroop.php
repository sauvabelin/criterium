<?php
	/*
		file: 	startTroop.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


$bsNum = getParameterGET("bsNum");

// connect to database:
connect();

// get the name of the troop:
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
		
		<h3>Donner le départ d'une patrouille (ajouter/retirer un gars/fille, changer un numero de brassard, etc...)</h3>
		<?php
		if($number_of_patrol>0)
		{
			for($j=0;$j<$number_of_patrol;$j++)
			{
				echo '<a href="startPatrol.php?id='.$patrol[$j]["id"].'">départ de la patrouille '.$patrol[$j]["name"].'</a><br>';
			}
		}
		else
		{
			echo '<span class="alert">Attention: </span>';
			echo 'La troupe '.$troopName.' ne contient encore aucune patrouille dans la base de donnée';
			echo '<br>';
		}
		
		
		displayFooter();
		?>
				
	</body>
</html>
