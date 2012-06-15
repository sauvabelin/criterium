<?php
	/*
		file: 	INFO_systemTime.php
		author: Benoît Uffer
		
		Ce fichier permet à l'utilisateur de connaitre le temps systeme actuel, ou le temps system correspondant à une heure
		précise (entrée à la main) si besoin est.
	*/

include_once("globals.php");

//vérifier si il faut convertir un tps System en Heure
if(isset($_GET["tps"]))
{
	$convertS2H = TRUE;
	$tps=$_GET["tps"];
	$timeToConvert = $tps;
	$timeConverted = date("H:i:s",$tps);
}
else
{
	$convertS2H = FALSE;
}

//vérifier si il faut convertir une heure en tps System
if(isset($_GET["hh"]))
{
	$convertH2S = TRUE;
	$hh=$_GET["hh"];
	$mm=$_GET["mm"];
	$ss=$_GET["ss"];
	$timeToConvert = $hh.' h '.$mm.' m '.$ss.' s';
	$timeConverted = mktime($hh,$mm,$ss);
}
else
{
	$convertH2S = FALSE;
}

// on prend l'heure système
$systemTime = time();
// on la convertit à un format "human-readable"
$systemTimeHuman = date("H \h i \m s \s",$systemTime);


?>


<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		<br><br>
		
		<?php
		
		// si il y a eu une conversion a effectuer, on affiche le resultat (tps UNIX et format "human-readable")
		if($convertS2H == TRUE)
		{
			echo 'conversion system vers heure<br><br>';
			echo '<h3>temps a convertir = [ '.$timeToConvert.' ]</h3>';
			echo '<h3>temps system converti = [ '.$timeConverted.' ]</h3>';
			echo '<hr>';
		}
		else if($convertH2S == TRUE)
		{
			echo 'conversion heure vers system<br><br>';
			echo '<h3>temps a convertir = [ '.$timeToConvert.' ]</h3>';
			echo '<h3>temps system converti = [ '.$timeConverted.' ]</h3>';
			echo '<hr>';
		}
		else
		{
			// on affiche l'heure systeme actuelle
			echo '<h3>temps systeme = [ '.$systemTime.' ]</h3>';
			echo '<h3>format lisible = [ '.$systemTimeHuman.' ]</h3>';
		}
		
		echo '<br>';
		
			
		
		
		?>
		
		<!--
		Voici le formulaire qui permet à l'utilisateur d'entrer une heure manuellement pour la convertir en tps UNIX:
		-->
		<br><br><br>
		<form action="INFO_systemTime.php" method="GET">
			<h3>convertir une heure en temps system:</h3>
			<input type="text" name="hh" value="HH" size="2">:<input type="text" name="mm" value="MM" size="2">:<input type="text" name="ss" value="SS" size="2">
			<br><br>
			<input type="submit" value="Convertir">
		</form>
		
		<!--
		Voici le formulaire qui permet à l'utilisateur d'entrer un temps UNIX manuellement pour le convertir en heure:
		-->
		<br><br><br>
		<form action="INFO_systemTime.php" method="GET">
			<h3>convertir un temps system en heure:</h3>
			<input type="text" name="tps" value="" size="12">
			<br><br>
			<input type="submit" value="Convertir">
		</form>
		
		<?php
			displayFooter();
		?>
		
	</body>
</html>