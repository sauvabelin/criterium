<?php
	/*
		file: 	changeLimitsDone.php
		author: Benoît Uffer
	*/

include_once("sql.php");
include_once("globals.php");



// connection à la base de donnée
connect();


//On prend les info entrées par l'utilisateur dans le forumlaire et envoyées par la méthode POST:
$minBiker = getParameterPOST("minBiker");
$maxBiker = getParameterPOST("maxBiker");
$bonus = getParameterPOST("bonus");

// verification des paramètres entrés:
if(trim($minBiker)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($minBiker))
	{
		exit("erreur: le nombre de participants doit etre un nombre entier");
	}
}
else
{
	exit('il faut pas laisser le champ libre, nigaud!');
}

if(trim($maxBiker)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($maxBiker))
	{
		exit("erreur: le nombre de participants doit etre un nombre entier");
	}
}
else
{
	exit('il faut pas laisser le champ libre, nigaud!');
}

if(trim($bonus)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($bonus))
	{
		exit("erreur: le bonus doit etre un nombre entier");
	}
}
else
{
	exit('il faut pas laisser le champ libre, nigaud!');
}


//Modification dans la DB:
setMinBiker($minBiker);
setMaxBiker($maxBiker);
setBonus($bonus);

//4) on redirige automatiquement à la page d'admin 
header('Location: admin.php');
?>
