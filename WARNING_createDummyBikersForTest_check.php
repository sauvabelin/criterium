<?php
	
	
?>

<html>
	<head>
		<title>CRITERIUM DE CHANDELARD</title>
		<link rel="stylesheet" type="text/css" href="styles.css" />
	</head>
	
	<body>
		
		<?php
		
		echo '<span class="alert">';
		echo 'WARNING:<br>';
		echo 'this action will add bikers in the database<br>';
		echo 'it should only be done for test purpose<br>';
		echo 'it should NEVER be done during criterium<br>';
		echo '<br>Are you sure?<br>';
		echo '</span>';
		
		echo '<a href="WARNING_createDummyBikersForTest.php">YES</a><br><br>';
		echo '<a href="admin.php">NO</a><br><br>';
		
		
		?>
		
	</body>
</html>