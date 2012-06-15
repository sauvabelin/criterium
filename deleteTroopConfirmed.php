<?php
	/*
		file: 	deleteTroopConfirmed.php
		author: Benoît Uffer
		
		Si on arrive à ce fichier, ça veut dire que l'utilisateur a confirmé qu'on pouvait détruire la patrouille concernée
		(on la distingue grâce à son "bsNum")
	*/
include_once("globals.php");
include_once("sql.php");


//on récupère les bsNum:
$bsNum = getParameterGET("bsNum");


// connection à la DB:
connect();


// on détruit la troupe:
$query = 'delete from t_troop where bsNum="'.$bsNum.'"';
if(!mysql_query($query))
{
	exit("la destruction de la troupe a échoué");
}

// on récupère la liste des patrol_id de cette troupe:
$query = 'select id from t_patrol where troop_id="'.$bsNum.'"';
$res = mysql_query($query);
$number_of_patrol = mysql_num_rows($res);
for($i=0;$i<$number_of_patrol;$i++)
{
	$row = mysql_fetch_assoc($res);
	$patrolId[$i]= $row["id"];
}

// on detruit toutes les patrouilles de cette troupe:
// on détruit la troupe:
$query = 'delete from t_patrol where troop_id="'.$bsNum.'"';
if(!mysql_query($query))
{
	exit("la destruction des patrouilles de la troupe a échoué");
}

// on detruit tous les bikers de la troupe (grace aux id de patrouilles récupérés:
for($i=0;$i<$number_of_patrol;$i++)
{
	$query = 'delete from t_biker where patrol_id="'.$patrolId[$i].'"';
	if(!mysql_query($query))
	{
		exit("la destruction d'un biker de la troupe a échoué");
	}
}


// on detruit tous les gars/filles de cette troupe:

// on redirige automatiquement vers la page d'édition de la patrouille
header('Location: admin.php');

?>