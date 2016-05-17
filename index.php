<?php
	/*
		file: 	criterium.php
		author: Benoît Uffer
		
		c'est le point d'entrée de tout le programme criterium
	*/
include_once("sql.php");
include_once("globals.php");

// connection à la base de donnée
connect();

// on essaye de créer les tables t_biker, t_troop et t_patrol (au cas ou c'est la toute première utilisation)
// si elle existent déja, ça va simplement échouer.
$createBikerTable  	=	"CREATE TABLE t_biker (id INTEGER NOT NULL AUTO_INCREMENT, dossard INTEGER, firstName TEXT, lastName TEXT, birthYear INTEGER, patrol_id INTEGER, startTime1 INTEGER, endTime1 INTEGER, startTime2 INTEGER, endTime2 INTEGER, PRIMARY KEY(id))";
$createpatrolTable 	= "CREATE TABLE t_patrol (id INTEGER NOT NULL AUTO_INCREMENT, name TEXT, troop_id INTEGER, PRIMARY KEY(id))";
$createtroopTable 	= "CREATE TABLE t_troop (bsNum INTEGER, name TEXT, type INTEGER)";
$createYearTable		= "CREATE TABLE t_year (year INTEGER)";
$createLimitsTable		= "CREATE TABLE t_limits (minBiker INTEGER, maxBiker INTEGER, bonusSeconds INTEGER)";
mysql_query($createBikerTable);
mysql_query($createpatrolTable);
mysql_query($createtroopTable);
if(mysql_query($createYearTable))
{
	// si la creation a reussi, il faut mettre des valeurs par défaut:
	// minimum year:
	// l'année minimum est l'année de naissance des gars qui ont 15 ans cette année
	$minimalYear = date("Y")-15;
	if(!mysql_query('insert into t_year values ("'.$minimalYear.'")')){exit("la création d'une year a échoué");}
}
if(mysql_query($createLimitsTable))
{
	// si la creation a reussi, il faut mettre des valeurs par défaut:
	// - en dessous de 3 gars/fille par patrouille, la patrouille ne compte pas au classement des patrouilles
	// - au dessus de 6 gars/fille par patrouille, il y a un bonus pour la patrouille
	// - le bonus est de 30 secondes par gars/fille en plus
	if(!mysql_query('insert into t_limits values ("3","6","30")')){exit("la création d'une patrol a échoué");}
}

// on récupère la liste de toutes les troupes existantes dans la base de donnnées, leurs identificatuers (bsNum) et leurs noms:
$query = 'select * from t_troop order by bsNum';
$res = mysql_query($query);
// on récupère le nombre d'enregistrement:
$number_of_troop = mysql_num_rows($res);
for($j=0;$j<$number_of_troop;$j++)
{
	$row = mysql_fetch_assoc($res);
	$troupe[$j]["bsNum"] = $row["bsNum"];
	$troupe[$j]["name"] = $row["name"];
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		
	</head>
	
	<body>
		
		<h3>Donner le signal de départ d'une patrouille</h3>
		<?php
			if($number_of_troop>0)
			{
				for($j=0;$j<$number_of_troop;$j++)
				{
					echo '<a href="startTroop.php?bsNum='.$troupe[$j]["bsNum"].'">départ d\'une patrouille de '.$troupe[$j]["name"].'</a><br>';
				}
			}
			else
			{
				echo '<span class="alert">Attention:</span>';
				echo 'il n\'existe encore aucune troupe dans la base de donnée';
			}
		?>
		
		<h3>Arrivée d'un participant</h3>
		<a href="stopBiker.php?timeField=endTime1">Etape du matin</a>
		<br>
		<a href="stopBiker.php?timeField=endTimeAttack">Contre la montre</a>
		<br>
		<a href="stopBiker.php?timeField=endTime2">Etape de l'après-midi</a>
		
		<h3>Resultats</h3>
		(avant d'afficher les résultats, pensez à faire les tests proposés dans la page d'administration)
		<?php
		br(2);
		echo '<a href="resultsPerYear.php">Classement des Gars/Filles/Rouges par année de naissance</a><br>';
		echo '<a href="resultsBikers.php">Classement des Gars/Filles/Rouges tous ages confondus</a><br>';
		echo '<a href="resultsPatrols.php">Classement des Patrouilles</a><br>';
		echo '<a href="resultsTroops.php">Classement des Troupes</a><br>';

		displayFooter();
		?>

		
	</body>
</html>

