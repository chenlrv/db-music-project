<?php
include ('config.php');

/**MainPage functions**/

function get_genres(){
/*select all the genres ordered by name*/

	return run_query("SELECT * FROM MusicGenreTop order by name");
}


function get_random_artist(){
/*select random artist*/

	return run_query("SELECT MusicalArtist.ID as ID, MusicalArtist.name as artist_name
				FROM MusicalArtist
				ORDER BY RAND()
				LIMIT 1");
}


function get_random_band(){
/*select random band*/

	return run_query("SELECT Band.name as band_name,Band.ID as ID
						FROM Band
						ORDER BY RAND()
						LIMIT 1");
}


/**OptionsPage functions**/

function get_genre_name_by_id($genre){
/*select the name of the genre by its id*/

	return run_query("SELECT name FROM MusicGenre WHERE ID = {$genre}");	
}


function get_genre_info($genre){
/*select the comment of the genre by its id*/

	return run_query("SELECT comment FROM MusicGenre WHERE ID  = {$genre}");	
}


function get_genre_popular_years_artist($genre){
/*select the most active years of this genre by the first active year of artists
  of this genre divided into groups by the decade and count the number of artists
  that started to be active in this decade*/

	return run_query("SELECT s.ranges as ranges, s.numArtists 
						FROM
						(select Distinct t.years as ranges, count(*) as numArtists
						from (
						  select case 
						   when ActiveYearsStartYear between '1920' and '1929' then '20s' 
						   when ActiveYearsStartYear between '1930' and '1939' then '30s'
							when ActiveYearsStartYear between '1940' and '1949' then '40s'
							when ActiveYearsStartYear between '1950' and '1959' then '50s'
							when ActiveYearsStartYear between '1960' and '1969' then '60s'
							when ActiveYearsStartYear between '1970' and '1979' then '70s'
							when ActiveYearsStartYear between '1980' and '1989' then '80s'
							when ActiveYearsStartYear between '1990' and '1999' then '90s'
							when ActiveYearsStartYear between '2000' and '2020' then '2000s'
							else 'null' end as years
						  from MusicalArtist
						  where
						  MusicalArtist.ID in (select MusicalArtist_MusicGenre.MusicalArtist
						  from 
						  MusicalArtist_MusicGenre join MusicalArtist 
						  on MusicalArtist.ID=MusicalArtist_MusicGenre.MusicalArtist
						  join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.musicGenre
						  where MusicGenre.ID={$genre})) t
						group by t.years)s
						WHERE s.numArtists IN (SELECT MAX(y.numArtists) from 
										(select t.years as ranges, count(*) as numArtists
						from (
						  select case  
						  when ActiveYearsStartYear between '1920' and '1929' then '20s' 
						   when ActiveYearsStartYear between '1930' and '1939' then '30s'
							when ActiveYearsStartYear between '1940' and '1949' then '40s'
							when ActiveYearsStartYear between '1950' and '1959' then '50s'
							when ActiveYearsStartYear between '1960' and '1969' then '60s'
							when ActiveYearsStartYear between '1970' and '1979' then '70s'
							when ActiveYearsStartYear between '1980' and '1989' then '80s'
							when ActiveYearsStartYear between '1990' and '1999' then '90s'
							when ActiveYearsStartYear between '2000' and '2020' then '2000s'
							else 'null' end as years
						  from MusicalArtist
						  where
						  MusicalArtist.ID in (select MusicalArtist_MusicGenre.MusicalArtist
						  from 
						  MusicalArtist_MusicGenre join MusicalArtist
						  on MusicalArtist.ID=MusicalArtist_MusicGenre.MusicalArtist
						  join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.musicGenre
						  where MusicGenre.ID={$genre})) t
						group by t.years
										)y);");	
}


function get_genre_popular_years_band($genre){
/*select the most active years of this genre by the first active year of bands
of this genre divided into groups by the decade and count the number of bands
than started to be active in this decade */

	return run_query("SELECT s.ranges, s.numArtists 
			FROM
	(select t.years as ranges, count(*) as numArtists
	from (
	  select case  
		when ActiveYearsStartYear between '1950' and '1959' then '50s'
		when ActiveYearsStartYear between '1960' and '1969' then '60s'
		when ActiveYearsStartYear between '1970' and '1979' then '70s'
		when ActiveYearsStartYear between '1980' and '1989' then '80s'
		when ActiveYearsStartYear between '1990' and '1999' then '90s'
		when ActiveYearsStartYear between '2000' and '2020' then '2000s'
		else 'null' end as years
	  from Band
	  where
	  Band.ID in (select Band_MusicGenre.Band
	  from 
	  Band_MusicGenre join Band 
	  on Band.ID=Band_MusicGenre.Band
	  join MusicGenre on MusicGenre.ID=Band_MusicGenre.musicGenre
	  where MusicGenre.ID={$genre})) t
	group by t.years)s
    WHERE s.numArtists IN (SELECT MAX(y.numArtists) from 
					(select t.years as ranges, count(*) as numArtists
	from (
	  select case  
		when ActiveYearsStartYear between '1950' and '1959' then '50s'
		when ActiveYearsStartYear between '1960' and '1969' then '60s'
		when ActiveYearsStartYear between '1970' and '1979' then '70s'
		when ActiveYearsStartYear between '1980' and '1989' then '80s'
		when ActiveYearsStartYear between '1990' and '1999' then '90s'
		when ActiveYearsStartYear between '2000' and '2020' then '2000s'
		else 'null' end as years
	  from Band
	  where
	 Band.ID in (select Band_MusicGenre.Band
	  from 
	  Band_MusicGenre join Band
	  on Band.ID=Band_MusicGenre.Band
	  join MusicGenre on MusicGenre.ID=Band_MusicGenre.musicGenre
	  where MusicGenre.ID={$genre})) t
	group by t.years
					)y);");

}

function get_genre_start_year($genre){
/*select the minimal year that artist of this genre started to be active */

	return run_query("select DISTINCT activeYearsStartYear
					from MusicalArtist 
					join MusicalArtist_MusicGenre
					on MusicalArtist.ID=MusicalArtist_MusicGenre.MusicalArtist
					join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.MusicGenre
					WHERE activeYearsStartYear=(SELECT MIN(activeYearsStartYear) FROM 
																				MusicalArtist 
																					join MusicalArtist_MusicGenre
																					on MusicalArtist.ID=MusicalArtist_MusicGenre.MusicalArtist
																					join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.MusicGenre
																					WHERE ActiveYearsStartYear >= 1800 AND MusicGenre.ID={$genre});");
																					
																					
}

function get_genre_most_active_band($genre){
/*select the band that its solution to (end year - start year) is the largest*/

	return run_query("SELECT DISTINCT Band.name as name,Band.ID as ID, activeYearsEndYear - activeYearsStartYear+1 
			  FROM Band join Band_MusicGenre on
			  Band.Id=Band_MusicGenre.Band
			  join MusicGenre on MusicGenre.ID=Band_MusicGenre.MusicGenre 
			  WHERE activeYearsEndYear <> 'NULL'
			  AND activeYearsStartYear <> 'NULL'
			  AND activeYearsEndYear - activeYearsStartYear >= 0 
			  AND activeYearsEndYear - activeYearsStartYear <= 100
			  AND MusicGenre.ID={$genre}
			  AND (ActiveYearsEndYear - activeYearsStartYear)+1 = (
										SELECT max((activeYearsEndYear - activeYearsStartYear)+1)
										FROM Band join Band_MusicGenre on Band.Id=Band_MusicGenre.Band
										join MusicGenre on MusicGenre.ID=Band_MusicGenre.MusicGenre
										WHERE activeYearsEndYear <> 'NULL'
										AND activeYearsStartYear <> 'NULL'
										AND MusicGenre.ID={$genre}
										)");
}

function get_genre_most_active_artist($genre){
/*select the artist that its solution to (end year - start year) is the largest */

	return run_query("SELECT DISTINCT MusicalArtist.name as name, MusicalArtist.ID as ID, activeYearsEndYear - activeYearsStartYear+1 
		         FROM MusicalArtist join MusicalArtist_MusicGenre on 
		         MusicalArtist.Id=MusicalArtist_MusicGenre.MusicalArtist
		         join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.MusicGenre 
		         WHERE activeYearsEndYear <> 'NULL'
			 AND activeYearsStartYear <> 'NULL'
			 AND activeYearsEndYear - activeYearsStartYear >= 0 
			 AND activeYearsEndYear - activeYearsStartYear <= 100
			 AND MusicGenre.ID={$genre}
			 AND (ActiveYearsEndYear - activeYearsStartYear)+1 = (
										SELECT max((activeYearsEndYear - activeYearsStartYear)+1)
										FROM MusicalArtist join MusicalArtist_MusicGenre on
										MusicalArtist.Id=MusicalArtist_MusicGenre.MusicalArtist
										join MusicGenre on MusicGenre.ID=MusicalArtist_MusicGenre.MusicGenre
										WHERE activeYearsEndYear <> 'NULL'
										AND activeYearsStartYear <> 'NULL'
										AND MusicGenre.ID={$genre});");
}
	
	
function get_genre_stylistic_origins($genre){
/*select the stylistic origins of genre */

	return run_query("SELECT DISTINCT * FROM MusicGenre as first_genre JOIN MusicGenre_MusicStylisticOriginGenre ON
								first_genre.ID = MusicGenre_MusicStylisticOriginGenre.MusicGenre JOIN MusicGenre AS g 
								ON g.ID=MusicGenre_MusicStylisticOriginGenre.MusicStylisticOriginGenre
								WHERE first_genre.ID={$genre}
								LIMIT 5;
								");
	
	
}

function get_genre_subgenres($genre){
/*select the sub genres of genre */

	return run_query("SELECT DISTINCT gen.name as name,gen.ID as ID
								FROM MusicGenre as gen, (SELECT gs.MusicSubGenre as sub_id
								FROM MusicGenre as g, MusicGenre_MusicSubGenre as gs
								WHERE g.name ={$genre} AND
									g.ID = gs.MusicGenre) as SubGenres
									WHERE gen.ID = SubGenres.sub_id
								LIMIT 10
								");
}


function get_genre_derivated($genre){
/*select the derivated genres of genre */

	return run_query("SELECT DISTINCT g.name as name, g.ID as ID
						FROM MusicGenre_MusicDerivativeGenre join MusicGenre as g
						ON MusicGenre_MusicDerivativeGenre.MusicGenre = g.ID 
						JOIN MusicGenre on MusicGenre_MusicDerivativeGenre.MusicDerivativeGenre=MusicGenre.ID
						where MusicGenre.ID={$genre}
						LIMIT 10
						");
}

function get_genre_artists($genre){
/*select the artists of genre */

	return run_query("SELECT DISTINCT a.name as artist_name,a.ID as ID FROM MusicalArtist as a, MusicGenre as g, MusicalArtist_MusicGenre as ga
													WHERE g.ID = {$genre} AND
													g.ID = ga.MusicGenre AND
												ga.MusicalArtist = a.ID
												LIMIT 50;
												");
}

function get_genre_bands($genre){
/*select the bands of genre */

	return run_query("SELECT DISTINCT b.name as band_name,b.ID
													  FROM Band as b, MusicGenre as g, Band_MusicGenre as gb
												      WHERE g.ID ={$genre} AND
													  g.ID = gb.MusicGenre AND
													  gb.Band = b.ID
													  LIMIT 50;
													  ");	
}

function get_genre_songs($genre){
	/*select the songs of genre */
	return run_query("SELECT DISTINCT Songs.name as name, Songs.ID as ID
													FROM Songs, MusicGenre as g, Songs_MusicGenre as gso
													WHERE g.ID = {$genre} AND
															g.ID = gso.MusicGenre AND
															gso.Song = Songs.ID
															LIMIT 30"
															);	
}

function get_classical_songs(){
/*select songs of classical music genre*/

	return run_query("SELECT Distinct ClassicalMusicComposition.name as name, ClassicalMusicComposition.ID as ID
													FROM ClassicalMusicComposition
													LIMIT 30");	
}

function get_genre_albums($genre){
/*select albums of this genre */

	return run_query("SELECT DISTINCT Album.name as name , Album.ID as ID
														 FROM Album
														 join Album_MusicGenre
														 on Album_MusicGenre.Album=Album.ID
														 join MusicGenre on MusicGenre.ID = Album_MusicGenre.MusicGenre
														 where MusicGenre.ID = {$genre}
														 LIMIT 30");	
}

function get_suggested_genres_by_artists($genre){
/*select 5 genres that have the largest number of common artists with this genre*/

	return run_query("SELECT DISTINCT MusicGenre.name as name, MusicGenre.ID as ID, count(MusicalArtist_MusicGenre.MusicalArtist) AS num
													FROM MusicGenre join MusicalArtist_MusicGenre on MusicGenre.ID = MusicalArtist_MusicGenre.MusicGenre
													WHERE MusicalArtist_MusicGenre.MusicalArtist IN (
																					SELECT MusicalArtist_MusicGenre.MusicalArtist FROM MusicGenre
																					join MusicalArtist_MusicGenre on MusicGenre.ID = MusicalArtist_MusicGenre.MusicGenre
																					WHERE MusicGenre.ID={$genre})  AND MusicGenre.ID <> {$genre}
													GROUP BY MusicGenre.name ORDER BY(num) DESC LIMIT 5; ");	
	
}



function get_suggested_genres_by_songs($genre){
/*select 5 genres that have the largest number of common songs with this genre*/

	return run_query(" SELECT DISTINCT MusicGenre.name as name, MusicGenre.ID as ID, count(Songs_MusicGenre.Song) AS num
															FROM MusicGenre 
															join Songs_MusicGenre on MusicGenre.ID = Songs_MusicGenre.MusicGenre
															WHERE Songs_MusicGenre.Song IN (
															SELECT Songs_MusicGenre.Song FROM MusicGenre
														join Songs_MusicGenre on MusicGenre.ID = Songs_MusicGenre.MusicGenre
														WHERE MusicGenre.id = {$genre}) AND MusicGenre.id <>{$genre}
														GROUP BY MusicGenre.name ORDER BY(num) DESC LIMIT 5; 
												");
}



/**classical music functions**/

function get_classical_name($song){
/*select composition's name*/

	return run_query("SELECT name FROM ClassicalMusicComposition
					WHERE ClassicalMusicComposition.ID ={$song}");	
	

}


function get_classical_info($song){
/*select composition's comment*/

	return run_query("SELECT comment FROM ClassicalMusicComposition
					WHERE ClassicalMusicComposition.ID ={$song}");
}


function get_classical_composer($song){
/*select composition's composer*/

	return run_query("SELECT composer FROM ClassicalMusicComposition
					WHERE ClassicalMusicComposition.ID ={$song}");
}



/**Song functions**/

function get_song_name($song){
/*select song's name*/

	return run_query("SELECT name FROM Songs
					WHERE Songs.ID ={$song}");	
}


function get_song_info($song){
/*select song's comment*/

	return run_query("SELECT comment FROM Songs
					WHERE Songs.ID ={$song}");
}


function get_song_year($song){
/*select song's release year*/

	return run_query("SELECT year FROM Songs
					WHERE Songs.ID ={$song}");
}


function get_song_album($song){	
/*select song's album*/

	return run_query("SELECT Album FROM Songs
					WHERE Songs.ID ={$song}");
}


function get_suggested_songs($song){
/*select 5 songs that have the largest number of common genres with this song*/

	return run_query("SELECT DISTINCT Songs.name as name ,Songs.ID as ID, count(Songs_MusicGenre.MusicGenre) AS num
														FROM Songs
														join Songs_MusicGenre on Songs.ID=Songs_MusicGenre.Song
														WHERE Songs_MusicGenre.MusicGenre IN (
														SELECT Songs_MusicGenre.MusicGenre FROM Songs
														join Songs_MusicGenre on Songs.ID=Songs_MusicGenre.Song
														WHERE Songs.ID={$song}) AND Songs.ID <> {$song}
														GROUP BY Songs.name ORDER BY(num) DESC LIMIT 10; ");
	
}


function get_did_you_know($song){
/*select songs that have the genre of this song and 3 other genres*/

	return run_query("SELECT DISTINCT Songs.ID as ID, Songs.name as name, Songs_MusicGenre.MusicGenre
															FROM Songs JOIN Songs_MusicGenre ON Songs.ID=Songs_MusicGenre.Song 
															JOIN MusicGenre ON MusicGenre.ID=Songs_MusicGenre.MusicGenre
															GROUP BY Songs_MusicGenre.Song
															HAVING Songs_MusicGenre.MusicGenre
															IN
																	(SELECT Songs_MusicGenre.MusicGenre
																	FROM Songs join Songs_MusicGenre on Songs.ID=Songs_MusicGenre.Song
																	WHERE Song={$song}) 
																	
															AND count(Songs_MusicGenre.MusicGenre) > 2
															AND Song <> {$song} LIMIT 10;  ");
}


/**Album functions**/

function get_album_name($album){
/*select name by album id*/

	return run_query("SELECT name FROM Album
				WHERE Album.ID ={$album}");
}


function get_album_info($album){
/*select comment by album id*/

	return run_query("SELECT comment FROM Album
					WHERE Album.ID ={$album}");	
}


function get_album_release_date($album){
/*select release date of an album */

	return run_query("SELECT released FROM Album
				WHERE Album.ID ={$album}");
}

function get_album_type($album){
/*select the type of album */

	return run_query("SELECT  type FROM Album
			WHERE Album.ID ={$album}");
}


/**Artist functions**/

function get_artist_name($term, $str){
/*select artist's name by its id*/

	return run_query("SELECT name FROM {$str}
					WHERE {$str}.ID ={$term}");	
}


function get_artist_info($term, $str){
/*select artist's comment by its id*/

	return run_query("SELECT comment FROM {$str}
					WHERE {$str}.ID ={$term}");		
}


function get_band_members($band){
/*select band members*/

	return run_query("select MusicalArtist.name as name,MusicalArtist.ID as ID
					from Band join Band_MusicalArtist on Band.ID=Band_MusicalArtist.Band join
					MusicalArtist on Band_MusicalArtist.BandMembers=MusicalArtist.ID where Band.ID={$band}
					");		
}


function get_artist_pic($term, $str){
/*select artist's picture path*/

	return run_query("SELECT imageLink FROM {$str}
					WHERE {$str}.ID ={$term}");
}


function get_artist_featured_songs($term, $str1, $str2){
/*select the songs that belong to this artist*/

	return run_query("	
					SELECT DISTINCT Songs.name as name, Songs.ID as ID
					FROM {$str1} 
					join {$str2}
					on {$str1}.ID={$str2}.Artists
					join Songs on Songs.ID = {$str2}.Song
					where {$str1}.ID = {$term}");
}


function get_artist_featured_albums($term, $str1, $str2){
/*select the albums that belong to this artist*/

	return run_query("SELECT DISTINCT Album.name as name, Album.ID as ID
					FROM {$str1} 
					join {$str2} 
					on {$str1}.ID={$str2}.Artists
					join Album on Album.ID = {$str2}.Album
					where {$str1}.ID ={$term}");
}


function get_suggested_artists_from_the_same_term($term, $str1, $str2){
/*if the argument that's in $term is $band: select 5 bands that have the largest number of genres with this band
if the argument that's in $term is $artist: select 5 artists that have the largest number of genres with this artist */

	return run_query("
						SELECT DISTINCT {$str1}.name as name, {$str1}.ID as ID, count({$str2}.MusicGenre) as num
						FROM {$str1}, {$str2}
						WHERE {$str1}.ID <> {$term} AND
						{$str1}.ID = {$str2}.{$str1} AND
						{$str2}.MusicGenre IN (SELECT {$str2}.MusicGenre
													FROM {$str1}, {$str2}
													WHERE {$str1}.ID = {$term} AND
													{$str1}.ID = {$str2}.{$str1}) 
						GROUP BY {$str1}.name
						ORDER BY(num) DESC
						LIMIT 5");

}

function get_suggested_artists_from_different_term($term, $str1, $str2, $str3, $str4){
/*if the argument that's in $term is $band: select 5 artists that have the largest number of genres with this band
if the argument that's in $term is $artist: select 5 bands that have the largest number of genres with this artist  */

	return run_query("	SELECT DISTINCT {$str1}.name as name,{$str1}.ID as ID, count({$str3}.MusicGenre) AS num
						FROM {$str1}
						join {$str3} on {$str1}.ID={$str3}.{$str1}
						WHERE {$str3}.MusicGenre IN (
								SELECT {$str4}.MusicGenre FROM {$str2}
								join {$str4} on {$str2}.ID={$str4}.{$str2}
								WHERE {$str2}.ID={$term}) 
								GROUP BY {$str1}.name ORDER BY(num) DESC LIMIT 5" );
}




function get_suggested_genres_artistpage($term, $str1, $str2){
/*select the genres of this artist*/

	return run_query("SELECT DISTINCT MusicGenre.name as name ,MusicGenre.ID as ID
					FROM {$str1} 
					join {$str2} 
					on {$str1}.ID={$str2}.{$str1}
					join MusicGenre 
					on MusicGenre.ID={$str2}.MusicGenre
					WHERE {$str1}.ID={$term}");

}





/******** insertion and update page functions ***************/

	function get_id_by_name($name,$table_name){
	/*	input - name of table and name to check
		output - the ID associated to the name if exists, otherwise -1 
	*/
		
		$name_param=$name;

		$query = $GLOBALS['mysqli']->prepare("SELECT ID FROM {$table_name} 
							WHERE name = ? 
							LIMIT 1");
		$query->bind_param("s", $name_param);
		$query->execute();
		$query->bind_result($artist_id);
		$query->fetch();

		if ($artist_id == NULL) {
			$query->close();
			return -1;
		} 
		else return $artist_id;

		
	}

	
	function get_artist_information($artist_id, $table_name){
	/* returns db information about the artist/band */
		$query = "SELECT * FROM {$table_name} 
							WHERE ID={$artist_id} 
							LIMIT 1";
		$result = run_query($query);
		$row=$result->fetch_assoc();
		return $row;
	}


	function get_album_information($album_id){
	/* returns db information about the album */
		$query = "SELECT * FROM Album 
							WHERE ID={$album_id} 
							LIMIT 1";
		$result = run_query($query);
		$row=$result->fetch_assoc();
		return $row;
	}


	function get_song_information($song_id,$table_name){
	/* returns db information about the song */
		$query = "SELECT * FROM {$table_name} 
							WHERE ID={$song_id} 
							LIMIT 1";
		$result = run_query($query);
		$row=$result->fetch_assoc();
		return $row;
	}


	
	function insert_artist_band_to_db($table_name, $name, $comment, $start_year, $end_year, $image_link, $genre_id){
	/* inserts a new artist or a new band to the DB, according to the user's selection and parameters
	input: table name, artist name, comment, activity start year, activity end year, image link, genre id
	output: new artist's id if everything is OK, else -1 */
		

		//check if artist/band already exists
		if(get_id_by_name($name,$table_name) != -1){
			echo "<script>alert('Artist or Band already exists! insertion failed :(');</script>";
			return -1;
		}
   
    		$name_param = $name;
		$comment_param = $comment; 

		//check the years
		if($start_year !=NULL && $end_year!=NULL && $end_year< $start_year){
			echo "<script>alert('Uncorrect Active Years, insertion failed :(');</script>";
			return -1;
		}
		else{
			$start_year_param = $start_year; 
			$end_year_param = $end_year;
		}
		
		//check image
	    if($image_link!= NULL){
          if(isImage($image_link)){$image_link_param = $image_link;}
          else {echo "<script>alert('Uncorrect image link, insertion failed :(');</script>"; return -1;}
	    }
	    else {$image_link_param = NULL;}

		//insert the artist/band
		if($table_name == "MusicalArtist"){ 
			$query = $GLOBALS['mysqli']->prepare ("INSERT INTO {$table_name} VALUES(NULL, NULL,NULL, ?, ?, ?, ?, NULL, NULL, ?)");
			$query->bind_param("sssss", $name_param, $comment_param, $start_year_param, $end_year_param, $image_link_param); 
		}
		else {
			$query = $GLOBALS['mysqli']->prepare("INSERT INTO {$table_name} VALUES(NULL, NULL,NULL,?, ?, ?, ?, NULL, ?)");
			$query->bind_param("sssss", $name_param, $comment_param, $start_year_param, $end_year_param, $image_link_param); 
		}
		$query->execute();
		$query->close();

		//connect the artist/band to his musical genre
		$artist_id = get_id_by_name($name_param, $table_name);
		
		$table_name2 = $table_name. "_MusicGenre";
		$query = "INSERT INTO {$table_name2} VALUES({$artist_id},{$genre_id})";
		run_query($query);

		return $artist_id;
		
	}


	function insert_album_to_db($table_name, $artist_name, $album_name, $comment, $type, $release_year, $genre_id){
	/* inserts a new album to the DB, according to the user's selection and parameters
	input: table name, artist name, album name, comment, release year, genre id
	output: new album's id if everything is OK, else -1 */

		//check if album alredy exists
		if(get_id_by_name($album_name, "Album") != -1){
			echo "<script>alert('Album already exists! insertion failed :(');</script>";
			return -1;
		} 

		//check if artist exists, if not create it
		$artist_id = get_id_by_name($artist_name,$table_name);
		if($artist_id == -1){
			$artist_id = insert_artist_band_to_db($table_name,$artist_name,NULL,NULL,NULL,NULL,$genre_id);
		}

		$album_name_param = $album_name;
		$comment_param = $comment;
		$type_param = $type;
		$release_year_param = $release_year;

		//insert the album
		$query = $GLOBALS['mysqli']->prepare("INSERT INTO Album VALUES(NULL, NULL, NULL, ?, ?, ?, ?, NULL, NULL)");
		$query->bind_param("ssss", $album_name_param, $comment_param, $type_param, $release_year_param); 
		$query->execute();
		$query->close();

		$album_id = get_id_by_name($album_name, "Album");


		//connect album to artist/band
		$table_name2 = "Album_". $table_name;
		$query = "INSERT INTO {$table_name2} VALUES({$album_id},{$artist_id})";
		run_query($query);


		//connect album to genre
		$query = "INSERT INTO Album_MusicGenre VALUES({$album_id},{$genre_id})";
		run_query($query);

		return $album_id;

	}



	function insert_song_to_db($table_name, $artist_name, $album_name, $song_name, $comment, $release_year, $genre_id){
  	/* inserts a new song to the DB, according to the user's selection and parameters
	input: table name, artist name, album name, song name, comment, release year, image link, genre id
	output: new songs's id if everything is OK, else -1 */
	
		//check if song alredy exists
	   if($genre_id == 686){  //if it's classical music
	                $id = get_id_by_name($song_name, "ClassicalMusicComposition");
	                if($id != -1){echo "<script>alert('Song already exists! insertion failed :(');</script>";
	                                   return -1;} 
	   } 
	   else{
			$id = get_id_by_name($song_name, "Songs");
			$art = get_id_by_name($artist_name, $table_name);  
			if($id != -1 && $art != -1){       //if song name and artist name exists
				$query = "SELECT Artists FROM Songs_{$table_name} WHERE Song={$id}";  //check if song associated to artist
				$result = run_query($query);
				$row = $result->fetch_assoc();
				if($row["Artists"] == $art){
					echo "<script>alert('Song already exists! insertion failed :(');</script>";
					return -1;
				}
			} 
	   }

		//check if artist exists, if not create him
		$artist_id = get_id_by_name($artist_name,$table_name);
		if($artist_id == -1){
			$artist_id = insert_artist_band_to_db($table_name,$artist_name,NULL,NULL,NULL,NULL,$genre_id);
		}
		
		//check if album exists, if not create it
		if($album_name != NULL){
			$album_id = get_id_by_name($album_name,"Album");
			if($album_id == -1){
				$album_id = insert_album_to_db($table_name, $artist_name, $album_name, NULL, NULL, $genre_id);
			}
		}
		
		$song_name_param = $song_name;
		$comment_param = $comment;
		$release_year_param = $release_year;
		$album_name_param = $album_name;
		$artist_name_param = $artist_name;

		//insert the song
    	if($genre_id == 686){   //in case it's a classical music composition
    		$query = $GLOBALS['mysqli']->prepare("INSERT INTO ClassicalMusicComposition VALUES(NULL, NULL,NULL, ?, ?, ?)");
			$query->bind_param("sss", $comment_param, $song_name_param, $artist_name_param);
    	}
    	else{
			$query = $GLOBALS['mysqli']->prepare("INSERT INTO Songs VALUES(NULL, NULL,NULL, ?, ?, ?, ?, NULL, NULL, NULL)");
			$query->bind_param("ssss", $song_name_param, $comment_param, $release_year_param, $album_name_param); 
		}
		$query->execute();
		$query->close();

		if($genre_id == 686){ $song_id = get_id_by_name($song_name, "ClassicalMusicComposition");}
		else{$song_id = get_id_by_name($song_name, "Songs");}


		if($genre_id != 686){
			//connect song to artist/band
			$table_name2 = "Songs_". $table_name;
			$query = "INSERT INTO {$table_name2} VALUES({$song_id},{$artist_id})";
			run_query($query);


			//connect song to genre
			$query = "INSERT INTO Songs_MusicGenre VALUES({$song_id},{$genre_id})";
			run_query($query);
		}

		return $song_id;

	
	}


	function update_artist_or_band_db($table_name, $artist_id, $comment, $start_year, $end_year, $image_link){
	/* sql function that updates the db with the new information about an artist or band */

		$comment_param = $comment; 

		//check the years
		if($start_year !=NULL && $end_year!=NULL && $end_year< $start_year){
			echo "<script>alert('Uncorrect Active Years, update failed :(');</script>";
			return -1;
		}
		else{
			$start_year_param = $start_year; 
			$end_year_param = $end_year;
		}


	    if($image_link != NULL){
          if(isImage($image_link)){$image_link_param = $image_link;}
          else {echo "<script>alert('Uncorrect image link');</script>"; $image_link_param = NULL;}
	    }
	    else {$image_link_param = NULL;}


	    $query = $GLOBALS['mysqli']->prepare(" UPDATE {$table_name} 
	    									SET comment = ?, activeYearsStartYear=?, activeYearsEndYear= ?, imageLink= ?
	    									WHERE ID= {$artist_id}");
	    $query->bind_param("ssss", $comment_param, $start_year_param, $end_year_param, $image_link_param);
	    $query->execute();
		$query->close();

	}


	function update_album_db($album_id, $comment, $type, $release_year){
	/* sql function that updates the db with the new information about an album */
		$comment_param = $comment; 
		$type_param = $type;
		$year_param = $release_year;
		$query = $GLOBALS['mysqli']->prepare(" UPDATE Album 
	    						SET comment = ?, type=?, released=?
	    						WHERE ID= {$album_id}");
	    	$query->bind_param("sss", $comment_param, $type_param, $year_param);
	   	 $query->execute();
		$query->close();
	
	}


	function update_song_db($song_id, $comment, $release_year){
	/* sql function that updates the db with the new information about a song */
		$comment_param = $comment; 
		$year_param = $release_year;
		
		$query = $GLOBALS['mysqli']->prepare(" UPDATE Songs 
	    						SET comment = ?, year=? 
	    						WHERE ID= {$song_id}");
	    	$query->bind_param("ss", $comment_param, $year_param);
	    	$query->execute();
		$query->close();

	}



?>