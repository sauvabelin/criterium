<?php
/*
	file: 	globals.php
	author: Benoît Uffer
	
	définitions de variables et fonctions globales:
*/

//types:
define("ECLAIREUR", 	1);
define("ECLAIREUSE", 	2);
define("BRANCHE_2",		3); // eclaireurs ET eclaireuses
define("ROUGE_G",		  5); // rouges garçons
define("ROUGE_F",		  6); // rouges filles
define("BRANCHE_3",		7); // rouges garçons ET filles
define("CLANG",		    8);
define("CLANF",		    9);
define("CLANS",		    10); // clan garçons ET filles

//troupes:
define("ZANFLEURON",	1);
define("MANLOUD",			2);
define("NEUVAZ",			5);
define("CHANDELARD",	6);
define("BERISAL",			7);
define("MONTFORT",		8);
define("LOVEGNO",			9);

define("SOLALEX",			10);
define("GRAMMONT",		11);
define("ARMINA",			12);

define("ROVEREAZ",		3);
define("ORZIVAL",			4);
define("TSALION",			15);

define("SESAL", 			14);
define("TAMARO", 			13);

define("CLAN", 			  20);

//valeur inconnue
// (par exemple si le dossard ou le temps est inconnu)
define("UNKNOWN", 	-1);

//fonctions:

/*
	displayFooter()
	
	Cette fonction affiche un pied de page. Elle doit etre appellée a chaque page qui souhaite l'afficher.
	Ce doit être la dernière chose avant de refermer la balise </body>
	Le but est d'avoir un pied de page uniforme dans tous le site, et n'écrire les changements qu'une seule fois
*/
function displayFooter()
{
	echo '<br><hr>';
	// un lien vers la page d'accueil
	echo '<a href="index.php">Accueil</a>';
	echo '&nbsp;&nbsp;';
	echo '<a href="admin.php">Administration</a>';
	br(2);
	// un lien vers PHPmyAdmin
	echo '<div class="alignLeft">utilisateurs avertis uniquement:&nbsp;&nbsp;<a href="../phpmyadmin/index.php">phpMyAdmin</a><span>';
}

/*
	is_a_number($x)

	cette fonction est une façon "propre" de savoir si une variable correspond à un nombre entier ou non
	(is_int() ne focntionne pas)
	
	retourne true si $x est un entier
	retourne false sinon
*/
function is_a_number($x)
{
	return( is_numeric($x) ? intval($x)==$x : false );
}


/*
	formatCase($str)
	
	cette fonction retourne la chaîne passée en paramètre, avec la première lettre en majuscule et toutes
	les autres en minuscule
	
	But: avoir dans la base de donnée un format etablit. (pour les noms des patrouilles par exemple)
*/
function formatCase($str)
{
	return ucwords(strtolower(trim($str)));
}

