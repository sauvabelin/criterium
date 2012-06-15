<?php
	/*
		file: 	WARNING_createVirginDB.php
		author: Benoît Uffer
	*/

include_once("sql.php");
include_once("globals.php");

// connect db:
connect();

$createBikerTable  	=	"CREATE TABLE t_biker (id INTEGER NOT NULL AUTO_INCREMENT, dossard INTEGER, firstName TEXT, lastName TEXT, birthYear INTEGER, patrol_id INTEGER, startTime1 INTEGER, endTime1 INTEGER, startTimeAttack INTEGER, endTimeAttack INTEGER, startTime2 INTEGER, endTime2 INTEGER, PRIMARY KEY(id))";
$createpatrolTable 	= "CREATE TABLE t_patrol (id INTEGER NOT NULL AUTO_INCREMENT, name TEXT, troop_id INTEGER, PRIMARY KEY(id))";
$createtroopTable 	= "CREATE TABLE t_troop (bsNum INTEGER, name TEXT, type INTEGER)";
$createYearTable		= "CREATE TABLE t_year (year INTEGER)";
$createLimitsTable		= "CREATE TABLE t_limits (minBiker INTEGER, maxBiker INTEGER, bonusSeconds INTEGER)";
$createTimeAttackFactor		= "CREATE TABLE t_factor (timeAttackFactor INTEGER)";


// 1) drop existing tables;
mysql_query("drop table t_biker");
mysql_query("drop table t_patrol");	
mysql_query("drop table t_troop");
mysql_query("drop table t_year");
mysql_query("drop table t_factor");


// 2) create new tables:
if(!mysql_query($createBikerTable))			{exit("la création de la table des bikers a échoué");}
if(!mysql_query($createpatrolTable)){exit("la création de la table des patrouilles a échoué");}
if(!mysql_query($createtroopTable))		{exit("la création de la table des troupes a échoué");}
if(!mysql_query($createYearTable))		{exit("la création de la table des années a échoué");}
if(!mysql_query($createLimitsTable))		{exit("la création de la table des limites a échoué");}
if(!mysql_query($createTimeAttackFactor))		{exit("la création de la table des temps TA a échoué");}

