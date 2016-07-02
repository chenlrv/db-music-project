<?php
include('sql_funcs.php'); 
session_start();

/** Index functions **/

function print_genre_name($genre){
/* prints the genre name that was chosen by the user, by using helper function 'get_genre_name_by_id', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */ 

	$result = get_genre_name_by_id($genre);
						
	$row = $result->fetch_array();
	echo $row['name'];

}


function random_artist(){
/* creates a link to a random artist page. We get a random artist ID by the helper function 'get_random_artist' which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */ 

	$result = get_random_artist();
	$row = $result->fetch_array();
	echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['artist_name']."' class='button2'><img src='artistb.gif'></a><tr><tr>";
}


function random_band(){
/*creates a link to a random band page. We get a random band ID by the helper function 'get_random_band'. */

	$result = get_random_band();
	$row = $result->fetch_array();
	echo  "<a   id ='herfBand' name ='herfBand' href='ArtistPage.php?band=".$row['ID']."' onClick='DoBand();' value='".$row['band_name']."' class='button2'><img src='bandb.gif'></a>";
}


/**OptionsPage functions**/

function print_genre_info($genre){
/* prints the information of the chosen genre by using helper function 'get_genre_info' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  If there is information to show the user, we print it. Otherwise, we print 'No data available'. */

	$result = get_genre_info($genre);
	$row = $result->fetch_array();
	if (is_null($row['comment']) || strcmp("NULL",$row['comment'])==0){
		echo "No data available";
	}
	else{
		echo $row['comment'];	
	}

}


function print_genre_popular_years($genre){
/* we get the popular years of the chosen genre by checking popularity of artists and bands of the genre, 
  by using two helper functions:  'get_genre_popular_years_artist' and 'get_genre_popular_years_band', both run a corresponding SQL query (details in the file 'sql_funcs.php').
  If there is information to show the user, we print it. Otherwise, we print 'No data available'. */

	$result = get_genre_popular_years_artist($genre);
						
	$number = $result->num_rows;	
	if ($number>0){
		echo"Artists: ";
			
		$sum =0;
							
		while($row = $result->fetch_array()){
			$sum+=1;
					
			if ($row['ranges'] !='null'){
				echo $row['ranges'];
				
				if ($sum<$number){
					echo", ";
				}else{
					echo "<br>";
				}
			}
		}
	}
		
	$result2 = get_genre_popular_years_band($genre);
														
	$number2 = $result2->num_rows;	
	  if ($number2>0){
		echo"Bands: ";
					 
		$sum =0;
		
		while($row = $result2->fetch_array()){
			$sum+=1;
			
			if ($row['ranges'] !='null'){
				echo $row['ranges'];
				
				if ($sum<$number2){		
					echo", ";
				}
			}					
		}									
	}
								
	if ($number==0 && $number2==0){
		echo"No data available";			
	}	
}
		
		
function print_genre_start_year($genre){
/* we get the start year of the chosen genre by using the helper function 'get_genre_start_year' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  If there is information to show the user, we print it. Otherwise, we print 'No data available'. */


	$result = get_genre_start_year($genre);
	
	$number = $result->num_rows;	
	 if ($number==0){
		echo"No data available";
	}else{
	
		$sum =0;
							
		while($row = $result->fetch_array()) {
			$sum+=1;
			echo $row['activeYearsStartYear'];
			if ($sum<$number){
				echo", ";
			}
		}
	}
}

		
function print_genre_most_active_band($genre){	
/* we get the most active band of the chosen genre by using the helper function 'get_genre_most_active_band' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every band of the most active bands as a link to the corresponding band page, and the user can click on it and read further about the band.
   If no information was returned, we print 'No data available'. */

	$result = get_genre_most_active_band($genre);	
	$row = $result->fetch_array();
	$number = $result->num_rows;	
	if ($number==0 || is_null($row['name'])){
		echo "No data available";
	}else{
							
		$sum =0;
		do{
			$sum+=1;
			echo  "<a   id ='herfBand' name ='herfBand' href='ArtistPage.php?band=".$row['ID']."' onClick='DoBand();' value='".$row['name']."'>".$row['name']."</a>";
			echo ", active for ".$row['activeYearsEndYear - activeYearsStartYear+1']." years";
			if ($sum<$number){
				echo ",  ";
			}			
		}while($row = $result->fetch_array());				
		}
}
					