/*
	getTroopName($bsNum)
	
	retourne une chaîne de caractère qui contient le nom de la troupe en fonction du numero BS.
	cette fonction stop le script si:
	- elle n'arrive pas à se connecter à la base de donnée
	- elle ne trouve dans la DB aucune troupe avec le numero bs passé en paramètre
	- elle trouve dans la DB plusieurs troupes  avec le numero bs passé en paramètre

*/
function getTroopName($bsNum)
{
	// connect à la base de donnée
connect();

	// on récupère le nom de la troupe:
	$query = 'select name from t_troop where bsNum="'.$bsNum.'"';
	$res = mysql_query($query);
	// on vérifie (a tout hasard) qu'il y a 1 et 1 seule troupe avec ce bsNum:
	$number_of_troop = mysql_num_rows($res);
	if($number_of_troop==0)
	{
		exit('erreur: il n\'y a pas de troupe avec bsNum = '.$bsNum.' dans la base de données');
	}
	else if($number_of_troop > 1)
	{
		exit('erreur: il y a plusieures troupes avec bsNum = '.$bsNum.' dans la base de données');
	}
	$row = mysql_fetch_assoc($res);
	return $row["name"];
	}
	
	/*
	getTroopName($bsNum)
	
	retourne une chaîne de caractère qui contient le nom de la patrouille en fonction de son id dans la DB.
	cette fonction stop le script si:
	- elle n'arrive pas à se connecter à la base de donnée
	- elle ne trouve dans la DB aucune troupe avec le numero bs passé en paramètre
	- elle trouve dans la DB plusieurs troupes  avec le numero bs passé en paramètre

*/
function getPatrolName($patrol_id)
{
	// connect à la base de donnée
connect();

	// on récupère le nom de la patrouille:
	$query = 'select name from t_patrol where id="'.$patrol_id.'"';
	$res = mysql_query($query);
	// on vérifie (a tout hasard) qu'il y a 1 et 1 seule patrouille avec ce patrol_id:
	$number_of_patrol = mysql_num_rows($res);
	if($number_of_patrol==0)
	{
		exit('erreur: il n\'y a pas de patrouille avec l\'id = '.$patrol_id.' dans la base de données');
	}
	else if($number_of_patrol > 1)
	{
		exit('erreur: il y a plusieures patrouilles avec l\'id = '.$patrol_id.' dans la base de données');
	}
	$row = mysql_fetch_assoc($res);
	return $row["name"];
	}
	
	/*
	 getParameterGET($param)
	 
	 verifie si le paramètre demandé existe avant de le récupérer.
	 s'il n'existe pas, le script se termine avec un msg d'erreur
  */
	function getParameterGET($param)
	{
  	if(!isset($_GET[$param]))
  	{
  	 exit('erreur: le paramètre "'.$param.'" manque (méthode GET)');
    }
    return $_GET[$param];
  }
  
  	/*
	 getParameterPOST($param)
	 
	 verifie si le paramètre demandé existe avant de le récupérer.
	 s'il n'existe pas, le script se termine avec un msg d'erreur
  */
	function getParameterPOST($param)
	{
  	if(!isset($_POST[$param]))
  	{
  	 exit('erreur: le paramètre "'.$param.'" manque (méthode POST)');
    }
    return $_POST[$param];
  }


	/*
	  getMinimalYear()
	
		retourne l'année qui se trouve dans la table t_year
		(c'est une table avec 1 seul colonne et 1 seule ligne)
	*/
	function getMinimalYear()
	{
		connect();
		$res = mysql_query("select * from t_year");
		$row = mysql_fetch_assoc($res);
		return $row["year"];
	}
	
	
	/*
		setMinimalYear($minYear)
	*/
	function setMinimalYear($minYear)
	{
		connect();
		mysql_query('update t_year set year="'.$minYear.'"');
	}
	
	/*
	  getMinBiker()
	
		retourne le nombre minBiker de la table t_limits
		(c'est une table avec 1 seule ligne)
	*/
	function getMinBiker()
	{
		connect();
		$res = mysql_query("select minBiker from t_limits");
		$row = mysql_fetch_assoc($res);
		return $row["minBiker"];
	}
	
	/*
		setMinBiker($minBiker)
	*/
	function setMinBiker($minBiker)
	{
		connect();
		mysql_query('update t_limits set minBiker="'.$minBiker.'"');
	}
	
	/*
	  getMaxBiker()
	
		retourne le nombre maxBiker de la table t_limits
		(c'est une table avec 1 seule ligne)
	*/
	function getMaxBiker()
	{
		connect();
		$res = mysql_query("select maxBiker from t_limits");
		$row = mysql_fetch_assoc($res);
		return $row["maxBiker"];
	}
	
	/*
		setMaxBiker($maxBiker)
	*/
	function setMaxBiker($maxBiker)
	{
		connect();
		mysql_query('update t_limits set maxBiker="'.$maxBiker.'"');
	}
	
	/*
	  getBonus()
	
		retourne le nombre bonusSeconds de la table t_limits
		(c'est une table avec 1 seule ligne)
	*/
	function getBonus()
	{
		connect();
		$res = mysql_query("select bonusSeconds from t_limits");
		$row = mysql_fetch_assoc($res);
		return $row["bonusSeconds"];
	}	
	
	/*
		setBonus($bonus)
	*/
	function setBonus($bonus)
	{
		connect();
		mysql_query('update t_limits set bonusSeconds="'.$bonus.'"');
	}
	
	/*
	  getTimeAttackFactor()
	
		retourne le facteur de multiplication du temps du contre la montre de la table t_timeAttackFactor
		(c'est une table avec 1 seule ligne)
	*/
	function getTimeAttackFactor()
	{
		connect();
		$res = mysql_query("select timeAttackFactor from t_factor");
		$row = mysql_fetch_assoc($res);
		return $row["timeAttackFactor"];
	}	
	
	/*
		setTimeAttackFactor($factor)
	*/
	function setTimeAttackFactor($factor)
	{
		connect();
		mysql_query('update t_factor set timeAttackFactor="'.$factor.'"');
	}

	/*
		br($n)
		
		fait $n echos de <br> à la suite
	*/
	function br($n)
	{
		for($i=0;$i<$n;$i++)
		{
			echo '<br>';
		}
	}
	
	/*
		compareMoyennes($a,$b)
		
		cette fonction compare les colonnes "moyenne" des tableaux passée en paramètres,
		pour le tri de tableau multi-dimmensionnel
	*/
	function compareMoyennes($a,$b)
	{
		if($a["moyenne"] < $b["moyenne"])
		{
			return -1;
		}
		if($a["moyenne"] > $b["moyenne"])
		{
			return 1;
		}
		return 0;
	}
	
?>
