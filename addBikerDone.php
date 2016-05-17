<?php
	/*
		file: 	addBikerDone.php
		author: Benoît Uffer
		
		On arrive a ce script apres avoir "crée" un nouveau Biker dans le fichier "addBiker.php"
		On verifie que les noms et prénoms ont bien été rempli.
		
		Le numero de dossard peut avoir été laissé vide. (si il n'est pas encore connu).
		Si il n'est pas vide on vérifie si il est déja présent dans la DB (on ne peut pas avoir deux bikers
		avec le même numéro de dossard)
	*/

include_once("sql.php");
include_once("globals.php");

$patrolId = getParameterGET("patrol_id");

// connection à la base de donnée
connect();


//On prend les info entrées par l'utilisateur dans le forumlaire et envoyées par la méthode POST:
$dossard = $_POST["dossard"];
$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$birthYear = $_POST["birthYear"];
// on vérifie que tous les champs on été remplis:
if(trim($firstName)=="" || trim($lastName)=="")
{
	exit("Erreur: au moins un champs n'a pas été rempli");
}

// SI ET SEULEMENT SI le numero de dossard a été entré, alors:
if(trim($dossard)!="")
{
	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($dossard))
	{
		exit("erreur: le dossard doit etre un nombre entier");
	}
	
	
	// 2) On vérifie que ce numéro de dossard n'existe pas déja dans la base de donnée:
	$query = 'select * from t_biker where dossard="'.$dossard.'"';
	$res = mysql_query($query);
	// on regarde combien de record existent déja dans la DB (ça devrait être 0):
	$number_of_biker = mysql_num_rows($res);
	if($number_of_biker >= 1)
	{
		exit('erreur: ce numero de dossard existe deja dans la base de données');
	}
}
else
{
	// si le dossard n'a pas été entré, on met un -1 (qui signifie "inconnu")
	$dossard=UNKNOWN;
}

// SI ET SEULEMENT SI l'année a été entré, alors:
if(trim($birthYear)!="")
{	
	// 1) on vérifie que c'est un nombre entier:
	if(!is_a_number($birthYear))
	{
		exit("erreur: l\'année doit etre un nombre entier");
	}
}
else
{
	// si l'année n'a pas été entré, on met un -1 (qui signifie "inconnu")
	$birthYear=UNKNOWN;
}

// on met le format habituel (premiere lettre en majuscule, toutes les autres en minuscules:
$firstName = formatCase($firstName);
$lastName = formatCase($lastName);

//Insertion dans la DB:
$query = 'insert into t_biker values("NULL", "'.$dossard.'","'.$firstName.'","'.$lastName.'","'.$birthYear.'","'.$patrolId.'","'.UNKNOWN.'","'.UNKNOWN.'","'.UNKNOWN.'","'.UNKNOWN.'","'.UNKNOWN.'","'.UNKNOWN.'")';
if(!mysql_query($query))
{
	exit('erreur lors de la requete SQL');
}

//4) on redirige automatiquement à la page d'édition de la patrouille courante (ce qui affichera le nouveau gars et qui 
//		permettra d'en ajouter encore d'autres):
header('Location: editPatrol.php?patrol_id='.$patrolId);
?>