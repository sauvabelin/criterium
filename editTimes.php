<?php
	/*
		file: 	editTimes.php
		author: Benoît Uffer
		
		On demande à l'utilisateur de modifier les temps de départ et d'arrivée d'un Biker.
	*/

include_once("globals.php");
include_once("sql.php");      


// on récupère l'id de ce Biker (passé en paramètre GET)
$bikerId = getParameterGET("biker_id");

// connection à la base de donnée
connect();


// on récupère les données de ce biker:
$query = 'select * from t_biker where id="'.$bikerId.'"';
$res = mysql_query($query);
$row = mysql_fetch_assoc($res);
$dossard = $row["dossard"];
$patrolId = $row["patrol_id"];
if($dossard==UNKNOWN)
{
	// on affiche pas le "-1" si le dossard est inconnu
	$dossard = "inconnu";
}
$firstName = $row["firstName"];
$lastName = $row["lastName"];
$startTime1 = $row["startTime1"];
$endTime1 = $row["endTime1"];
$startTimeAttack = $row["startTimeAttack"];
$endTimeAttack = $row["endTimeAttack"];
$startTime2 = $row["startTime2"];
$endTime2 = $row["endTime2"];

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		// affichage des Infos du biker:
		echo 'modifier les temps pour:';
		echo '<h3> ['.$dossard.'] '.$firstName.' '.$lastName.'</h3>';
		
		// avertir l'utilisateur que ce n'est pas la méthode "normale" de modifier les temps ici
		echo '<span class="alert">Attention: </span>';
		echo 'Cette page n\'est pas supposé être utilisée, sauf pour corriger une erreur. Normalement:<br>';
		echo ' les temps de départs sont fixé lors des départs de la patrouille (lien "départ d\'une patrouille..." en page d\'accueil)<br>';
		echo ' les temps d\'arrivées sont fixé lors de l\'arrivé d\'un participant (lien "Etape de..." en page d\'accueil)<br>';
		echo '<br><br>';
		
		// on met dans des variables séparées les heures, minues, secondes pour chacun des temps:
		// pour faire ça, on commence a tout mettre à "??". Ensuite on cherche les vrais valeurs dans la base de donnée,
		// SI la vraie valeur n'est pas "UNKNOWN".
		
		$start1HH = "??";		$start1MM = "??";		$start1SS = "??";
		$end1HH 	= "??";		$end1MM 	= "??";		$end1SS 	= "??";
		$startAHH = "??";		$starAHHMM = "??";		$startASS = "??";
		$endAHH 	= "??";		$endTAHHMM 	= "??";		$endASS 	= "??";
		$start2HH = "??";		$start2MM = "??";		$start2SS = "??";
		$end2HH 	= "??";		$end2MM 	= "??";		$end2SS 	= "??";

		if($startTime1 != UNKNOWN)
		{
			$start1HH = date("H",$startTime1);
			$start1MM = date("i",$startTime1);
			$start1SS = date("s",$startTime1);
		}
		if($endTime1 != UNKNOWN)
		{
			$end1HH 	= date("H",$endTime1);
			$end1MM 	= date("i",$endTime1);
			$end1SS 	= date("s",$endTime1);
		}
		
		if($startTimeAttack != UNKNOWN)
		{
			$startAHH = date("H",$startTimeAttack);
			$startAMM = date("i",$startTimeAttack);
			$startASS = date("s",$startTimeAttack);
		}
		if($endTimeAttack != UNKNOWN)
		{
			$endAHH 	= date("H",$endTimeAttack);
			$endAMM 	= date("i",$endTimeAttack);
			$endASS 	= date("s",$endTimeAttack);
		}
		
		if($startTime2 != UNKNOWN)
		{
			$start2HH = date("H",$startTime2);
			$start2MM = date("i",$startTime2);
			$start2SS = date("s",$startTime2);
		}
		if($endTime2 != UNKNOWN)
		{
			$end2HH 	= date("H",$endTime2);
			$end2MM 	= date("i",$endTime2);
			$end2SS 	= date("s",$endTime2);
		}
		
		
		echo '<form action="editTimesDone.php" method="post">';
		echo '<input type="hidden" name="biker_id" value="'.$bikerId.'">';
		echo '<input type="hidden" name="patrol_id" value="'.$patrolId.'">';
		if(isset($_GET["src"]))
		{
			// il se peut qu'un paramètre de plus, src, soit présent.
			// c'est si on arrive ici en ayant fait admin->tests plutot que admin->edit troupe->edite patrouille->edit biker.
			// dans ce cas, on le passe pour que la redirection automatique se fasse au bon endroit:
			$src = $_GET["src"];
			echo '<input type="hidden" name="src" value="'.$src.'">';
			
		}
		echo 'Heure de départ Matin: ';
		echo '<input type="text" name="start1HH" value="'.$start1HH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="start1MM" value="'.$start1MM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="start1SS" value="'.$start1SS.'" size="2">';
		echo 's ';
		echo '<br>';
		echo 'Heure d\'arrivée Matin: ';
		echo '<input type="text" name="end1HH" value="'.$end1HH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="end1MM" value="'.$end1MM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="end1SS" value="'.$end1SS.'" size="2">';
		echo 's ';
		echo '<br><br>';
		echo 'Heure de départ contre la monte: ';
		echo '<input type="text" name="startAHH" value="'.$startAHH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="startAMM" value="'.$startAMM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="startASS" value="'.$startASS.'" size="2">';
		echo 's ';
		echo '<br>';
		echo 'Heure d\'arrivée contre la montre: ';
		echo '<input type="text" name="endAHH" value="'.$endAHH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="endAMM" value="'.$endAMM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="endASS" value="'.$endASS.'" size="2">';
		echo 's ';
		echo '<br><br>';
		echo 'Heure de départ Apres-midi: ';
		echo '<input type="text" name="start2HH" value="'.$start2HH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="start2MM" value="'.$start2MM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="start2SS" value="'.$start2SS.'" size="2">';
		echo 's ';
		echo '<br>';
		echo 'Heure d\'arrivée Apres-midi: ';
		echo '<input type="text" name="end2HH" value="'.$end2HH.'" size="2">';
		echo 'h ';
		echo '<input type="text" name="end2MM" value="'.$end2MM.'" size="2">';
		echo 'm ';
		echo '<input type="text" name="end2SS" value="'.$end2SS.'" size="2">';
		echo 's ';
		echo '<br><br>';
		echo '<input type="submit" value="Executer">';
		echo '</form>';
		
		displayFooter();
		
		?>
		
	</body>
</html>