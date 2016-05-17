<?php
	/*
		file: 	WARNING_createDummyBikersForTestWithTimes.php
		author: Benoît Uffer
	*/

include_once("sql.php");
include_once("globals.php");

// connect to database:
connect();

/*
**
** 1) on fixe les temps de départs de chaque patrouille:
**
*/

// get num of patrol:
$res = mysql_query("select * from t_patrol");
$num_of_patrol = mysql_num_rows($res);

// morning: first Patrol starts "today" at 08:00:00, then each patrols starts 10 minutes later (+600 seconds)
$morningStart = mktime(8,0,0);
// morning: first Patrol starts "today" at 12:00:00, then each patrols starts 2 minutes later (+120 seconds)
$attackStart = mktime(12,0,0);
// afternoon: first Patrol starts "today" at 14:00:00, then each patrols starts 10 minutes later (+600 seconds)
$afternoonStart = mktime(14,0,0);

for($i=0;$i<$num_of_patrol;$i++)
{
	$startTime1 = $morningStart + 600*$i;
	$startTimeAttack = $attackStart + 120*$i;
	$startTime2 = $afternoonStart + 600*$i;
	mysql_query('update t_biker set startTime1='.$startTime1.', startTimeAttack='.$startTimeAttack.', startTime2='.$startTime2.' where patrol_id='.($i+1).'');
}

/*
**
** 2) on fixe les temps d'arrivées de chaque gars/fille:
**
*/

// get num of bikers:
$res = mysql_query("select * from t_biker");
$num_of_biker = mysql_num_rows($res);

for($i=0;$i<$num_of_biker;$i++)
{
	// pour chaque biker: on retrouve ses heures de départ
	$res = mysql_query('select startTime1, startTimeAttack, startTime2 from t_biker where id='.($i+1));
	$row = mysql_fetch_assoc($res);
	$startTime1 = $row["startTime1"];
	$startTimeAttack = $row["startTimeAttack"];
	$startTime2 = $row["startTime2"];
	
	// on choisit des heures d'arrivée. On considère que les étapes durent un temps aléatoire entre 2 et 4 heures (7200 et 14400 secondes)
	// ou entre 4 et 6 minutes pour le contre la montre (240 et 360 secondes)
	$endTime1 = $startTime1 + rand(7200,14400);
	$endTimeAttack = $startTimeAttack + rand(240,360);
	$endTime2 = $startTime2 + rand(7200,14400);

	mysql_query('update t_biker set endTime1='.$endTime1.', endTimeAttack='.$endTimeAttack.', endTime2='.$endTime2.' where id='.($i+1).'');
}

?>

<html>
	<head>
		<title>create Dummy Bikers for test</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	<body>
	

	
<?php

	echo '<br><br>';
	echo '<span class="prompt">Done!</span>';
	echo '<br><br>';
	displayFooter();

?>
		
	</body>
</html>