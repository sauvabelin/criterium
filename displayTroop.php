<?php
	/*
		file: 	displayTroop.php
		author: Benoît Uffer
	*/
	
include_once("globals.php");
include_once("sql.php");


// récupérer le bsNum de la troupe à afficher:
$bsNum = getParameterGET("bsNum");

// connection à la base de donnée
connect();


// on récupère le nom de la troupe:
$troopName = getTroopName($bsNum);

// on récupère les patrol_id de la troupe:
$query = 'select name,id from t_patrol where troop_id="'.$bsNum.'"';
$res = mysql_query($query);
$num_of_patrol = mysql_num_rows($res);
for($i=0;$i<$num_of_patrol;$i++)
{
  $row = mysql_fetch_assoc($res);
  $patrol[$i]["name"]=$row["name"];
  $patrol[$i]["id"]=$row["id"];
  
  // pour chaque patrol_id, on récupère les noms, prénoms et dossard des bikers:
  $query = 'select firstName,lastName,dossard,birthYear from t_biker where patrol_id = "'.$patrol[$i]["id"].'"';
  $inres = mysql_query($query);
  $num_of_bikers[$i] = mysql_num_rows($inres);
  for($j=0;$j<$num_of_bikers[$i];$j++)
  {
    $inrow = mysql_fetch_assoc($inres);
    $biker[$i][$j]["firstName"]= $inrow["firstName"];
    $biker[$i][$j]["lastName"]= $inrow["lastName"];
    $biker[$i][$j]["dossard"]= $inrow["dossard"];
    $biker[$i][$j]["birthYear"]= $inrow["birthYear"];
    if($biker[$i][$j]["dossard"]==UNKNOWN)
    {
      $biker[$i][$j]["dossard"] = "inconnu";
    }
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
	
	echo '<h3>troupe de '.$troopName.'</h3>';
	echo '<UL>';
	for($i=0;$i<$num_of_patrol;$i++)
  {
    echo '<LI>'.$patrol[$i]["name"];
    
    echo '<UL>';
    for($j=0;$j<$num_of_bikers[$i];$j++)
    {
      echo '<LI>['.$biker[$i][$j]["dossard"].'] '.$biker[$i][$j]["firstName"].' '.$biker[$i][$j]["lastName"].' ('.$biker[$i][$j]["birthYear"].')';
    }
    echo '</UL>';
    
  }
	echo '</UL>';
	
	displayFooter();
	?>
				
	</body>
</html>