function print_genre_most_active_artist($genre){
/* we get the most active artist of the chosen genre by using the helper function 'get_genre_most_active_artist' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every artist of the most active artists as a link to the corresponding artist page, and the user can click on it and read further about the artist.
   If no information was returned, we print 'No data available'. */

	$result = get_genre_most_active_artist($genre);	
	$row = $result->fetch_array();
	$number = $result->num_rows;
	
	if ($number==0 || is_null($row['artist_name'])){
		echo"No data available";
	}else{	
	
		$sum =0;
		do{
			$sum+=1;
			
			echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['name']."'>".$row['name']."</a>";
			echo ", active for ".$row['activeYearsEndYear - activeYearsStartYear+1']." years";
			if ($sum<$number){
				echo "  ,  ";
			}							
		}while($row = $result->fetch_array());							
	}		
}
	
		
function print_genre_stylistic_origins($genre){	
/* we get the stylistic origins of the chosen genre by using the helper function 'get_genre_stylistic_origins' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every genre that is a stylistic origin of the chosen genre as a link to the corresponding stylistic-origin-genre page, and the user can click on it and read further about the genre.
  If no information was returned, we print 'No data available'. */

	$result = get_genre_stylistic_origins($genre);	

	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{
	
		$sum =0;
	
		while($row = $result->fetch_array()){
			$sum+=1;
			echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  ";
			}						
		}
	}
}


function print_genre_subgenres($genre){
/* we get the subgenres of the chosen genre by using the helper function 'get_genre_subgenres' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every genre that is a subgenre of the chosen genre as a link to the corresponding subgenre page, and the user can click on it and read further about the subgenre.
  If no information was returned, we print 'No data available'. */

	$result = get_genre_subgenres($genre);	

	$number = $result->num_rows;	
					 
	if ($number==0){
		echo"No data available";
	}else{

		$sum =0;
		while($row = $result->fetch_array()){
			$sum+=1;
								
			echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  ";
			}						
		}	
	}
}


function print_genre_derivated($genre){
/* we get the derivated genres of the chosen genre by using the helper function 'get_genre_derivated' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every genre that is a derivated genre of the chosen genre as a link to the corresponding derivated genre page, and the user can click on it and read further about the derivated genre.
  If no information was returned, we print 'No data available'. */


	$result = get_genre_derivated($genre);
	
	$number = $result->num_rows;	
	 
	if ($number==0){
		echo"No data available";
	}else{
		
		$sum =0;
		while($row = $result->fetch_array()) {
			$sum+=1;
		
			echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){			
				echo ",  ";
			}								
		}
	}
}
	
	
function print_genre_artists($genre){
/* we get the artists of the chosen genre by using the helper function 'get_genre_artists' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every artist of the chosen genre as a link to the corresponding artist page, and the user can click on it and read further about the artist.
  If no information was returned, we print 'No data available'. */

	$result = get_genre_artists($genre);

	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{
		
		$sum =0;
		while($row = $result->fetch_array()){
			$sum+=1;
			echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['artist_name']."'>".$row['artist_name']."</a>";
			if ($sum<$number){
				echo ",  "; 
			}						
		}
	}
}							


