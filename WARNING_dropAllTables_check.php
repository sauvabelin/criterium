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
		echo 'The HOLE database will be lost!!!<br>';
		echo '<br>Are you sure?<br>';
		echo '</span>';
		
		echo '<a href="WARNING_dropAllTables.php">YES</a><br><br>';
		echo '<a href="admin.php">NO</a><br><br>';
		
		
		?>
		
	</body>
</html>