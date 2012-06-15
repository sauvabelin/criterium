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
		echo 'ATTENTION:<br>';
		echo 'Ceci aura pour effet de remettre à zéro la base de donnée,<br>';
		echo 'De créer les troupes et les patrouilles selon le modèle<br>';
		echo 'Et d\'effacer tous les gars/filles<br>';
		echo '<br>Etes-vous sûr??<br>';
		echo '</span>';
		
		echo '<a href="WARNING_createVirginDB.php">OUI</a><br><br>';
		echo '<a href="admin.php">NON</a><br><br>';
		
		
		?>
		
	</body>
</html>