function print_genre_bands($genre){
/* we get the bands of the chosen genre by using the helper function 'get_genre_bands' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every band of the chosen genre as a link to the corresponding band page, and the user can click on it and read further about the band.
  If no information was returned, we print 'No data available'. */

	$result = get_genre_bands($genre);
	
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{

		$sum =0;
		while($row = $result->fetch_array()){
			$sum+=1;
			echo  "<a   id ='herfBand' name ='herfBand' href='ArtistPage.php?band=".$row['ID']."' onClick='DoBand();' value='".$row['band_name']."'>".$row['band_name']."</a>";
			if ($sum<$number){
				echo ",  "; 
			
			}						
		}
	}
}
	
	
function print_genre_songs($genre){
/* we get the songs of the chosen genre by using the helper function 'get_genre_songs' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every song of the chosen genre as a link to the corresponding song page, and the user can click on it and read further about the song.
  If no information was returned, we print 'No data available'. */


	$result = get_genre_name_by_id($genre);
	$row = $result->fetch_array();
	$name = $row['name'];
	
	if ($name != "Classical music composition"){
		$result = get_genre_songs($genre);	
	}else{
		$result = get_classical_songs();	
	}
							
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{
					 
		$sum =0;
		while($row = $result->fetch_array()) {
			$sum+=1;
			if ($name != "Classical music composition"){
					echo  "<a   id ='herfSong' name ='herfSong' href='Song.php?song=".$row['ID']."' onClick='DoSong();' value='".$row['name']."'>".$row['name']."</a>";
			}else{
				
				 echo "<a   id ='herfclassical' name ='herfclassical' href='ClassicalComp.php?comp=".$row['ID']."' onClick='DoClassicalSong();' value='".$row['name']."'>".$row['name']."</a>";
			}
			if ($sum<$number){
				echo ",  ";
			}				
		}
	}
}				
		
	
function print_genre_albums($genre){	
/* we get the albums of the chosen genre by using the helper function 'get_genre_albums' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of every album of the chosen genre as a link to the corresponding album page, and the user can click on it and read further about the album.
  If no information was returned, we print 'No data available'. */


	$result = get_genre_albums($genre);
	
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{

		$sum =0;
		while($row = $result->fetch_array()){
			$sum+=1;
			echo  "<a   id ='herfAlbum' name ='herfAlbum' href='Album.php?album=".$row['ID']."' onClick='DoAlbum();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  "; 
			}							
		}
	}
}
	
	
function print_suggested_genres($genre){	
/* we get suggested other genres of the chosen genre by using two helper functions 'get_suggested_genres_by_artists' and 'get_suggested_genres_by_songs' which run a corresponding SQL query (details in the file 'sql_funcs.php').
  We print the name of suggested genre of the chosen genre as a link to the corresponding suggested genre page, and the user can click on it and read further about the suggested genre.
  If no information was returned, we print 'No data available'. */


	$result = get_suggested_genres_by_artists($genre);
	$result2 = get_suggested_genres_by_songs($genre);
	
	$number = $result->num_rows;
	$number2 = $result2->num_rows;	
	
	if (($number !=0)||($number2 !=0)){
	
	
	echo "<div class =scrollsection5> <h1><u>Suggested other genres you may like: </u></h1>";
	if((($number !=0) &&($number2 !=0))||(($number ==0) &&($number2 !=0))){
		echo "Suggested by artists: ";
		$sum =0;
		while($row = $result->fetch_array()) {
			$sum+=1;
		    echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if($sum<$number){
			echo ",  ";
			}
		}
		echo "<br><br>";
		$sum =0;
		echo "Suggested by songs: ";
		while($row = $result2->fetch_array()){
			$sum+=1;
			echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if($sum<$number2){
				echo ",  ";
			}								
		}
	}else if (($number !=0) &&($number2 ==0)){
		$sum =0;
		echo "Suggested by artists: ";
		while($row = $result->fetch_array()) {
										
			echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
			if($sum<$number){
				 echo ",  ";
			}								
		}
	 }	
	}

}


/**classical music functions**/

function get_classical_name_php($song){
/* returns the name of a chosen song from the 'Classical music' genre, by using helper function 'get_classical_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */ 

	$result = get_classical_name($song);						
	$row = $result->fetch_array();
	$song_name = $row['name'];
	
	return $song_name;
	
}


function print_classical_name($song){
/* prints the name of a chosen song from the 'Classical music' genre, by using helper function 'get_classical_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */
 
	$result = get_classical_name($song);						
	$row = $result->fetch_array();
	$song_name = $row['name'];
	echo $song_name;
}


