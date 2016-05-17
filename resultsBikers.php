<?php
	/*
		file: 	resultsBiker.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


// connection à la base de données:
connect();


// minimalYear:
// (les gars/filles qui sont nés avant cette date ne sont pas pris en compte dans le classement)
$minYear = getMinimalYear();

//--------------------------------------------------------------------------------------------------
// Classement des ECLAIREURS uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUR.' AND birthYear >='.$minYear.' ORDER BY totalTime';
$res=mysql_query($query);
$number_of_boys = mysql_num_rows($res);
for($i=0;$i<$number_of_boys;$i++)
{
	$row = mysql_fetch_assoc($res);
	$boy[$i]["lastName"] = $row["lastName"];
	$boy[$i]["firstName"] = $row["firstName"];
  $boy[$i]["dossard"] = $row["dossard"];
	$boy[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$boy[$i]["patrolName"] = $row["patrolName"];
	$boy[$i]["troopName"] = $row["troopName"];
}

//--------------------------------------------------------------------------------------------------
// Classement des ECLAIREUSES uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUSE.' AND birthYear >='.$minYear.' ORDER BY totalTime';
$res=mysql_query($query);
$number_of_girls = mysql_num_rows($res);
for($i=0;$i<$number_of_girls;$i++)
{
	$row = mysql_fetch_assoc($res);
	$girl[$i]["lastName"] = $row["lastName"];
	$girl[$i]["firstName"] = $row["firstName"];
  $girl[$i]["dossard"] = $row["dossard"];
	$girl[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$girl[$i]["patrolName"] = $row["patrolName"];
	$girl[$i]["troopName"] = $row["troopName"];
}

//--------------------------------------------------------------------------------------------------
// Classement des ROUGES (garçons) uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ROUGE_G.' OR ( t_troop.type='.ECLAIREUR.' AND birthYear <'.$minYear.' AND birthYear > 1900) ORDER BY totalTime';
$res=mysql_query($query);
$number_of_red_boys = mysql_num_rows($res);
for($i=0;$i<$number_of_red_boys;$i++)
{
	$row = mysql_fetch_assoc($res);
	$red_boy[$i]["lastName"] = $row["lastName"];
	$red_boy[$i]["firstName"] = $row["firstName"];
  $red_boy[$i]["dossard"] = $row["dossard"];
	$red_boy[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$red_boy[$i]["troopName"] = $row["troopName"];
	$red_boy[$i]["patrolName"] = $row["patrolName"];
}

//--------------------------------------------------------------------------------------------------
// Classement des ROUGES (filles) uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ROUGE_F.' OR ( t_troop.type='.ECLAIREUSE.' AND birthYear <'.$minYear.' AND birthYear > 1900) ORDER BY totalTime';
$res=mysql_query($query);
$number_of_red_girls = mysql_num_rows($res);
for($i=0;$i<$number_of_red_girls;$i++)
{
	$row = mysql_fetch_assoc($res);
	$red_girl[$i]["lastName"] = $row["lastName"];
	$red_girl[$i]["firstName"] = $row["firstName"];
  $red_girl[$i]["dossard"] = $row["dossard"];
	$red_girl[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$red_girl[$i]["troopName"] = $row["troopName"];
	$red_girl[$i]["patrolName"] = $row["patrolName"];
}


//--------------------------------------------------------------------------------------------------
// Classement des GRIS (garçons) uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.CLANG.' ORDER BY totalTime';
$res=mysql_query($query);
$number_of_grey_boys = mysql_num_rows($res);
for($i=0;$i<$number_of_grey_boys;$i++)
{
	$row = mysql_fetch_assoc($res);
	$grey_boy[$i]["lastName"] = $row["lastName"];
	$grey_boy[$i]["firstName"] = $row["firstName"];
  $grey_boy[$i]["dossard"] = $row["dossard"];
	$grey_boy[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$grey_boy[$i]["troopName"] = $row["troopName"];
}

//--------------------------------------------------------------------------------------------------
// Classement des GRIS (filles) uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.CLANF.' ORDER BY totalTime';
$res=mysql_query($query);
$number_of_grey_girls = mysql_num_rows($res);
for($i=0;$i<$number_of_grey_girls;$i++)
{
	$row = mysql_fetch_assoc($res);
	$grey_girl[$i]["lastName"] = $row["lastName"];
	$grey_girl[$i]["firstName"] = $row["firstName"];
  $grey_girl[$i]["dossard"] = $row["dossard"];
	$grey_girl[$i]["totalTime"] = gmdate("H \h i \m s \s",$row["totalTime"]);
	$grey_girl[$i]["troopName"] = $row["troopName"];
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	
	<?php
	
		echo '<span class="alert">Les gars/filles qui sont nés AVANT '.$minYear.' sont dans le classement avec les rouges</span></br>';
		echo '(cette date peut être modifiée dans le panneau d\'administration)';
		echo '<br><br>';
	
	
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des ECLAIREURS:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des gars:</div>';
		echo '(sauf ceux nés avant '.$minYear.')';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td><td>Troupe</td><td>Patrouille</td>';
		echo '</tr>';
		for($i=0;$i<$number_of_boys;$i++)
		{
			echo '<tr>';
      echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$boy[$i]["totalTime"].'</td>';
			echo '<td align="center">'.$boy[$i]["dossard"].'</td>';
			echo '<td>'.$boy[$i]["lastName"].'</td>';
			echo '<td>'.$boy[$i]["firstName"].'</td>';
			echo '<td>'.$boy[$i]["troopName"].'</td>';
			echo '<td>'.$boy[$i]["patrolName"].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des ECLAIREUSES:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des filles:</div>';
		echo '(sauf celles nées avant '.$minYear.')';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td><td>Troupe</td><td>Patrouille</td>';
		echo '</tr>';
		for($i=0;$i<$number_of_girls;$i++)
		{
			echo '<tr>';
      echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$girl[$i]["totalTime"].'</td>';
			echo '<td align="center">'.$girl[$i]["dossard"].'</td>';
			echo '<td>'.$girl[$i]["lastName"].'</td>';
			echo '<td>'.$girl[$i]["firstName"].'</td>';
			echo '<td>'.$girl[$i]["troopName"].'</td>';
			echo '<td>'.$girl[$i]["patrolName"].'</td>';
			echo '</tr>';
		}
		echo '</table>';
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des ROUGES (garçons):
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des rouges (garçons):</div>';
		echo '(et des gars nés avant '.$minYear.')';
    
    if($number_of_red_boys > 0) {
      
      echo '<table border ="1">';
      echo '<tr>';
      echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td><td>Troupe</td><td>Patrouille</td>';
      echo '</tr>';
      for($i=0;$i<$number_of_red_boys;$i++)
      {
        echo '<tr>';
        echo '<td align="center">'.($i+1).'</td>';
        echo '<td>'.$red_boy[$i]["totalTime"].'</td>';
        echo '<td align="center">'.$red_boy[$i]["dossard"].'</td>';
        echo '<td>'.$red_boy[$i]["lastName"].'</td>';
        echo '<td>'.$red_boy[$i]["firstName"].'</td>';
        echo '<td>'.$red_boy[$i]["troopName"].'</td>';
        echo '<td>'.$red_boy[$i]["patrolName"].'</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
      echo '<p>Il n\'y a personne dans cette catégorie</p>';
    }
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des ROUGES (filles):
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des rouges (filles):</div>';
		echo '(et des filles nées avant '.$minYear.')';
    
    if($number_of_red_girls > 0) {
      echo '<table border ="1">';
      echo '<tr>';
      echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td><td>Troupe</td><td>Patrouille</td>';
      echo '</tr>';
      for($i=0;$i<$number_of_red_girls;$i++)
      {
        echo '<tr>';
        echo '<td align="center">'.($i+1).'</td>';
        echo '<td>'.$red_girl[$i]["totalTime"].'</td>';
        echo '<td align="center">'.$red_girl[$i]["dossard"].'</td>';
        echo '<td>'.$red_girl[$i]["lastName"].'</td>';
        echo '<td>'.$red_girl[$i]["firstName"].'</td>';
        echo '<td>'.$red_girl[$i]["troopName"].'</td>';
        echo '<td>'.$red_girl[$i]["patrolName"].'</td>';
        echo '</tr>';
      }
      echo '</table>';    
    } else {
      echo '<p>Il n\'y a personne dans cette catégorie</p>';
    }
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des GRIS (garçons):
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des gris (garçons):</div>';
    
    if($number_of_grey_boys > 0) {
      echo '<table border ="1">';
      echo '<tr>';
      echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td>';
      echo '</tr>';
      for($i=0;$i<$number_of_grey_boys;$i++)
      {
        echo '<tr>';
        echo '<td align="center">'.($i+1).'</td>';
        echo '<td>'.$grey_boy[$i]["totalTime"].'</td>';
        echo '<td align="center">'.$grey_boy[$i]["dossard"].'</td>';
        echo '<td>'.$grey_boy[$i]["lastName"].'</td>';
        echo '<td>'.$grey_boy[$i]["firstName"].'</td>';
        echo '</tr>';
      }
      echo '</table>';
    } else {
      echo '<p>Il n\'y a personne dans cette catégorie</p>';
    }
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des GRIS (filles):
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des gris (filles):</div>';
		
    if($number_of_grey_girls > 0) {
      echo '<table border ="1">';
      echo '<tr>';
      echo '<td>Rang</td><td>Temps total</td><td>dossard</td><td>Nom</td><td>Prénom</td>';
      echo '</tr>';
      for($i=0;$i<$number_of_grey_girls;$i++)
      {
        echo '<tr>';
        echo '<td align="center">'.($i+1).'</td>';
        echo '<td>'.$grey_girl[$i]["totalTime"].'</td>';
        echo '<td align="center">'.$grey_girl[$i]["dossard"].'</td>';
        echo '<td>'.$grey_girl[$i]["lastName"].'</td>';
        echo '<td>'.$grey_girl[$i]["firstName"].'</td>';
        echo '</tr>';
      }
      echo '</table>';    
    } else {
      echo '<p>Il n\'y a personne dans cette catégorie</p>';
    }
		br(3);
    
	displayFooter();
	?>	
		
	</body>
</html>