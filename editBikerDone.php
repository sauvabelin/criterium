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
$bikerId = getParameterPOST("bikerId");
$dossard = getParameterPOST("dossard");
$firstName = getParameterPOST("firstName");
$lastName = getParameterPOST("lastName");
$birthYear = getParameterPOST("birthYear");
$patrolId = getParameterPOST("patrolId"); // on a besoin de ça pour rediriger vers la bonne page

$firstName = formatCase($firstName);
$lastName = formatCase($lastName);

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
	
	// 2) numero de dossard: il peut déja exister pour le même biker, si
	// on est en train d'éditer seulement le nom ou le prénom.
	// on doit donc vérifier que le numero de dossare n'existe pas POUR UN AUTRE BIKER ID:
	$query = 'select * from t_biker where dossard="'.$dossard.'" and id!="'.$bikerId.'"';
	$res = mysql_query($query);
	// on regarde combien de record existent déja dans la DB (ça devrait être 0):
	$number_of_biker = mysql_num_rows($res);
	if($number_of_biker >= 1)
	{
		exit('erreur: ce numero de dossard existe deja dans la base de données pour un autr biker');
	}
}
else
{
	// si le dossard n'a pas été entré, on met un -1 (qui signifie "inconnu")
	$dossard=UNKNOWN;
}

// SI ET SEULEMENT SI lânnée a été entré, alors:
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
	// si le dossard n'a pas été entré, on met un -1 (qui signifie "inconnu")
	$birthYear=UNKNOWN;
}

//Modification dans la DB:


$query = 'update t_biker set dossard="'.$dossard.'", firstName="'.$firstName.'", lastName="'.$lastName.'", birthYear="'.$birthYear.'" where id="'.$bikerId.'"';
if(!mysql_query($query))
{
	exit('erreur lors de la requete SQL');
}

//4) on redirige automatiquement à la page d'édition de la patrouille courante (ce qui affichera le nouveau gars et qui 
//		permettra d'en ajouter encore d'autres):

// il se peut qu'un paramètre de plus, src, soit présent.
// c'est si on arrive ici en ayant fait admin->tests plutot que admin->edit troupe->edite patrouille->edit biker.
if(isset($_POST["src"]))
{
	$src=$_POST["src"];
	header('Location: '.$src.'.php');
}
else
{
	header('Location: editPatrol.php?patrol_id='.$patrolId);
}
?>
