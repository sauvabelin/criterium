<?php
	/*
		file: 	changeTimeAttackFactorDone.php
		author: Christian Muller
	*/

include_once("globals.php");
include_once("sql.php");


// connection à la base de donnée
connect();


//On prend les info entrées par l'utilisateur dans le forumlaire et envoyées par la méthode POST:
$timeAttackFactor = getParameterPOST("timeAttackFactor");

// verification des paramètres entrés:
if(trim($timeAttackFactor)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($timeAttackFactor))
	{
		exit("erreur: le facteur de multiplication doit etre un nombre entier");
	}
}
else
{
	exit('il faut pas laisser le champ libre, nigaud!');
}

//Modification dans la DB:
setTimeAttackFactor($timeAttackFactor);

//4) on redirige automatiquement à la page d'admin 
header('Location: admin.php');
?>
