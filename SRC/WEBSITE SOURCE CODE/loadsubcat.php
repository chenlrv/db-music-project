<?php 
include('config.php');
 
/**show sub-genres of the chosen music genre in the drop-down **/

$parent_cat = $_GET['parent_cat'];
 
$query = $mysqli->query("SELECT MusicGenre. *
 from MusicGenre,MusicGenre_MusicGenreTop,MusicGenreTop
where MusicGenre.id = MusicGenre_MusicGenreTop.MusicGenre and MusicGenre_MusicGenreTop.TopGenre =MusicGenreTop.ID
and MusicGenreTop.ID= {$parent_cat}");

while($row = $query->fetch_array()) {
	echo "<option value='$row[ID]'>$row[name]</option>";
}
 
?>