function print_classical_info($song){
/* we get the information of a chosen song from the 'Classical music' genre, by using helper function 'get_classical_info', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */
 
	$result = get_classical_info($song);		
	$row = $result->fetch_array();
	if ($row['comment'] != "NULL" && ($row['comment'] !="")){
			echo $row['comment'];
	}
}


function print_classical_composer($song){
/* we get the composer of a chosen song from the 'Classical music' genre, by using helper function 'get_classical_composer', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */
 

	$result = get_classical_composer($song);		
	$row = $result->fetch_array();
	if ($row['composer'] != "NULL" && ($row['composer'] !="")){
			echo $row['composer'];
	}else{
		echo"No data available";
	}		
}


function get_classical_composer_php($song){
/* returns the composer ID of a chosen song from the 'Classical music' genre, by using helper function 'get_classical_composer', which runs a corresponding SQL query (details in the file 'sql_funcs.php'. */

	$result = get_classical_composer($song);		
	$row = $result->fetch_array();
	$composer = $row['composer'];
	return $composer; 
	
}


/**Song functions**/

function get_song_name_php($song){
/* returns the name of a chosen song, by using helper function 'get_song_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	$result = get_song_name($song);						
	$row = $result->fetch_array();
	$song_name = $row['name'];	
	return $song_name;
}


function print_song_name($song){
/* prints the name of a chosen song, by using helper function 'get_song_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	$result = get_song_name($song);						
	$row = $result->fetch_array();
	$song_name = $row['name'];
	echo $song_name;
}


function print_song_info($song){
/* prints the information of a chosen song, by using helper function 'get_song_info', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	$result = get_song_info($song);		
	$row = $result->fetch_array();
	echo $row['comment'];
}

function print_song_year($song){
/* we get the year of a chosen song by using helper function 'get_song_year', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */
 
	$result = get_song_year($song);		
	$row = $result->fetch_array();
	if (is_null($row['year']) || strcmp("NULL", $row['year'])==0){
		echo "No data available";		
	}else{
		echo $row['year'];
	}
}

function print_song_album($song){
/* we get the album of a chosen song by using helper function 'get_song_album', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */
 

	$result = get_song_album($song);		
	$row = $result->fetch_array();
	if (is_null($row['Album']) || strcmp("NULL", $row['Album'])==0){			
		echo "No data available";										
	}else{
		echo $row['Album'];	
	}
}

function print_suggested_songs($song){
/* we get the suggested songs of the chosen song by using the helper function 'get_suggested_songs' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every suggested song of the chosen song as a link to the corresponding song page, and the user can click on it and read further about the song.
   If no information was returned, we print 'No data available'. */


	$result = get_suggested_songs($song);
	$number = $result->num_rows;
	 if ($number==0){
		echo"No results";
	 }else{
	 
		$sum =0;
		while($row = $result->fetch_array()) {
			$sum+=1;
			echo  "<a   id ='herfSong' name ='herfSong' href='Song.php?song=".$row['ID']."' onClick='DoSong();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  ";								
			}
		}
	 }		
}

function print_did_you_know($song){
/* we get the songs that have a common genre with the chosen song, and have at least 3 more different genres, by using the helper function 'get_did_you_know' which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every suitable song as a link to the corresponding song page, and the user can click on it and read further about the song.
   If no information was returned, we print 'No data available'. */

	$result = get_did_you_know($song);

	$number = $result->num_rows;	
	if ($number==0){
		echo"No results";
	}else{
		$sum =0;								
		while($row = $result->fetch_array()) {
			$sum+=1;
			echo  "<a   id ='herfSong' name ='herfSong' href='Song.php?song=".$row['ID']."' onClick='DoSong();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  ";
			}
		}	
	}
}



function update_song($song){
/* creates a link to update the song page */

	echo  "<a   id ='updatesong' name ='updatesong' href='update_song.php?song=".$song."' onClick='DoSongUpdate();' value='".$song."' >here</a>";	
}




