<?php
	/*
		file: 	resultsPatrols.php
		author: Benoît Uffer
	*/
	
include_once("globals.php");
include_once("sql.php");


// connect to database:
connect();


// minimalYear:
// (les gars/filles qui sont nés avant cette date ne sont pas pris en compte dans le classement)
$minYear = getMinimalYear();

// minBiker:
// (les patrouilles qui ont moins de participants ne comptent pas au classement)
$minBiker = getMinBiker();

// maxBiker:
// (les patrouilles qui ont plus de participants on un bonus)
$maxBiker = getMaxBiker();

// bonus:
// ce nombre représente les secondes a retirer par biker en plus dans les patrouilles qui ont plus de maxBiker participants
$bonus = getBonus();



//--------------------------------------------------------------------------------------------------
// Classement des patrouilles ECLAIREURS uniquement:
//--------------------------------------------------------------------------------------------------
// Note: la colonne qui contient la moyenne DOIT s'appeller "moyenne" car cette chaine est utilisée dans la fonction de tri "compareMoyenne"
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_patrol.name as patrolName, t_patrol.id as patrolId, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUR.' AND birthYear >='.$minYear.' GROUP BY t_patrol.id ORDER BY moyenne';
$res=mysql_query($query);
$number_of_patrol_eclaireur = mysql_num_rows($res);
for($i=0;$i<$number_of_patrol_eclaireur;$i++)
{
	$row = mysql_fetch_assoc($res);
	$eclaireur[$i]["patrolName"] = $row["patrolName"];
	$eclaireur[$i]["troopName"] = $row["troopName"];
	// pour chaque patrouille, il faut compter le nombre de gars/filles, car:
	//   - si ce nombre est plus grand que 6 (par défaut), on donne un bonus à la patrouille
	//   - si ce nombre est plus petit que 2 (par défaut), on retire la patrouille du classement (uniquement lors de l'affichage)
	$query = 'SELECT count(*) as number_of_bikers from t_biker where patrol_id='.$row["patrolId"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$eclaireur[$i]["number_of_bikers"] = $inrow["number_of_bikers"];
	if($inrow["number_of_bikers"] >= $maxBiker)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($inrow["number_of_bikers"] - $maxBiker) ;
	}
	// le temps final est passé en gmdate:
	$eclaireur[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($eclaireur,"compareMoyennes");


//--------------------------------------------------------------------------------------------------
// Classement des patrouilles ECLAIREUSES uniquement:
//--------------------------------------------------------------------------------------------------
// Note: la colonne qui contient la moyenne DOIT s'appeller "moyenne" car cette chaine est utilisée dans la fonction de tri "compareMoyenne"
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_patrol.name as patrolName, t_patrol.id as patrolId, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUSE.' AND birthYear >='.$minYear.' GROUP BY t_patrol.id ORDER BY moyenne';
$res=mysql_query($query);
$number_of_patrol_eclaireuse = mysql_num_rows($res);
for($i=0;$i<$number_of_patrol_eclaireuse;$i++)
{
	$row = mysql_fetch_assoc($res);
	$eclaireuse[$i]["patrolName"] = $row["patrolName"];
	$eclaireuse[$i]["troopName"] = $row["troopName"];
	// pour chaque patrouille, il faut compter le nombre de gars/filles, car:
	//   - si ce nombre est plus grand que 6 (par défaut), on donne un bonus à la patrouille
	//   - si ce nombre est plus petit que 2 (par défaut), on retire la patrouille du classement (uniquement lors de l'affichage)
	$query = 'SELECT count(*) as number_of_bikers from t_biker where patrol_id='.$row["patrolId"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$eclaireuse[$i]["number_of_bikers"] = $inrow["number_of_bikers"];
	if($inrow["number_of_bikers"] >= $maxBiker)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($inrow["number_of_bikers"] - $maxBiker) ;
	}
	// le temps final est passé en gmdate:
	$eclaireuse[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($eclaireuse,"compareMoyennes");

//--------------------------------------------------------------------------------------------------
// Classement des patrouilles ECLAIREUR ET ECLAIREUSES:
//--------------------------------------------------------------------------------------------------
// Note: la colonne qui contient la moyenne DOIT s'appeller "moyenne" car cette chaine est utilisée dans la fonction de tri "compareMoyenne"
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_patrol.name as patrolName, t_patrol.id as patrolId, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE ( t_troop.type="'.ECLAIREUR.'" OR t_troop.type="'.ECLAIREUSE.'" ) AND birthYear >='.$minYear.' GROUP BY t_patrol.id ORDER BY moyenne';
$res=mysql_query($query);
$number_of_patrol_both = mysql_num_rows($res);
for($i=0;$i<$number_of_patrol_both;$i++)
{
	$row = mysql_fetch_assoc($res);
	$both[$i]["patrolName"] = $row["patrolName"];
	$both[$i]["troopName"] = $row["troopName"];
	// pour chaque patrouille, il faut compter le nombre de gars/filles, car:
	//   - si ce nombre est plus grand que 6 (par défaut), on donne un bonus à la patrouille
	//   - si ce nombre est plus petit que 2 (par défaut), on retire la patrouille du classement (uniquement lors de l'affichage)
	$query = 'SELECT count(*) as number_of_bikers from t_biker where patrol_id='.$row["patrolId"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$both[$i]["number_of_bikers"] = $inrow["number_of_bikers"];
	if($inrow["number_of_bikers"] >= $maxBiker)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($inrow["number_of_bikers"] - $maxBiker) ;
	}
	// le temps final est passé en gmdate:
	$both[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($both,"compareMoyennes");

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	
	<?php
		
		// on avertit que les gars/fille "trop vieux" ne sont pas comptés, et on explique les bonus:
		echo '<span class="prompt">Les gars/filles qui sont nés AVANT '.$minYear.' ne sont pas comptés dans le classement</span></br>';
		echo '<span class="prompt">Les patrouille qui ont MOINS QUE '.$minBiker.' gars/filles ne sont pas dans le classement</span></br>';
		echo '<span class="prompt">Les patrouille qui ont PLUS DE '.$maxBiker.' ont un bonus de '.$bonus.' secondes par gars/fille en plus</span></br>';
		echo '(ces valeurs peuvent être modifiées dans le panneau d\'administration)';
		br(5);
	
	
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des patrouilles ECLAIREURS uniquement:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des patrouilles gars uniquement:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Patrouille</td><td>Troupe</td><td>nombre de participants</td>';
		echo '</tr>';
		$pos = 0;
		for($i=0;$i<$number_of_patrol_eclaireur;$i++)
		{
			if($eclaireur[$i]["number_of_bikers"]>=$minBiker)
			{
				$pos++;
				echo '<tr>';
				echo '<td align="center">'.($pos).'</td>';
				echo '<td>'.$eclaireur[$i]["moyenne"].'</td>';
				echo '<td>'.$eclaireur[$i]["patrolName"].'</td>';
				echo '<td>'.$eclaireur[$i]["troopName"].'</td>';
				echo '<td align="center">'.$eclaireur[$i]["number_of_bikers"].'</td>';
				echo '</tr>';
			}			
		}	
		echo '</table>';	
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des patrouilles ECLAIREUSES uniquement:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des patrouilles filles uniquement:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Patrouille</td><td>Troupe</td><td>nombre de participants</td>';
		echo '</tr>';	
		$pos = 0;
		for($i=0;$i<$number_of_patrol_eclaireuse;$i++)
		{
			if($eclaireuse[$i]["number_of_bikers"]>=$minBiker)
			{
				$pos++;
				echo '<tr>';
				echo '<td align="center">'.($pos).'</td>';
				echo '<td>'.$eclaireuse[$i]["moyenne"].'</td>';
				echo '<td>'.$eclaireuse[$i]["patrolName"].'</td>';
				echo '<td>'.$eclaireuse[$i]["troopName"].'</td>';
				echo '<td align="center">'.$eclaireuse[$i]["number_of_bikers"].'</td>';
				echo '</tr>';
			}	
		}
		echo '</table>';
		br(3);
				
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des patrouilles ECLAIREURS et ECLAIREUSES:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des patrouilles gars et filles confondus:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Patrouille</td><td>Troupe</td><td>nombre de participants</td>';
		echo '</tr>';	
		$pos = 0;
		for($i=0;$i<$number_of_patrol_both;$i++)
		{
			if($both[$i]["number_of_bikers"]>=$minBiker)
			{
				$pos++;
				echo '<tr>';
				echo '<td align="center">'.($pos).'</td>';
				echo '<td>'.$both[$i]["moyenne"].'</td>';
				echo '<td>'.$both[$i]["patrolName"].'</td>';
				echo '<td>'.$both[$i]["troopName"].'</td>';
				echo '<td align="center">'.$both[$i]["number_of_bikers"].'</td>';
				echo '</tr>';
			}
		}	
		echo '</table>';
		br(3);
		
	displayFooter();
	?>	
		
	</body>
</html>