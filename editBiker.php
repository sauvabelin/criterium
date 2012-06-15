<?php
	/*
		file: 	editBiker.php
		author: Benoît Uffer
		
		On demande à l'utilisateur de modifier les paramètres d'un Biker.
		(ça peut être le nom, le prénom ou le numéro de dossard)
	*/

include_once("globals.php");
include_once("sql.php");      


// on récupère l'id de ce Biker (passé en paramètre GET)
$bikerId = getParameterGET("id");

// connection à la base de donnée
connect();


// on récupère les données de ce biker:
$query = 'select * from t_biker where id="'.$bikerId.'"';
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$biker["id"] = $row["id"];
$biker["dossard"] = $row["dossard"];
$biker["birthYear"] = $row["birthYear"];
if($biker["birthYear"]==UNKNOWN)
{
	// on affiche pas le "-1" si l'année est inconnu, pour ne pas induire en erreur l'utilisateur
	$biker["birthYear"] = "";
}
if($biker["dossard"]==UNKNOWN)
{
	// on affiche pas le "-1" si le dossard est inconnu, pour ne pas induire en erreur l'utilisateur
	$biker["dossard"] = "";
}
$biker["firstName"] = $row["firstName"];
$biker["lastName"] = $row["lastName"];
$biker["patrol_id"] = $row["patrol_id"];

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		
		
		// on affiche un formulaire avec les champs déja remplis avec les champs actuels		
		echo '<form action="editBikerDone.php" method="post">';
		echo '<input type="hidden" name="patrolId" value="'.$biker["patrol_id"].'">';
		echo '<input type="hidden" name="bikerId" value="'.$bikerId.'">';
		if(isset($_GET["src"]))
		{
			// il se peut qu'un paramètre de plus, src, soit présent.
			// c'est si on arrive ici en ayant fait admin->tests plutot que admin->edit troupe->edite patrouille->edit biker.
			// dans ce cas, on le passe pour que la redirection automatique se fasse au bon endroit:
			$src = $_GET["src"];
			echo '<input type="hidden" name="src" value="'.$src.'">';
			
		}
		
		echo '<table>';
		echo '<tr>';
		echo '	<td align="right"><label for="dossardId">Numéro Dossard:</label></td>';
		echo '	<td><span class="leftEmptyIfUnknown">*</span></td>';
		echo '	<td><input type="text" name="dossard" id="dossardId" value="'.$biker["dossard"].'" size="4"></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td align="right"><label for="firstNameId">Prénom:</label></td>';
		echo '	<td><span class="required">*</span></td>';
		echo '	<td><input type="text" name="firstName" id="firstNameId" value="'.$biker["firstName"].'"></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td align="right"><label for="lastNameId">Nom:</label></td>';
		echo '	<td><span class="required">*</span></td>';
		echo '	<td><input type="text" name="lastName" id="lastNameId" value="'.$biker["lastName"].'"></td>';
		echo '</tr>';
		echo '<tr>';
		echo '	<td align="right"><label for="birthYearId">Année de Naissance:</label></td>';
		echo '	<td><span class="leftEmptyIfUnknown">*</span></td>';
		echo '	<td><input type="text" name="birthYear" id="birthYearId" value="'.$biker["birthYear"].'"></td>';
		echo '</tr>';
		echo '</table>';

				
/*		
		echo '<label for="dossardId">Numéro Dossard:</label>';
		echo '<input type="text" name="dossard" id="dossardId" value="'.$biker["dossard"].'" size="4">';
		echo ' (si le numero n\'est pas encore connu, laissez ce champ vide)';
		echo '<br>';
		echo '<label for="firstNameId">Prénom:</label>';
		echo '<input type="text" name="firstName" id="firstNameId" value="'.$biker["firstName"].'">';
		echo '<br>';
		echo '<label for="lastNameId">Nom:</label>';
		echo '<input type="text" name="lastName" id="lastNameId" value="'.$biker["lastName"].'">';
		echo '<br>';
		echo '<label for="birthYearId">Année de Naissance:</label>';
		echo '<input type="text" name="birthYear" id="birthYearId" value="'.$biker["birthYear"].'">';
		echo '<br>';
*/
		echo '<input type="Submit" value="MODIFIER">';
		echo '</form>';
		
		echo '<span class="required">*</span> : champ obligatoire';
		echo '<br>';
		echo '<span class="leftEmptyIfUnknown">*</span> : laisser vide si pas encore connu.';
		
		displayFooter();
		
		?>
		
	</body>
</html>