/**Album functions**/
/* prints the name of a chosen album, by using helper function 'get_album_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

function print_album_name($album){
	$result = get_album_name($album);		
	$row = $result->fetch_array();
	echo $row['name'];
}


function print_album_info($album){
/* prints the information of a chosen album, by using helper function 'get_album_info', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	$result = get_album_info($album);		
	$row = $result->fetch_array();
	echo $row['comment'];
}


function print_album_release_date($album){
/* we get the release date of a chosen album by using helper function 'get_album_release_date', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */

	$result = get_album_release_date($album);		
	$row = $result->fetch_array();
	if (is_null($row['released']) ||strcmp("NULL", $row['released'])== 0){
		echo "no results";	
	}else{
		echo $row['released'];
	}
}

function print_album_type($album){
/* we get the type of a chosen album by using helper function 'get_album_type', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   If there is information to show the user, we print it. Otherwise, we print 'No data available'. */

	$result = get_album_type($album);		
	$row = $result->fetch_array();
	if (is_null($row['type']) ||strcmp("NULL", $row['type'])== 0){
		echo "no results";	
	}else{
		echo $row['type'];
	}
}


function update_album($album){
/* creates a link to update the album page */

	echo  "<a   id ='updatealbum' name ='updatealbum' href='update_album.php?album=".$album."' onClick='DoAlbumUpdate();' value='".$album."' >here</a>";
		
}


/**Artist functions**/

function print_artist_name($artist, $band){
/* prints the name of a chosen artist/band, by using helper function 'get_artist_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
			$str = "MusicalArtist";
			$result= get_artist_name($artist, $str);
	}
	else{
		$str ="Band";
		$result = get_artist_name($band, $str);
	}	
	$row = $result->fetch_array();
	$artist_name = $row['name'];
	echo $artist_name;
}	


function get_artist_name_php($artist, $band){
/* returns the name of a chosen artist/band, by using helper function 'get_artist_name', which runs a corresponding SQL query (details in the file 'sql_funcs.php'). */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
			$str = "MusicalArtist";
			$result= get_artist_name($artist, $str);
	}
	else{
		$str ="Band";
		$result = get_artist_name($band, $str);
	}	
					
	$row = $result->fetch_array();
	$artist_name = $row['name'];
	
	return $artist_name;
}

				
function print_artist_info($artist, $band){	
/* we get the information of a chosen artist/band by using helper function 'get_artist_info', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of the chosen artist/band, and if it is a band, we print every band member's name as a link to the corresponding artist page, and the user can click on it and read further about the band member.
   If no information was returned, we print 'No data available'. */

 	
	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){	
		$str = "MusicalArtist";
		$result= get_artist_info($artist, $str);
		$row = $result->fetch_array();
		echo $row['comment'];
	}else{
		$str ="Band";
		$result = get_artist_info($band, $str);
		$row = $result->fetch_array();
		echo $row['comment'];
		echo"<br><br>";			
		echo"<h1><u>Band Members:</u></h1>";
		$result = get_band_members($band);
	
		$number = $result->num_rows;	
	
		if ($number==0){
			echo"No data available";
		}else{
							 
			$sum = 0;
			while($row = $result->fetch_array()) {
				$sum+=1;
				echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['name']."'>".$row['name']."</a>";
				if ($sum<$number){
					echo ",  ";
				}
			}
		}
	}	
}

	
function print_artist_pic($artist, $band){
/* we get the get the picture of a chosen artist/band by using helper function 'get_artist_pic', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   if the picture is valid we show it on the website, otherwise we print 'No picture available'. */
	
	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str = "MusicalArtist";
		$result = get_artist_pic($artist, $str);
	}else{	
		$str ="Band";
		$result = get_artist_pic($band, $str);
	}
	$number = $result->num_rows;	
	$row = $result->fetch_array();
	$imglink = $row['imageLink'];
							
	if ($number==0 || strcmp($imglink,"NULL") == 0){
		echo"No picture available";
	}else{							
		echo "<img src=".$row['imageLink']."  alt=picLink>";
	}

}	

	
function print_artist_featured_songs($artist, $band){
/* we get the featured songs of a chosen artist/band by using helper function 'get_artist_featured_songs', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every featured song of the chosen artist/band as a link to the corresponding song page, and the user can click on it and read further about the song.
   If no information was returned, we print 'No data available'. */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "MusicalArtist";
		$str2 = "Songs_MusicalArtist";
		$result =  get_artist_featured_songs($artist, $str1, $str2);
	}else{
		$str1 = "Band";
		$str2 = "Songs_Band";
		$result =  get_artist_featured_songs($band, $str1, $str2);
	}
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{
							 
		$sum = 0;
		while($row = $result->fetch_array()){
			$sum+=1;
			$artist_name = get_artist_name_php($artist, $band);
	
			echo  "<a   id ='herfSong' name ='herfSong' href='Song.php?song=".$row['ID']."&artist=".$artist_name."' onClick='DoSong();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
					echo ",  ";
			}
		}
	}
}

	
function print_artist_featured_albums($artist, $band){	
/* we get the featured albums of a chosen artist/band by using helper function 'get_artist_featured_albums' , which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every featured album of the chosen artist/band as a link to the corresponding album page, and the user can click on it and read further about the album.
   If no information was returned, we print 'No data available'. */


	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "MusicalArtist";
		$str2 = "Album_MusicalArtist";
		$result = get_artist_featured_albums($artist, $str1, $str2);
	}else{
		$str1 = "Band";
		$str2 = "Album_Band";
		$result = get_artist_featured_albums($band, $str1, $str2);
	}
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}else{
							 
		$sum = 0;	
		while($row = $result->fetch_array()) {
			$sum+=1;
								
			echo  "<a   id ='herfAlbum' name ='herfAlbum' href='Album.php?album=".$row['ID']."' onClick='DoAlbum();' value='".$row['name']."'>".$row['name']."</a>";
			if ($sum<$number){
				echo ",  ";
			}							
		}
	}
}
		

