<?php
	/*
		file: 	editTimesDone.php
		author: Benoît Uffer
		
		On arrive à ce script si on veut modifier des temps d'un biker. (temps de départ ou d'arrivée)
	*/

include_once("sql.php");
include_once("globals.php");


// récupération des paramètres POST:
$bikerId  = getParameterPOST("biker_id");
$patrolId = getParameterPOST("patrol_id");
$start1HH = getParameterPOST("start1HH");
$start1MM = getParameterPOST("start1MM");
$start1SS = getParameterPOST("start1SS");
$end1HH 	= getParameterPOST("end1HH");
$end1MM 	= getParameterPOST("end1MM");
$end1SS 	= getParameterPOST("end1SS");
$startAHH = getParameterPOST("startAHH");
$startAMM = getParameterPOST("startAMM");
$startASS = getParameterPOST("startASS");
$endAHH 	= getParameterPOST("endAHH");
$endAMM 	= getParameterPOST("endAMM");
$endASS 	= getParameterPOST("endASS");
$start2HH = getParameterPOST("start2HH");
$start2MM = getParameterPOST("start2MM");
$start2SS = getParameterPOST("start2SS");
$end2HH 	= getParameterPOST("end2HH");
$end2MM 	= getParameterPOST("end2MM");
$end2SS 	= getParameterPOST("end2SS");

//calcul des temps correspondants:
if($start1HH=="??" || $start1MM=="??" ||$start1SS=="??")
{
	$start1 = UNKNOWN;
}
else
{
	$start1=mktime($start1HH,$start1MM,$start1SS);
}
if($end1HH=="??" || $end1MM=="??" ||$end1SS=="??")
{
	$end1 = UNKNOWN;
}
else
{
	$end1=mktime($end1HH,$end1MM,$end1SS);
}

//calcul des temps correspondants:
if($startAHH=="??" || $startAMM=="??" ||$startASS=="??")
{
	$startA = UNKNOWN;
}
else
{
	$startA=mktime($startAHH,$startAMM,$startASS);
}
if($endAHH=="??" || $endAMM=="??" ||$endASS=="??")
{
	$endA = UNKNOWN;
}
else
{
	$endA=mktime($endAHH,$endAMM,$endASS);
}


if($start2HH=="??" || $start2MM=="??" ||$start2SS=="??")
{
	$start2 = UNKNOWN;
}
else
{
	$start2=mktime($start2HH,$start2MM,$start2SS);
}
if($end2HH=="??" || $end2MM=="??" ||$end2SS=="??")
{
	$end2 = UNKNOWN;
}
else
{
	$end2=mktime($end2HH,$end2MM,$end2SS);
}


// connection à la base de donnée
connect();

//Modification dans la DB
$query = 'update t_biker set startTime1="'.$start1.'", endTime1="'.$end1.'", startTimeAttack="'.$startA.'", endTimeAttack="'.$endA.'", startTime2="'.$start2.'", endTime2="'.$end2.'" where id="'.$bikerId.'"';
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
