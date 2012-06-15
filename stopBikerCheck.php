<?php
/*
	file: 	stopBikerCheck.php
	author: Benoît Uffer
	
	L'utilisateuir a entré dans la page précédente le numéro de dossard et l'heure d'arrivée.
	On les récupère ici et on va les entrer dans la base de donnée.
	On vérifie que le numero de dossard est différent de "UNKNOWN". ( -1, c'est le numero qu'on met quand on ne connait pas encore
	Le vrai numéro et qu'on veut déja entrer le biker dans la base de donnée. C'est donc le seul numéro pour lequel un
	doublon est accepté.
	Ensuite on va s'assurer que l'heure d'arrivée de l'étape courante n'as pas déja été fixé pour le dossard courant:
	On vérifie dans la base de donnée. si l'heure vaut "0" c'est qu'elle n'a pas encore été fixée. On passe donc directement au
	fichier stopBikerDone.php qui va fair les modifs dans la base de donnée
	Si elle a déja été fixée, on passe par une étape intermédiaire: stopBikerPrompt.php qui notifie l'utilisateur que l'heure à déja été
	fixée pour ce dossard, et il peut choisir d'annuler ou de continuer.
*/


include_once("globals.php");
include_once("sql.php");


//set local variable from form:
$dossard = getParameterPOST("dossard");
if($dossard == UNKNOWN)
{
	exit("erreur: numero de dossard invalide!");
}

$timeField = getParameterGET("timeField");


// on regarde quelle méthode à été choisie
if(isset($_POST['method']))
{
	$method = $_POST['method'];
}
else
{
	// normalement, à ce stade il est impossible que $timeField ne soit pas "setté", mais mieux vaut vérifier.
	exit('erreur: vous n\'avez pas choisi la méthode');
}

if($method=="system")
{
	// L'utilisateur a choisi d'utiliser l'heure de l'ordinateur:
	$arrivalTime = time();
}
else if($method=="manual")
{
	// L'utilisateur a choisi d'entrer une heure manuellement. On lit l'heure qu'il a entré (method POST)
	$h = $_POST["hh"];
	$m = $_POST["mm"];
	$s = $_POST["ss"];
	$arrivalTime=mktime($h,$m,$s);
}
else
{
	// normalement c'set impossible que la méthode n'ai pas été définie car ce sont des boutons radio avec une valeur par défaut,
	// mais vérifions tout de même:
	exit("erreur: la methode n'as pas été définie");
}


// connection à la base de donnée:
connect();


// On vérifie que ce numéro de dossard existe bel et bien dans la base de donnée, et qu'il existe une seule fois!
$query = 'select '.$timeField.' from t_biker where dossard="'.$dossard.'"';
$res = mysql_query($query);
// on regarde le nombre de ligne de la réponse (= au nombre de fois que ce dossard existe dans la DB)
$number_of_biker = mysql_num_rows($res);
if($number_of_biker!=1)
{
	// erreur: le nombre de fois que le dossard existe dans la DB n'est pas 1
	exit('erreur: Il y a '.$number_of_biker.' bikers avec id="'.$dossard.'" dans la base de donnée (alors qu\'il devrait y en avoir 1)');
}

// On vérifie que le temps d'arrivée du dossard courant à l'étape courante est -1. (= pas encore initialisé)
$row = mysql_fetch_assoc($res);
$fieldValue = $row[$timeField];
if($fieldValue != UNKNOWN)
{
	// attention: il y a déja un temps d'arrivée pour ce dossard et pour cette etape. Il faut averitir l'utilisateur plutot
	// que de modifier la DB directement:
	header('Location: stopBikerPrompt.php?timeField='.$timeField.'&dossard='.$dossard.'&arrivalTime='.$arrivalTime.'');
}
else
{
	// c'est bon. On peut directement modifier la DB
	header('Location: stopBikerDone.php?timeField='.$timeField.'&dossard='.$dossard.'&arrivalTime='.$arrivalTime.'');
}