function print_suggested_artists($artist, $band){
/* we get the suggested artists of a chosen artist/band by using two helper functions: 'get_suggested_artists_from_the_same_terms' and 'get_suggested_artists_from_different_term', 
   which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every suggested artist of the chosen artist/band as a link to the corresponding artist page, and the user can click on it and read further about the artist.
   If no information was returned, we print 'No data available'. */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "MusicalArtist";
		$str2 = "MusicalArtist_MusicGenre";
		$result = get_suggested_artists_from_the_same_term($artist, $str1, $str2);
	}else{	
		$str1 = "MusicalArtist";
		$str2 = "Band";
		$str3 = "MusicalArtist_MusicGenre";
		$str4 = "Band_MusicGenre";
		$result = get_suggested_artists_from_different_term($band, $str1, $str2, $str3, $str4);
	}
	
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}
							 
	$sum = 0;
	while($row = $result->fetch_array()){
		$sum+=1;
								
		echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['name']."'>".$row['name']."</a>";	
		if ($sum<$number){
			echo ",  ";
		}				
	}
}


function print_suggested_bands($artist, $band){
/* we get the suggested bands of a chosen artist/band by using two helper functions: 'get_suggested_artists_from_the_same_terms' and 'get_suggested_artists_from_different_term', 
   which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every suggested bands of the chosen artist/band as a link to the corresponding band page, and the user can click on it and read further about the band.
   If no information was returned, we print 'No data available'. */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "Band";
		$str2 = "MusicalArtist";
		$str3 = "Band_MusicGenre";
		$str4 = "MusicalArtist_MusicGenre";
		$result = get_suggested_artists_from_different_term($artist, $str1, $str2, $str3, $str4);			
	}else{	
		$str1 = "Band";
		$str2 = "Band_MusicGenre";		
		$result = get_suggested_artists_from_the_same_term($band, $str1, $str2);
	}
	
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}
							 
	$sum = 0;
	while($row = $result->fetch_array()){
		$sum+=1;
								
			echo  "<a   id ='herfBand' name ='herfBand' href='ArtistPage.php?band=".$row['ID']."' onClick='DoBand();' value='".$row['name']."'>".$row['name']."</a>";
		if ($sum<$number){
			echo ",  ";
		}
				
	}
}	