// 3) fill tables (we fill only troops and patrols as biker will be filled manually before criterium starts
//troops gars:
if(!mysql_query('insert into t_troop values ("'.ZANFLEURON.'", "Zanfleuron", "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.MANLOUD.'", 		"Manloud",    "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.NEUVAZ.'", 		"Neuvaz",     "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.CHANDELARD.'", "Chandelard", "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.BERISAL.'", 		"Berisal",    "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.MONTFORT.'", 	"Montfort",   "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.LOVEGNO.'", 		"Lovegno",    "'.ECLAIREUR.'")')){exit("la création d'une troop a échoué");}
//troops filles:
if(!mysql_query('insert into t_troop values ("'.SOLALEX.'", "Solalex",   "'.ECLAIREUSE.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.GRAMMONT.'", "Grammont",  "'.ECLAIREUSE.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.ARMINA.'", "Armina",    "'.ECLAIREUSE.'")')){exit("la création d'une troop a échoué");}
//troops rouges garçons:
if(!mysql_query('insert into t_troop values ("'.ROVEREAZ.'", "Rovereaz",    "'.ROUGE_G.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.ORZIVAL.'", "Orzival",    "'.ROUGE_G.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.TSALION.'", "Tsalion",    "'.ROUGE_G.'")')){exit("la création d'une troop a échoué");}
//troops rouges filles:
if(!mysql_query('insert into t_troop values ("'.SESAL.'", "Sesal",    "'.ROUGE_F.'")')){exit("la création d'une troop a échoué");}
if(!mysql_query('insert into t_troop values ("'.TAMARO.'", "Tamaro",    "'.ROUGE_F.'")')){exit("la création d'une troop a échoué");}
//le clan
if(!mysql_query('insert into t_troop values ("'.CLAN.'", "Le Clan",    "'.CLANS.'")')){exit("la création d'une troop a échoué");}
//patrol gars:
if(!mysql_query('insert into t_patrol values ("NULL", "Aigles", 				"'.ZANFLEURON.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Castors", 			"'.ZANFLEURON.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Lynx", 					"'.ZANFLEURON.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Bouquetins", 		"'.ZANFLEURON.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Loups", 				"'.MANLOUD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Hermines", 			"'.MANLOUD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Eperviers", 		"'.MANLOUD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Taureaux", 			"'.MANLOUD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Cigognes", 			"'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Antilopes", 		"'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Loutres", 			"'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Hérons", 				"'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Renards", 			"'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Chauves-souris","'.NEUVAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Rennes",				"'.CHANDELARD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Marmottes",			"'.CHANDELARD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Poussins-Coqs",	"'.CHANDELARD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Cygnes",				"'.CHANDELARD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Yacks",					"'.CHANDELARD.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Pantheres",			"'.BERISAL.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Koalas",				"'.BERISAL.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Cerfs",					"'.BERISAL.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Faucons",				"'.BERISAL.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Jean-Bart",			"'.MONTFORT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Fregate",				"'.MONTFORT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Surcouf",				"'.MONTFORT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Galion",				"'.MONTFORT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Cobras",				"'.LOVEGNO.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Phenix",				"'.LOVEGNO.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Tigres",				"'.LOVEGNO.'")')){exit("la création d'une patrol a échoué");}
//patrol filles:
if(!mysql_query('insert into t_patrol values ("NULL", "Hirondelles",		"'.SOLALEX.'")')){exit("la création d'une patrol a échoué");}   
if(!mysql_query('insert into t_patrol values ("NULL", "Ratons-Laveurs","'.SOLALEX.'")')){exit("la création d'une patrol a échoué");}   
if(!mysql_query('insert into t_patrol values ("NULL", "Goelands",			"'.SOLALEX.'")')){exit("la création d'une patrol a échoué");}   
if(!mysql_query('insert into t_patrol values ("NULL", "Pandas",				"'.SOLALEX.'")')){exit("la création d'une patrol a échoué");}   
if(!mysql_query('insert into t_patrol values ("NULL", "Gazelles",			"'.SOLALEX.'")')){exit("la création d'une patrol a échoué");}   
if(!mysql_query('insert into t_patrol values ("NULL", "Licornes",			"'.GRAMMONT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Chevreuils",		"'.GRAMMONT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Fennecs",				"'.GRAMMONT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Okapis",				"'.GRAMMONT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Kangourous",		"'.GRAMMONT.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Impalas",				"'.ARMINA.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Mangoustes",		"'.ARMINA.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Coyotes",				"'.ARMINA.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "Cameleons",				"'.ARMINA.'")')){exit("la création d'une patrol a échoué");}

//dummy patrols for Rouges:
if(!mysql_query('insert into t_patrol values ("NULL", "tout Rovereaz",				"'.ROVEREAZ.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "tout Orzival",				"'.ORZIVAL.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "tout Tsalion",				"'.TSALION.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "tout Sesal",				"'.SESAL	.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "tout Tamaro",				"'.TAMARO	.'")')){exit("la création d'une patrol a échoué");}
if(!mysql_query('insert into t_patrol values ("NULL", "tout le Clan",				"'.CLAN	.'")')){exit("la création d'une patrol a échoué");}

// minimum year:
// l'année minimum est l'année de naissance des gars qui ont 15 ans cette année
$minimalYear = date("Y")-15;
if(!mysql_query('insert into t_year values ("'.$minimalYear.'")')){exit("la création d'une year a échoué");}
	
// limits: creer les limites par défaut:
// - en dessous de 3 gars/fille par patrouille, la patrouille ne compte pas au classement des patrouilles
// - au dessus de 6 gars/fille par patrouille, il y a un bonus pour la patrouille
// - le bonus est de 30 secondes par gars/fille en plus
if(!mysql_query('insert into t_limits values ("3","6","30")')){exit("la création d'une limit a échoué");}

// time attack factor:
// nombre par lequel le temps du contre la montre doit être multiplié. Par défaut le contre la montre vaut 5 fois plus.
if(!mysql_query('insert into t_factor values ("5")')){exit("la création du facteur a échoué");}

?>

<html>
	<head>
		<title>create virgin DB</title>
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
