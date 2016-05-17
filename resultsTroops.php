<?php
	/*
		file: 	resultsTroops.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


// connect to database:
connect();


// minimalYear:
// (les gars/filles qui sont nés avant cette date ne sont pas pris en compte dans le classement)
$minYear = getMinimalYear();

// maxBiker:
// (les patrouilles qui ont plus de participants on un bonus)
$maxBiker = getMaxBiker();

// bonus:
// ce nombre représente les secondes a retirer par biker en plus dans les patrouilles qui ont plus de maxBiker participants
$bonus = getBonus();

//--------------------------------------------------------------------------------------------------
// Classement des troupes ECLAIREURS uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_troop.bsNum as bsNum, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUR.' AND birthYear >='.$minYear.' GROUP BY t_troop.bsNum ORDER BY moyenne';
$res=mysql_query($query);
$number_of_troop_eclaireur = mysql_num_rows($res);
for($i=0;$i<$number_of_troop_eclaireur;$i++)
{
	$row = mysql_fetch_assoc($res);
	$eclaireur[$i]["troopName"] = $row["troopName"];
	// pour chaque troupe, il faut calculer si le nombre de gar/fille dépasse un maximum, afin de donner un bonus.
	// le max est égal au max pour les patrouilles, multiplié par le nombre de patrouille dans la troupe
	
	// calcul du max pour la troupe courant:
	$query = 'SELECT count(*) as number_of_patrol from t_patrol where troop_id='.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$max = $maxBiker*$inrow["number_of_patrol"];
	$eclaireur[$i]["number_of_patrol"] = $inrow["number_of_patrol"];
	
	// calcul du nombre de participants dans la troupe courante:
	$query = 'SELECT count(*) as number_of_bikers from t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id WHERE t_patrol.troop_id = '.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$num = $inrow["number_of_bikers"];
	$eclaireur[$i]["number_of_bikers"] = $num;
	
	// on soustrait le bonus si necessaire:
	if($num >= $max)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($num - $max) ;
	}
	
	// le temps final est passé en gmdate:
	$eclaireur[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);	
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($eclaireur,"compareMoyennes");

//--------------------------------------------------------------------------------------------------
// Classement des troupes ECLAIREUSES uniquement:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_troop.bsNum as bsNum, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE t_troop.type='.ECLAIREUSE.' AND birthYear >='.$minYear.' GROUP BY t_troop.bsNum ORDER BY moyenne';
$res=mysql_query($query);
$number_of_troop_eclaireuse = mysql_num_rows($res);
for($i=0;$i<$number_of_troop_eclaireuse;$i++)
{
	$row = mysql_fetch_assoc($res);
	$eclaireuse[$i]["troopName"] = $row["troopName"];
	// pour chaque troupe, il faut calculer si le nombre de gar/fille dépasse un maximum, afin de donner un bonus.
	// le max est égal au max pour les patrouilles, multiplié par le nombre de patrouille dans la troupe
	
	// calcul du max pour la troupe courant:
	$query = 'SELECT count(*) as number_of_patrol from t_patrol where troop_id='.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$max = $maxBiker*$inrow["number_of_patrol"];
	$eclaireuse[$i]["number_of_patrol"] = $inrow["number_of_patrol"];
	
	// calcul du nombre de participants dans la troupe courante:
	$query = 'SELECT count(*) as number_of_bikers from t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id WHERE t_patrol.troop_id = '.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$num = $inrow["number_of_bikers"];
	$eclaireuse[$i]["number_of_bikers"] = $num;
	
	// on soustrait le bonus si necessaire:
	if($num >= $max)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($num - $max) ;
	}
	
	// le temps final est passé en gmdate:
	$eclaireuse[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);	
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($eclaireuse,"compareMoyennes");

//--------------------------------------------------------------------------------------------------
// Classement des troupes ECLAIREURS et ECLAIREUSES confondus:
//--------------------------------------------------------------------------------------------------
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne,t_troop.bsNum as bsNum, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE ( t_troop.type="'.ECLAIREUR.'" OR t_troop.type="'.ECLAIREUSE.'") AND birthYear >='.$minYear.' GROUP BY t_troop.bsNum ORDER BY moyenne';
$res=mysql_query($query);
$number_of_troop_both = mysql_num_rows($res);
for($i=0;$i<$number_of_troop_both;$i++)
{
	$row = mysql_fetch_assoc($res);
	$both[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);
	$both[$i]["troopName"] = $row["troopName"];
	// pour chaque troupe, il faut calculer si le nombre de gar/fille dépasse un maximum, afin de donner un bonus.
	// le max est égal au max pour les patrouilles, multiplié par le nombre de patrouille dans la troupe
	
	// calcul du max pour la troupe courant:
	$query = 'SELECT count(*) as number_of_patrol from t_patrol where troop_id='.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$max = $maxBiker*$inrow["number_of_patrol"];
	$both[$i]["number_of_patrol"] = $inrow["number_of_patrol"];
	
	// calcul du nombre de participants dans la troupe courante:
	$query = 'SELECT count(*) as number_of_bikers from t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id WHERE t_patrol.troop_id = '.$row["bsNum"];
	$inres=mysql_query($query);
	$inrow=mysql_fetch_assoc($inres);
	$num = $inrow["number_of_bikers"];
	$both[$i]["number_of_bikers"] = $num;
	
	// on soustrait le bonus si necessaire:
	if($num >= $max)
	{
		// si le nombre de participants est plus grand que 6, alors on réduit le temps moyen de 30 secondes par participants:
		$row["moyenne"] -= ($bonus)*($num - $max) ;
	}
	
	// le temps final est passé en gmdate:
	$both[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);	
}
// a cause des eventuels bonus, le tableau n'est peut être plus trié. Il faut le retrier:
usort($both,"compareMoyennes");

//--------------------------------------------------------------------------------------------------
// Classement des troupes ROUGE (garçon et filles):
//--------------------------------------------------------------------------------------------------
$query = 'SELECT AVG(endTime1+endTime2+(endTimeAttack*' . getTimeAttackFactor() . ')-startTime1-startTime2-(startTimeAttack*' . getTimeAttackFactor() . ')) AS moyenne, t_troop.name as troopName FROM t_biker JOIN t_patrol ON t_biker.patrol_id=t_patrol.id JOIN t_troop ON t_troop.bsNum=t_patrol.troop_id WHERE ( t_troop.type="'.ROUGE_G.'" OR t_troop.type="'.ROUGE_F.'") GROUP BY t_troop.bsNum ORDER BY moyenne';
$res=mysql_query($query);
$number_of_troop_red = mysql_num_rows($res);
for($i=0;$i<$number_of_troop_red;$i++)
{
	$row = mysql_fetch_assoc($res);
	$red[$i]["moyenne"] = gmdate("H \h i \m s \s",$row["moyenne"]);
	$red[$i]["troopName"] = $row["troopName"];
}

?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
	
	<?php
	  echo '<span class="prompt">Les gars/filles qui sont nés AVANT '.$minYear.' ne sont pas dans le classement</span></br>';
		echo '(cette date peut être modifiée dans le panneau d\'administration)';
		br(5);
	
	
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des troupes ECLAIREURS uniquement:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des troupes gars uniquement:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Troupe</td><td>nombre de patrouilles</td><td>nombre de participants</td>';
		echo '</tr>';	
		for($i=0;$i<$number_of_troop_eclaireur;$i++)
		{
			echo '<tr>';
			echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$eclaireur[$i]["moyenne"].'</td>';
			echo '<td>'.$eclaireur[$i]["troopName"].'</td>';
			echo '<td align="center">'.$eclaireur[$i]["number_of_patrol"].'</td>';
			echo '<td align="center">'.$eclaireur[$i]["number_of_bikers"].'</td>';
			echo '</tr>';
		}
		echo '</table>';	
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des troupes ECLAIREUSES uniquement:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des troupes filles uniquement:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Troupe</td><td>nombre de patrouilles</td><td>nombre de participants</td>';
		echo '</tr>';	
		for($i=0;$i<$number_of_troop_eclaireuse;$i++)
		{
			echo '<tr>';
			echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$eclaireuse[$i]["moyenne"].'</td>';
			echo '<td>'.$eclaireuse[$i]["troopName"].'</td>';
			echo '<td align="center">'.$eclaireuse[$i]["number_of_patrol"].'</td>';
			echo '<td align="center">'.$eclaireuse[$i]["number_of_bikers"].'</td>';
			echo '</tr>';
		}
		echo '</table>';	
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des troupes ECLAIREURS et ECLAIREUSES:
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des troupes gars et filles confondus:</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Troupe</td><td>nombre de patrouilles</td><td>nombre de participants</td>';
		echo '</tr>';	
		for($i=0;$i<$number_of_troop_both;$i++)
		{
			echo '<tr>';
			echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$both[$i]["moyenne"].'</td>';
			echo '<td>'.$both[$i]["troopName"].'</td>';
			echo '<td align="center">'.$both[$i]["number_of_patrol"].'</td>';
			echo '<td align="center">'.$both[$i]["number_of_bikers"].'</td>';
			echo '</tr>';
		}
		echo '</table>';	
		br(3);
		
		//--------------------------------------------------------------------------------------------------
		// affichage Classement des troupes ROUGES (garçons et filles confondus):
		//--------------------------------------------------------------------------------------------------
		echo '<hr>';
		echo '<div class="prompt">Classement des troupes rouges (garçons et filles confondus):</div>';
		echo '<table border ="1">';
		echo '<tr>';
		echo '<td>Position</td><td>temps moyen</td><td>Troupe</td>';
		echo '</tr>';	
		for($i=0;$i<$number_of_troop_red;$i++)
		{
			echo '<tr>';
			echo '<td align="center">'.($i+1).'</td>';
			echo '<td>'.$red[$i]["moyenne"].'</td>';
			echo '<td>'.$red[$i]["troopName"].'</td>';
			echo '</tr>';
		}
		echo '</table>';	
		br(3);
	

	displayFooter();
	?>	
		
	</body>
</html>