function print_suggested_genres_artistpage($artist, $band){
/* we get the suggested genres of a chosen artist/band by using the helper functions: 'get_suggested_genres_artistpage', which runs a corresponding SQL query (details in the file 'sql_funcs.php').
   We print the name of every suggested genre of the chosen artist/band as a link to the corresponding genre page, and the user can click on it and read further about the genre.
   If no information was returned, we print 'No data available'. */

	
	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "MusicalArtist";
		$str2 = "MusicalArtist_MusicGenre";
		$result = get_suggested_genres_artistpage($artist, $str1, $str2);
	}else{
		$str1 = "Band";
		$str2 = "Band_MusicGenre";
		$result = get_suggested_genres_artistpage($band, $str1, $str2);
	}
	$number = $result->num_rows;	
	if ($number==0){
		echo"No data available";
	}
							 
	$sum = 0;	
	while($row = $result->fetch_array()) {
		$sum+=1;
								
		echo  "<a   id ='relatedGenre' name ='relatedGenre' href='OptionsPage.php?genre=".$row['ID']."' onClick='DoSelectedGenre();' value='".$row['name']."'>".$row['name']."</a>";
		if ($sum<$number){
			echo ",  ";
		}							
	}
}


function update_art_band($artist, $band){
/* creates a link to update the artist/band page */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
			echo  "<a   id ='updateartist' name ='updateartist' href='update_artist_band.php?artist=".$artist."' onClick='DoArtistpdate();' value='".$artist."' >here</a>";
	}else{
		echo  "<a   id ='updateband' name ='updateband' href='update_artist_band.php?band=".$band."' onClick='DoBandUpdate();' value='".$band."' >here</a>";
	}	
}
	


	
/** For Video **/

function artist_featured_songs($artist, $band){
/* returns information to concat to the youtube link in order to show a relevant youtube video */

	if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
		$str1 = "MusicalArtist";
		$str2 = "Songs_MusicalArtist";
		$result =  get_artist_featured_songs($artist, $str1, $str2);
	}else{
		$str1 = "Band";
		$str2 = "Songs_Band";
		$result =  get_artist_featured_songs($band, $str1, $str2);
	}
	$number = $result->num_rows;	
	if ($number==0){
		if (isset($_GET['artist']) && (! ($_GET['artist'] ==''))){
				return "singer";
		}else{
				return "band";
		}
	}
	else{
		$row = $result->fetch_array();
		return $row['name'];
	}
}



/** Search page functions **/

function bind_result_array($stmt)
{
    $meta = $stmt->result_metadata();
    $result = array();
    while ($field = $meta->fetch_field())
    {
        $result[$field->name] = NULL;
        $params[] = &$result[$field->name];
    }
 
    call_user_func_array(array($stmt, 'bind_result'), $params);
    return $result;
}
 

function getCopy($row){
/* Returns a copy of an array of references */

    return array_map(create_function('$a', 'return $a;'), $row);
}



