<?php
	/*
		file: 	editBikerDone.php
		author: Benoît Uffer
		
		On arrive à ce script si on veut modifier des données d'un biker. (changer son numero de dossard par exemple)
	*/

include_once("sql.php");
include_once("globals.php");



// connection à la base de donnée
connect();


//On prend les info entrées par l'utilisateur dans le forumlaire et envoyées par la méthode POST:
$minYear = getParameterPOST("minYear");

// SI ET SEULEMENT SI l'année a été entré, alors:
if(trim($minYear)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($minYear))
	{
		exit("erreur: l\'année doit etre un nombre entier");
	}
}
else
{
	exit('il faut pas laisser le champ libre, nigaud!');
}


//Modification dans la DB:
setMinimalYear($minYear);

//4) on redirige automatiquement à la page d'admin 
header('Location: admin.php');
?>
