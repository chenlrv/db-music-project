<?php

 if(isset($_GET['go']){ // button name
	
	$parent_cat = $_GET['sub_cat'];
 
	$query = mysql_query("SELECT * FROM musicgenre WHERE ID = {$sub_cat}");
	while($row = mysql_fetch_array($query)) {
	echo "$row[comment]";
	header("Location: OptionsPage.php");
}
	
 }
 
 ?>