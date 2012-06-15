<?php
	/*
		file: 	startPatrolDone.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


$patrolId = getParameterGET("patrol_id");

//set local variable from form:
if(isset($_POST['timeField']))
{
	$timeField = $_POST['timeField'];
}
else
{
	exit('erreur: vous n\'avez pas choisi l\'étape');
}

if(isset($_POST['method']))
{
	$method = $_POST['method'];
}
else
{
	exit('erreur: vous n\'avez pas choisi la méthode');
}


if($method=="system")
{
	// get current UNIX time:
	$currentTime = time();
}
else if($method=="manual")
{
	// create corresponding UNIX time:
	$h = $_POST["hh"];
	$m = $_POST["mm"];
	$s = $_POST["ss"];
	$currentTime=mktime($h,$m,$s);
}
else
{
	exit("erreur: la methode n'as pas été définie");
}



// connect to database:
connect();

// récupérer le nom de la patrouille:
$patrolName = getPatrolName($patrolId);

// update in the database all the bikers time of this patrol:
$query = 'update t_biker set '.$timeField.'="'.$currentTime.'"  where patrol_id="'.$patrolId.'"';
if(!mysql_query($query))
{
	exit('request failed: '.$query);
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
	<?php	

	//format into a human-readable way:
	$currentTimeHuman = date("H:i:s",$currentTime);
	echo 'la patrouille des '.$patrolName.' est partie a: <h3>'.$currentTimeHuman,'</h3>';
	
	
	displayFooter();
	?>
		
	</body>
</html>