<?php
/*
file: 	resultsPerYear.php
author: Benoît Uffer
*/

include_once("globals.php");
include_once("sql.php");


// connection à la base de données:
connect();

// on compte le nombre de gars/filles dont l'année est encore inconnue et si ce nombre est positif, on avertit l'utilisateur
$query = 'select count(*) from t_biker where birthYear="'.UNKNOWN.'"';
$res=mysql_query($query);
$row=mysql_fetch_row($res);
$number_of_biker_with_unknown_birthYear = $row[0];


// on crée ici la liste de toutes les années qui se trouvent dans la base:
$query = 'select birthYear from t_biker GROUP BY birthYear';
$res = mysql_query($query);
$number_of_years = mysql_num_rows($res);
for($i=0;$i<$number_of_years;$i++)
{
	$row = mysql_fetch_assoc($res);
	$year[$i] = $row["birthYear"];

	// pour chaque année, On fait deux classement: garçons et filles.

	//--------------------------------------------------------------------------------------------------
	// Classement des garçons pour l'année "$year[$i]:
	//--------------------------------------------------------------------------------------------------
	$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE ( t_troop.type='.ECLAIREUR.' OR t_troop.type='.ROUGE_G.' OR t_troop.type='.CLANG.' ) AND birthYear ='.$year[$i].' ORDER BY totalTime';
	$inres=mysql_query($query);
	$number_of_boys[$i] = mysql_num_rows($inres);
	for($j=0;$j<$number_of_boys[$i];$j++)
	{
		$inrow = mysql_fetch_assoc($inres);
		$boy[$i][$j]["lastName"] = $inrow["lastName"];
		$boy[$i][$j]["firstName"] = $inrow["firstName"];
		$boy[$i][$j]["dossard"] = $inrow["dossard"];
		$boy[$i][$j]["totalTime"] = gmdate("H \h i \m s \s",$inrow["totalTime"]);
		$boy[$i][$j]["patrolName"] = $inrow["patrolName"];
		$boy[$i][$j]["troopName"] = $inrow["troopName"];
	}
	
	//--------------------------------------------------------------------------------------------------
	// Classement des filles pour l'année "$year[$i]:
	//--------------------------------------------------------------------------------------------------
	$query = 'SELECT t_biker.lastName,t_biker.firstName,t_biker.dossard, t_patrol.name as patrolName, t_troop.name as troopName, (t_biker.endTime1 + t_biker.endTime2 + (t_biker.endTimeAttack*' . getTimeAttackFactor() . ') - t_biker.startTime1 - t_biker.startTime2 - (t_biker.startTimeAttack*' . getTimeAttackFactor() . ')) AS totalTime FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE ( t_troop.type='.ECLAIREUSE.' OR t_troop.type='.ROUGE_F.' OR t_troop.type='.CLANF.' ) AND birthYear ='.$year[$i].' ORDER BY totalTime';
	$inres=mysql_query($query);
	$number_of_girls[$i] = mysql_num_rows($inres);
	for($j=0;$j<$number_of_girls[$i];$j++)
	{
		$inrow = mysql_fetch_assoc($inres);
		$girl[$i][$j]["lastName"] = $inrow["lastName"];
		$girl[$i][$j]["firstName"] = $inrow["firstName"];
		$girl[$i][$j]["dossard"] = $inrow["dossard"];
		$girl[$i][$j]["totalTime"] = gmdate("H \h i \m s \s",$inrow["totalTime"]);
		$girl[$i][$j]["patrolName"] = $inrow["patrolName"];
		$girl[$i][$j]["troopName"] = $inrow["troopName"];
	}                       
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>

	<body>

		<?php
		
		if($number_of_biker_with_unknown_birthYear>0)
		{
			echo '<div class="alert">Attention: Il reste '.$number_of_biker_with_unknown_birthYear.' biker(s) dont l\'année de naissance est inconnue!</div>';
		}

		// on fait ici une boucle qui parcourt les années, et pour chaque année, on affiche les classement des garçons et des filles:
		// mais on affiche seulement les resultat si l'année est différente de UNKNOWN:
		for($i=0;$i<$number_of_years;$i++)
		{
			if($year[$i]!=UNKNOWN)
			{
				echo '<hr>';
				echo '<div class="alert">Année de naissance = '.$year[$i].'</div>';
				
        echo '<div class="prompt">Garçons:</div>';
        
        if($number_of_boys[$i] > 0) {
          
          echo '<table border ="1">';
          echo '<tr>';
          echo '<td>Position</td><td>temps total</td><td>dossard</td><td>Prénom</td><td>Nom</td><td>Troupe</td><td>Patrouille</td>';
          echo '</tr>';
    
          for($j=0;$j<$number_of_boys[$i];$j++)
          {
            echo '<tr>';
            echo '<td align="center">'.($j+1).'</td>';
            echo '<td>'.$boy[$i][$j]["totalTime"].'</td>';
            echo '<td align="center">'.$boy[$i][$j]["dossard"].'</td>';
            echo '<td>'.$boy[$i][$j]["firstName"].'</td>';
            echo '<td>'.$boy[$i][$j]["lastName"].'</td>';
            echo '<td>'.$boy[$i][$j]["troopName"].'</td>';
            echo '<td>'.$boy[$i][$j]["patrolName"].'</td>';
            echo '</tr>';
          }
          echo '</table>';
        } else {
          echo '<p>Aucun garçon classé pour cette année</p>';
        }
				
        echo '<div class="prompt">Filles:</div>';
        
				if($number_of_girls[$i] > 0) {
          
          echo '<table border ="1">';
          echo '<tr>';
          echo '<td>Position</td><td>temps total</td><td>dossard</td><td>Prénom</td><td>Nom</td><td>Troupe</td><td>Patrouille</td>';
          echo '</tr>';
    
          for($j=0;$j<$number_of_girls[$i];$j++)
          {
            echo '<tr>';
            echo '<td align="center">'.($j+1).'</td>';
            echo '<td>'.$girl[$i][$j]["totalTime"].'</td>';
            echo '<td align="center">'.$girl[$i][$j]["dossard"].'</td>';
            echo '<td>'.$girl[$i][$j]["firstName"].'</td>';
            echo '<td>'.$girl[$i][$j]["lastName"].'</td>';
            echo '<td>'.$girl[$i][$j]["troopName"].'</td>';
            echo '<td>'.$girl[$i][$j]["patrolName"].'</td>';
            echo '</tr>';
          }
          echo '</table>';
        } else {
          echo '<p>Aucune fille classée pour cette année</p>';
        }
			}
		}

		displayFooter();
		?>

	</body>
</html>