<html>
<head></head>

<div id="ytplayer"></div>

<?php

function getIdFromName($name,$song_band_artist){
/* this function returns ID of a youtube video by the arguments that we pass to it - band/artist name and song name */

    try {
        $name = str_replace(" ", "+", $name);
		$song_band_artist = str_replace(" ", "+", $song_band_artist);
        $url = "https://www.youtube.com/results?search_query=" . $name."+".$song_band_artist;
        $sFile = file_get_contents($url);
        if (strpos($sFile, 'div class="yt-lockup-content"') !== false) {
            $myArray = explode('div class="yt-lockup-content"', $sFile, 2);
            $sFile = $myArray[1];
            $myArray = explode('watch?v=', $sFile, 2);
            $sFile = $myArray[1];
            $myArray = explode('"', $sFile, 2);
            $sFile = $myArray[0];
            return ($sFile);
        } else {
            return ('null');
        }
    }
    catch (exception $e){
        return ('null');
    }
}


?>


</html>


