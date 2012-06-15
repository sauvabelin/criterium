<?php
	/*
		file: 	WARNING_dropAllTables.php
		author: Benoît Uffer
	*/

include_once("sql.php");
include_once("globals.php");

//connect db:
connect();

// 1) drop existing tables;
mysql_query("drop table t_biker");	
mysql_query("drop table t_patrol");
mysql_query("drop table t_troop");
mysql_query("drop table t_year");
mysql_query("drop table t_limits");
?>

<html>
	<head>
		<title>create virgin DB</title>
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
