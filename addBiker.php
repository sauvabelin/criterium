<?php
	/*
		file: 	addBiker.php
		author: Benoît Uffer
		
		On est en train d'éditer une patrouille (la patrolId est en variable GET.
		cette page affiche un formulaire qui permet d'ajouter un gars/fille
		(num de dossard, prénom et nom)
	*/

include_once("globals.php");
include_once("sql.php");      


// on recupere juste l'id de la patrouille pour le refiler au prochain script (qui ajoute le biker à sa patrouille)
$patrolId = getParameterGET("patrol_id");



?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		echo '<form action="addBikerDone.php?patrol_id='.$patrolId.'" method="post">';
		?>
		
		<form action="addBikerDone.php" method="post">
			
			<table>
				<tr>
					<td align="right"><label for="dossardId">Numéro Dossard:</label></td>
					<td><span class="leftEmptyIfUnknown">*</span></td>
					<td><input type="text" name="dossard" id="dossardId" value="" size="4"></td>
				</tr>
				<tr>
					<td align="right"><label for="firstNameId">Prénom:</label></td>
					<td><span class="required">*</span></td>
					<td><input type="text" name="firstName" id="firstNameId" value=""></td>
				</tr>
				<tr>
					<td align="right"><label for="lastNameId">Nom:</label></td>
					<td><span class="alert">*</span></td>
					<td><input type="text" name="lastName" id="lastNameId" value=""></td>
				</tr>
				<tr>
					<td align="right"><label for="birthYearId">Année de naissance:</label></td>
					<td><span class="leftEmptyIfUnknown">*</span></td>
					<td><input type="text" name="birthYear" id="birthYearId" value="" size="4"></td>
				</tr>
			</table>
			<br>
			<input type="Submit">
	
		</form>
		
		<span class="required">*</span> : champ obligatoire
		<br>
		<span class="leftEmptyIfUnknown">*</span> : laisser vide si pas encore connu.
		
		<?phpdisplayFooter()?>
		
	</body>
</html>