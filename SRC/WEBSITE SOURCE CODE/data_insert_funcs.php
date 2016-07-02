<?php 
	include ("sql_funcs.php");
	
	function insert_artist_or_band($artist_id, $is_edit){
	/* inserts a new artist or a new band to the DB, according to the user's selection and parameters
		in case $is_edit isn't 0, then it updates the relevant artist */

		$is_artist = $_POST["is_artist1"];
		$name = $_POST["name"];

		if($is_artist == "artist"){ $table_name = "MusicalArtist";}
		else {$table_name = "Band";}

		if(!is_edit){
		$comment =  (isset($_POST["description"]) && $_POST["description"]!="")? htmlspecialchars($_POST["description"]):NULL;
		$start_year = (isset($_POST["start_year"]) && !empty($_POST["start_year"]))? $_POST["start_year"]:NULL;
		$end_year = (isset($_POST["end_year"]) && !empty($_POST["end_year"]))? $_POST["end_year"]:NULL;
    		$image_link = (isset($_POST["img_link1"]) && !empty($_POST["img_link1"]))? $_POST["img_link1"]:NULL; }
		else{
		$row = get_artist_information($artist_id,$table_name);
		$comment =  (isset($_POST["description"]) && $_POST["description"]!="")? htmlspecialchars($_POST["description"]):$row["comment"];
		$start_year = (isset($_POST["start_year"]) && !empty($_POST["start_year"]))? $_POST["start_year"]:$row["activeYearsStartYear"];
		$end_year = (isset($_POST["end_year"]) && !empty($_POST["end_year"]))? $_POST["end_year"]:$row["activeYearsEndYear"];
    		$image_link = (isset($_POST["img_link1"]) && !empty($_POST["img_link1"]))? $_POST["img_link1"]:$row["imageLink"]; 
		}
		
		if(!$is_edit){ $genre_id = $_POST["sub_cat1"]; }
		else {$genre_id = NULL;}

		if($is_edit){ update_artist_or_band_db($table_name, $artist_id, $comment, $start_year, $end_year, $image_link); }
		else { insert_artist_band_to_db($table_name, $name, $comment, $start_year, $end_year, $image_link, $genre_id); }

		unset_artist();
				
	}


	function insert_album($album_id, $is_edit){
	/* inserts a new album to the DB, according to the user's selection and parameters
		in case $is_edit isn't 0, then it updates the relevant album */
		if(!$is_edit){
		$is_artist = $_POST["is_artist2"];
		$artist_name = $_POST["art_name"];
		$album_name = $_POST["alb_name"];
		}else{$is_artist=NULL; $artist_name=NULL; $album_name=NULL;}
		if($is_artist == "artist"){$table_name = "MusicalArtist";} else{ $table_name = "Band";}

		if(!$is_edit){
			$comment =  (isset($_POST["alb_description"]) && $_POST["alb_description"]!="")? htmlspecialchars($_POST["alb_description"]): NULL;
			$release_year = (isset($_POST["rel_year"]) && !empty($_POST["rel_year"]))? $_POST["rel_year"]:NULL;
			$type = (isset($_POST["alb_type"]) && !empty($_POST["alb_type"]))? $_POST["alb_type"]:NULL;
		}
		else{
			$row = get_album_information($album_id);
			$comment =  (isset($_POST["alb_description"]) && $_POST["alb_description"]!="")? htmlspecialchars($_POST["alb_description"]): $row["comment"];
			$release_year = (isset($_POST["rel_year"]) && !empty($_POST["rel_year"]))? $_POST["rel_year"]:$row["released"];
			$type = (isset($_POST["alb_type"]) && !empty($_POST["alb_type"]))? $_POST["alb_type"]:$row["type"];
		}
		
		if(!$is_edit){$genre_id = $_POST["sub_cat2"];}
		else {$genre_id = NULL;}

		if($is_edit){update_album_db($album_id, $comment, $type, $release_year);}
		else{insert_album_to_db($table_name, $artist_name, $album_name, $comment, $type, $release_year, $genre_id);}

		unset_album();

	}


	function insert_song($song_id, $is_edit){
	/* inserts a new song to the DB, according to the user's selection and parameters
		in case $is_edit isn't 0, then it updates the relevant song */
		
		if(!$is_edit){
			$is_artist = $_POST["is_artist3"];
			$artist_name = $_POST["art_name2"];
			$album_name = (isset($_POST["alb_name2"]) && !empty($_POST["alb_name2"]))? $_POST["alb_name2"]:NULL;

		}
		else{$is_artist=NULL; $artist_name=NULL; $album_name=NULL;}
		
		$song_name = $_POST["song_name"];
		if(!$is_edit){
			$comment =  (isset($_POST["song_description"]) && $_POST["song_description"]!="")? htmlspecialchars($_POST["song_description"]):NULL;
			$release_year = (isset($_POST["rel_year2"]) && !empty($_POST["rel_year2"]))? $_POST["rel_year2"]:NULL;
		}
		else{
			$row = get_song_information($song_id, "Songs");
			$comment =  (isset($_POST["song_description"]) && $_POST["song_description"]!="")? htmlspecialchars($_POST["song_description"]):$row["comment"];
			$release_year = (isset($_POST["rel_year2"]) && !empty($_POST["rel_year2"]))? $_POST["rel_year2"]:$row["year"];
		}

		if(!$is_edit){$genre_id = $_POST["sub_cat3"];}
		else {$genre_id = NULL;}

		if($is_artist == "artist"){$table_name = "MusicalArtist";} else{ $table_name = "Band";}

		if($is_edit){update_song_db($song_id, $comment, $release_year);}
		else{insert_song_to_db($table_name, $artist_name, $album_name, $song_name, $comment, $release_year, $genre_id);}
		
		unset_song();
	}


	function unset_artist(){
	/* unsets the user selection in the artist/band insert/update form */	
		unset($_POST["is_artist1"]);
		unset($_POST["name"]);
		unset($_POST["description"]);
		unset($_POST["start_year"]);	
		unset($_POST["end_year"]);
		unset($_POST["img_link1"]);
		unset($_POST["sub_cat1"]);
	}

	
	function unset_album(){
	/* unsets the user selection in the album insert/update form */
		unset($_POST["is_artist2"]);
		unset($_POST["art_name"]);
		unset($_POST["alb_name"]);
		unset($_POST["alb_description"]);
		unset($_POST["rel_year"]);
		unset($_POST["alb_type"]);
		unset($_POST["sub_cat2"]);
	}

	
	function unset_song(){
	/* unsets the user selection in the song insert/update form */
		unset($_POST["is_artist3"]);
		unset($_POST["art_name2"]);
		unset($_POST["alb_name2"]);
		unset($_POST["song_name"]);	
		unset($_POST["song_description"]);
		unset($_POST["rel_year2"]);
		unset($_POST["sub_cat3"]);
	}



	function isImage($url)
	/* checks if a given link is an image or not */
	{
		 $params = array('http' => array(
		              'method' => 'HEAD'
		           ));
		 $ctx = stream_context_create($params);
		 $fp = @fopen($url, 'rb', false, $ctx);
		 if (!$fp) 
		    return false;  // Problem with url

		$meta = stream_get_meta_data($fp);
		if ($meta === false)
		{
		    fclose($fp);
		    return false;  // Problem reading data from url
		}

		$wrapper_data = $meta["wrapper_data"];
		if(is_array($wrapper_data)){
		  foreach(array_keys($wrapper_data) as $hh){
		      if (substr($wrapper_data[$hh], 0, 19) == "Content-Type: image") // strlen("Content-Type: image") == 19 
		      {
		        fclose($fp);
		        return true;
		      }
		  }
		}

		fclose($fp);
		return false;
	}

	


	


?>
