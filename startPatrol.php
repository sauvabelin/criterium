<?php
	/*
		file: 	startPatrol.php
		author: Benoît Uffer
	*/

include_once("globals.php");
include_once("sql.php");


// set local Variables from GET:
$patrolId = getParameterGET("id");


// connect to database:
connect();


// récupérer le nom de la patrouille:
$patrolName = getPatrolName($patrolId);

// avant de donner le signal de départ, on verifie que tous les bikers de cette patrouille ont déja un dossard.
// si ce n'est pas le cas, on affiche les prénoms et noms des gars qui n'en ont pas encore.
$all_bikers_have_dossard = TRUE;
$query = 'select firstName,lastName from t_biker where patrol_id="'.$patrolId.'" and dossard="'.UNKNOWN.'"';
$res = mysql_query($query);
$numer_of_unknown_dossard = mysql_num_rows($res);
if($numer_of_unknown_dossard>0)
{
	$all_bikers_have_dossard = FALSE;
	for($i=0;$i<$numer_of_unknown_dossard;$i++)
	{
		$row = mysql_fetch_assoc($res);
		$bikers_without_dossard[$i]["firstName"]= $row["firstName"];
		$bikers_without_dossard[$i]["lastName"]= $row["lastName"];
	}	
}

// On vérifie aussi qu'il y a bien des participants dans cette patrouille. On les compte et on affiche la liste:
$query = 'select firstName,lastName,dossard from t_biker where patrol_id="'.$patrolId.'"';
$res = mysql_query($query);
$num_of_bikers = mysql_num_rows($res);
for($i=0;$i<$num_of_bikers;$i++)
{
	$row = mysql_fetch_assoc($res);
	$bikers[$i]["firstName"]= $row["firstName"];
	$bikers[$i]["lastName"]= $row["lastName"];
	$bikers[$i]["dossard"]=$row["dossard"];
	if($bikers[$i]["dossard"] == UNKNOWN)
	{
	 $bikers[$i]["dossard"] = "inconnu";
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
	
	echo '<h3>Patrouille des '.$patrolName.'</h3>';	
	
	if($num_of_bikers==0)
   {
    echo '<div class="alert">Il y a 0 inscrits dans cette patrouille!</div>';
   }
	else
	{
	// Si des bikers n'ont pas encore de numéro de dossard, avertir l'utilisateur:
	if($all_bikers_have_dossard == FALSE)
	{
		echo '<div class="alert">ATTENTION:</div>';
		echo 'cette patrouille comporte des bikers dont le numéro de dossard est inconnu dans la base de données<br>';
		echo '<UL>';
		for($i=0;$i<$numer_of_unknown_dossard;$i++)
		{
			echo '<LI>'.$bikers_without_dossard[$i]["firstName"].' '.$bikers_without_dossard[$i]["lastName"];
		}	
		echo '</UL>';
		
	}
		
	
	echo '<form action="startPatrolDone.php?patrol_id='.$patrolId.'" method="POST">';
	

	
		echo '<h3>1) Choisissez l\'étape:</h3>';
		echo '<input type="radio" name="timeField" value="startTime1" id="amId">';
		echo '<label for="amId">Etape du matin</label>';
		echo '<br>';
		echo '<input type="radio" name="timeField" value="startTimeAttack" id="taId">';
		echo '<label for="taId">Contre la montre</label>';
		echo '<br>';
		echo '<input type="radio" name="timeField" value="startTime2" id="pmId">';
		echo '<label for="pmId">Etape de l\'après-midi</label>';
		echo '<br>';
		echo '<h3>2) Choisissez la méthode:</h3>';
		echo '<input type="radio" name="method" value="system" id="systemId" checked>';
		echo '<label for="systemId">Utiliser le temps de l\'ordinateur</label>';
		echo '<br>';
		echo '<input type="radio" name="method" value="manual" id="manualId">';
		echo '<label for="manualId">Entrez un temps manuellement</label>';
		echo '<br><br>';	
		echo '<input type="text" name="hh" value="HH" size="2">:<input type="text" name="mm" value="MM" size="2">:<input type="text" name="ss" value="SS" size="2">';
		echo '<br><br>';	
		echo '<input type="submit" value="START">';
	  echo '</form>';
	  echo '<br><br><hr>';
	

   // on affiche la liste des participants:

   if($num_of_bikers!=0)
   {
      echo '<div class="prompt">Participants:</div>';
      echo '<UL>';
      for($i=0;$i<$num_of_bikers;$i++)
  		{
  			echo '<LI>'.$bikers[$i]["firstName"].' '.$bikers[$i]["lastName"].' dossard= '.$bikers[$i]["dossard"];
  		}	
  		echo '</UL>';
		}
  }
  
  displayFooter();
  
  ?>
		
	</body>
</html>
