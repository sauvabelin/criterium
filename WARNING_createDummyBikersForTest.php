<?php
	/*
		file: 	WARNING_createDummyBikersForTest.php
		author: Benoît Uffer
	*/

include_once("sql.php");
include_once("globals.php");
include_once("randomNames.php");

// connect to database:
connect();


/*
mysql_query('insert into t_biker values("NULL", "12","Benoît","Uffer","1978","1","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "72","Julien","Weibel","1981","1","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "46","Michael","Wyssa","1982","1","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "01","Roberto","De Col","1980","22","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "33","Arnaud","Jaccoud","1978","22","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "65","Calixe","Cathomen","1980","22","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "19","Philippe","Marguerat","1980","22","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "13","Dominique","Moinat","1980","33","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "45","Claude-Hélène","Goy","1978","33","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "22","Nathalie","Wenger","1979","37","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "36","Anne-Séverine","Michaud","1978","37","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "07","Camille","Perrier","1980","37","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "77","Gilles","Bonnard","1981","45","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "15","Sylvain","Rollinet","1982","45","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
mysql_query('insert into t_biker values("NULL", "39","Gilles","Wenger","1981","47","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
*/

for($i=0;$i<200;$i++)
{
	// choose random name:
	$firstName = formatCase(  $randomNames[rand(1,count($randomNames)-1)]  );
	$lastName = formatCase($randomNames[rand(1,count($randomNames)-1)]);
	// choose dossard:
	$dossard = $i;
	// choose birtYear:
	$birthYear = rand(1988,1997);
	// choose patrol:
	$patrol = rand(1,49);
	
	// insert into db:
	mysql_query('insert into t_biker values("NULL", "'.$dossard.'","'.$firstName.'","'.$lastName.'","'.$birthYear.'","'.$patrol.'","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.","'.UNKNOWN.'.")');
}


?>

<html>
	<head>
		<title>create Dummy Bikers for test</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	<body>

	
<?php
	echo '<br><br>';
	echo '<span class="prompt">Done!</span>';
	echo '<br><br>';
	displayFooter();

?>
		
	</body>
</html>