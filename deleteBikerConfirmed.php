<?php
	/*
		file: 	deleteBikerConfirmed.php
		author: Benoît Uffer
		
		Si on arrive à ce fichier, ça veut dire que l'utilisateur a confirmé qu'on pouvait détruire le biker concerné
		(on le distingue grâce à son "id"
	*/
include_once("globals.php");
include_once("sql.php");



// On récupère l'id du biker à détruire:
$id = getParameterGET("id");

// connection à la DB:
connect();


// il faut récupérer la patrol_id à laquelle le biker appartient de sorte à pouvoir rediriger directement
// vers la bonne patrouille
$query = 'select patrol_id from t_biker where id="'.$id.'"';
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$patrolId = $row["patrol_id"];

// on détruit le biker:
$query = 'delete from t_biker where id="'.$id.'"';
if(!mysql_query($query))
{
	exit("la destruction a échoué");
}

// on redirige automatiquement vers la page d'édition de la patrouille
// il se peut qu'un paramètre de plus, src, soit présent.
// c'est si on arrive ici en ayant fait admin->tests->supprimer plutot que admin->edit troupe->edite patrouille->supprimer.
if(isset($_GET["src"]))
{
	$src=$_GET["src"];
	header('Location: '.$src.'.php');
}
else
{
	header('Location: editPatrol.php?patrol_id='.$patrolId);
}



?>