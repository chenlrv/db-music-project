<script language="javascript"> 

	function Validate(){
	/*if the user chose a genre and subgenre, transfer him to the genre's page
	  otherwise stay on the same page */ 

		if(document.getElementById('parent_cat').value == ''){   
			alert('Please select a music genre!');
			document.location = 'MainPage.php';																
		}else{
			document.location = 'OptionsPage.php';
		}													
	}   


	function DoArtist(){
	/*go to the artist's page by its id */

		var art= document.getElementById("herfArtist").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "ArtistPage.php?artist="+art, true);
		xhttp.send();	
	}
	
	function DoBand(){
	/*go to the band's page by its id */

		var art= document.getElementById("herfBand").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "ArtistPage.php?band="+art, true);
		xhttp.send();	
	}	
  
	function DoSong(){
	/*go to the song's page by its id */

		var art= document.getElementById("herfSong").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "Song.php?song="+art, true);
		xhttp.send();	
	}
	
	
	function DoAlbum(){
	/*go to the album's page by its id */

		var art= document.getElementById("herfAlbum").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "Album.php?album="+art, true);
		xhttp.send();	
	}
	
	
	function DoSelectedGenre(){
	/*go to the genre's page by its id */

		var art= document.getElementById("relatedGenre").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "OptionsPage.php?genre="+art, true);
		xhttp.send();	
	}


	function DoSongUpdate(){
	/*go to the update song's page by its id */

		var art= document.getElementById("updatesong").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "update_song.php?song="+art, true);
		xhttp.send();			
	}
	
	
	function DoAlbumUpdate(){
	/*go to the update album's page by its id */

		var art= document.getElementById("updatealbum").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "update_album.php?song="+art, true);
		xhttp.send();	
		
		
	}

	function DoBandUpdate(){
	/*go to the update band's page by its id */

		var art= document.getElementById("updateband").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "update_artist_band.php?song="+art, true);
		xhttp.send();	
		
	}

	function DoArtistpdate(){
	/*go to the update artist's page by its id */
		var art= document.getElementById("updateartist").value;
		xhttp = new XMLHttpRequest();
		xhttp.open("get", "update_artist_band.php?song="+art, true);
		xhttp.send();	
		
	}	

</script>