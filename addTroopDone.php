<?php
	/*
		file: 	addTroopDone.php
		author: Benoît Uffer
		
		On arrive a ce script apres avoir "crée" une nouvelle troupe dans le fichier "addTroop.php"
		On vérifie que le champ n'est pas vide, et que la troupe n'existe pas déja (nom ou bsNum),
		ensuite c'est bon: On modifie la DB
	*/

include_once("sql.php");
include_once("globals.php");

// on récupère le nom de la patrouille passé par GET
$troopName = getParameterGET("troopName");
// on récupère le numero BS passé par GET
$bsNum = getParameterGET("bsNum");
// on récupère le type passé par GET
$type = getParameterGET("type");


// on vérifie que le nom de la troupe et le bsNUm ont été rempli:
if(trim($troopName)=="" || trim($bsNum)=="")
{
	exit("Erreur: un des champs est vide");
}

// connection à la base de donnée
connect();


// On vérifie que cette troupe n'existe pas déja dans la base de donnée:
// PROBLEMES: cette vérification est case-sensitive:
// donc si on veut ajouter "aigles" et que dans la base il y a "Aigles", alors
// ça va marcher. Pour y remedier, on utilise la fonction formatCase() qui retourne
// une chaîne dont la premiere lettre uniquement est en majuscule. On fait de même quand on
// ajoute une chaîne dans la base, donc on utilise QUE des chaînes qui ont ce format.
// un autre problème est le pluriel: "Aigle" est différent de "Aigles"
// pour y remedier, on ne peut que demander à l'utilisateur d'écrire le nom de la patrouille
// au pluriel à chaque fois et espérer qu'il le fait.
// le dernier problème est les accents. Je ne suis pas sur de la façon dont ils sont gérés
// (est-ce que l'encodage dans le navigateur est le même que dans la base? quel impact ça a?
// c'est un domaine dans lequel je ne suis pas à l'aise)
$query = 'select * from t_troop where name="'.formatCase($troopName).'"';
$res = mysql_query($query);
// on regarde combien de record existent déja dans la DB (ça devrait être 0):
$number_of_patrol = mysql_num_rows($res);
if($number_of_patrol >= 1)
{
	exit('erreur: il y a déja une troupe avec le même nom dans la base de données.');
}
$query = 'select * from t_troop where bsNum="'.$bsNum.'"';
$res = mysql_query($query);
// on regarde combien de record existent déja dans la DB (ça devrait être 0):
$number_of_patrol = mysql_num_rows($res);
if($number_of_patrol >= 1)
{
	exit('erreur: il y a déja une troupe avec le même numéro BS dans la base de données.');
}


//3) Insertion dans la DB:
$query = 'insert into t_troop values("'.$bsNum.'","'.formatCase($troopName).'","'.$type.'")';
if(!mysql_query($query))
{
	exit('erreur lors de la requete SQL');
}

//4) on redirige automatiquement à la page d'édition de la patrouille courante (ce qui affichera le nouveau gars et qui 
//		permettra d'en ajouter encore d'autres):
header('Location: admin.php');
?>