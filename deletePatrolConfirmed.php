<?php
	/*
		file: 	deletePatrolConfirmed.php
		author: Benoît Uffer
		
		Si on arrive à ce fichier, ça veut dire que l'utilisateur a confirmé qu'on pouvait détruire la patrouille concernée
		(on la distingue grâce à son "id")
	*/
include_once("globals.php");
include_once("sql.php");


// on récupère les variables GET dans des variables locales pour ce script
$patrolId = getParameterGET("id");
$bsNum = getParameterGET("bsNum"); // on garde le bsNum pour retourner automatiquement à la page de la bonne troupe apres destruction


// connection à la DB:
connect();


// on détruit la patrouille:
$query = 'delete from t_patrol where id="'.$patrolId.'"';
if(!mysql_query($query))
{
	exit("la destruction a échoué");
}

// on detruit tous les gars/filles de cette patrouille:
$query = 'delete from t_biker where patrol_id="'.$patrolId.'"';
if(!mysql_query($query))
{
	exit("la destruction a échoué");
}

// on redirige automatiquement vers la page d'édition de la patrouille
header('Location: editTroop.php?bsNum='.$bsNum);

?>