function get_artist_band_results($term1){
/*this function prints the results to the search of a certain artist or bandm*/
	
$stmt1 = $GLOBALS['mysqli']->prepare( "SELECT DISTINCT ID,name FROM MusicalArtist WHERE name LIKE ?"); 
$stmt1 ->bind_param('s',$term1);
$stmt1->execute();

$row = bind_result_array($stmt1);

if(!$stmt1->error){

		while($stmt1->fetch()){
			$rows[$row['ID']] = getCopy($row);
		}
			
		$array_length1 = sizeof($rows);
		
		if ($array_length1 >0){	
			echo "<h1><u>Artist results:</h1></u>";
		
	
			$sum = 0;
			foreach ($rows as $row ){
		   
				$sum+=1;
													
				echo  "<a   id ='herfArtist' name ='herfArtist' href='ArtistPage.php?artist=".$row['ID']."' onClick='DoArtist();' value='".$row['name']."'>".$row['name']."</a>";
				if ($sum < $array_length1){
				echo ", ";			
				} else{
					echo "<br><br>";
				}				
			}
		}
		
		
		$stmt2 = $GLOBALS['mysqli']->prepare( "SELECT DISTINCT ID,name FROM Band WHERE name LIKE ?"); 
		$stmt2 ->bind_param('s',$term1);
		$stmt2->execute();
		$row2 = bind_result_array($stmt2);
		
		if(!$stmt2->error){

			while($stmt2->fetch()){
			$rows2[$row2['ID']] = getCopy($row2);
			}
			
			$array_length2 = sizeof($rows2);
		
			if ($array_length2 >0){	
				echo "<h1><u>Band results:</h1></u>";
				
				$sum = 0;
				foreach ($rows2 as $row2 ){
		   
					$sum+=1;
													
					echo  "<a   id ='herfBand' name ='herfBand' href='ArtistPage.php?band=".$row2['ID']."' onClick='DoBand();' value='".$row2['name']."'>".$row2['name']."</a>";
					if ($sum < $array_length2)
					echo ", ";																			
				}
			}
			
			if ($array_length1 ==0 && $array_length2 ==0){
				echo "No results.<br> Haven't found what you are looking for? you can add a missing artist or band <a href='new_data.php'><b>here</b></a>.";
			}
				
	}else{
				echo "No results.<br> Haven't found what you are looking for? you can add a missing artist or band <a href='new_data.php'><b>here</b></a>.";           
	}
	
}else{
				echo "No results.<br> Haven't found what you are looking for? you can add a missing artist or band <a href='new_data.php'><b>here</b></a>.";
}	

	
	
}


function get_song_results($term1){
/*this function prints the results to the search of a certain song*/
$stmt = $GLOBALS['mysqli']->prepare( "SELECT DISTINCT ID,name FROM Songs WHERE name LIKE ?"); 
$stmt ->bind_param('s',$term1);
$stmt->execute();

$row = bind_result_array($stmt);
 if(!$stmt->error){

		while($stmt->fetch()){
			$rows[$row['ID']] = getCopy($row);
		}
			
		$array_length = sizeof($rows);
		
		if ($array_length >0){	
			echo "<h1><u>Song results:</h1></u>";

	
			$sum = 0;
			foreach ($rows as $row ) {
		   
				$sum+=1;
								
						
				echo  "<a   id ='herfSong' name ='herfSong' href='Song.php?song=".$row['ID']."' onClick='DoSong();' value='".$row['name']."'>".$row['name']."</a>";
				if ($sum < $array_length)
				echo ", ";
								
			}	
		}else{
				echo "No results.<br> Haven't found what you are looking for? you can add a missing song <a href='new_data.php'><b>here</b></a>.";
		}			
							
	}else{
				echo "No results.<br> Haven't found what you are looking for? you can add a missing song <a href='new_data.php'><b>here</b></a>.";            
	}	

}


function get_album_results($term1){
/*this function prints the results to the search of a certain album*/	
	
	$stmt = $GLOBALS['mysqli']->prepare( "SELECT DISTINCT ID,name FROM Album WHERE name LIKE ?"); 
	$stmt ->bind_param('s',$term1);
	$stmt->execute();

	$row = bind_result_array($stmt);
	if(!$stmt->error){

		while($stmt->fetch()){
			$rows[$row['ID']] = getCopy($row);
		}
			
		$array_length = sizeof($rows);
	
	
		if ($array_length >0){	
			echo "<h1><u>Album results:</h1></u>";

		
			$sum = 0;
			foreach ($rows as $row){
		   
				$sum+=1;
								
						
				echo  "<a   id ='herfAlbum' name ='herfAlbum' href='Album.php?album=".$row['ID']."' onClick='DoAlbum();' value='".$row['name']."'>".$row['name']."</a>";
				if ($sum < $array_length)
				echo ", ";													
			}
		}else{
				echo "No results.<br> Haven't found what you are looking for? you can add a missing album <a href='new_data.php'><b>here</b></a>.";
		}
 }else{
		echo "No results.<br> Haven't found what you are looking for? you can add a missing album <a href='new_data.php'><b>here</b></a>.";
 }
}

	
?>