<?php
	/*
		file: 	sql.php
		author: Benoît Uffer
	*/

function displayTable($tableName)
{
//get the whole table:
$query = 'select * from '.$tableName;
$res = mysql_query($query);
// get size:
$fieldsNum = mysql_num_fields($res);
$rowsNum = mysql_num_rows($res);

//display table
echo '<h3>'.$tableName.'</h3>';
echo '<table border="1" cellpadding="5">';
// display fields names:
echo '<tr>';
for($k=0;$k<$fieldsNum;$k++)
{
	echo '<td align="center">';
	echo mysql_field_name($res,$k);
	echo '</td>';
}
echo '</tr>';
// display fields
for($j=0;$j<$rowsNum;$j++)
{
	$row = mysql_fetch_row($res);
	echo '<tr>';
	for($k=0;$k<$fieldsNum;$k++)
	{
		echo '<td align="center">';
		echo "$row[$k]";
		echo '</td>';
	}
	echo '</tr>';
}
echo '</table>'; 
}

function connect()
{
  $server   =	"localhost";
  $user     =	"root";
  $password	=	"";
  $base 		=	"criterium";
  if(!mysql_connect($server,$user,$password))
  {
  	exit('echec de la connection à la base de donnée avec les paramètres: server=['.$server.'], user=['.$user.'], password=['.$password.']');
  }
  if(!mysql_select_db($base))
  {
  	exit('echec lors de la séléction de la base de donnée avec le paramètre base=['.$base.']');
  }
}
?>