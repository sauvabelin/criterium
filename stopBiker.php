<?php
/*
	file: 	stopBiker.php
	author: Benoît Uffer
	
	Ce fichier permet à l'utilisateur d'entrer l'heure d'arrivée d'un dossard à une étape.
	Pour arriver à ce fichier une première fois, l'utilisateur à cliqué sur un lien qui est différent pour l'étape du matin
	ou de l'apres midi. L'étape est ainsi déja connue par la méthode GET quand ce script est executé.
	Le numéro de dossard et l'heure d'arrivée vont étre choisie par l'utilisateur sur cette page.
*/

include_once("globals.php");

// on récupère le timefield (sivant à quelle etape on arrive, on change pas le meme champs dans la base de donnée)
$timeField = getParameterGET("timeField");	

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
		
		<script type="text/javascript">
			function setFocus() {
				document.forms['stopBiker'].elements['dossard'].focus();		
			}
		</script>
	</head>
	
	<body onload="setFocus()">
	
	
	<?php
		// on affiche un titre différent suivant la "phase"
		if($timeField=="endTime1")
		{
			echo '<h3>Etape du matin</h3>';
		}
		if($timeField=="endTimeAttack")
		{
			echo '<h3>Contre le montre</h3>';
		}
		if($timeField=="endTime2")
		{
			echo '<h3>Etape de l\'apres-midi</h3>';
		}
	
	
	/*
	Voici le formulaire qui permet d'entrer le numéro du dossard, et le temps d'arrivée:
	a choix: en utilisant le temps de l'ordinateur, ou en entrant une heure manuellement.
	on passe le timefield en GET
	*/
echo '	<form name="stopBiker" action="stopBikerCheck.php?timeField='.$timeField.'" method="POST">';
echo '		<h3>1) Numero du dossard:</h3>                ';
echo '		<label for="pmId">Numero du dossard:</label>';
echo '		<input type="text" name="dossard" id="dossardId" size="3">';
echo '		<br>';
echo '		<h3>2) Choisissez la méthode:</h3>';
echo '		<input type="radio" name="method" value="system" id="systemId" checked>';
echo '		<label for="systemId">Utiliser le temps de l\'ordinateur</label>';
echo '		<br>';
echo '		<input type="radio" name="method" value="manual" id="manualId">';
echo '		<label for="manualId">Entrez un temps manuellement:</label>';
echo '		<br><br>';
echo '		<input type="text" name="hh" value="HH" size="2">:<input type="text" name="mm" value="MM" size="2">:<input type="text" name="ss" value="SS" size="2">';
echo '	<br></br>';
echo '		<input type="submit" value="STOP">';
echo '	</form>';
	
	

	// affichage du pied de page:
	displayFooter()
	?>
		
	</body>
</html>