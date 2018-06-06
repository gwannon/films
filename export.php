<?php

include_once("./inc/config.php");
$csv = "";
$films = getFilms(0, 0, 'id', 'ASC'); 
foreach ($films as $id) {
	$film = new films($id);
	$csv .= "\"".$film->getId()."\",\"".$film->getTitle()."\",\"".$film->getTitleOriginal()."\",\"".$film->getTag('year')."\",\"".$film->getDuration()."\",\"".$film->getTag('author')."\",\"".$film->getTag('genre')."\",\"".$film->getTag('saga')."\",\"".$film->getTag('format')."\",\"".$film->getImg()."\",\"".$film->getResolution()."\",\"".$film->getSound()."\",\"".$film->getLanguage()."\",\"".$film->getImg()."\",\"".$film->getStatus()."\",\"".$film->getNotes()."\",\"".$film->getStatus()."\",\"".$film->getIMDB()."\"";
	$views = $film->getViews();
	if(count($views) > 0) { 
		foreach ($views as $date) { 
			$csv .= ",\"".date("d-m-Y", strtotime($date))."\""; 
		}
	} 
	$csv .= "\n";
}

header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"peliculas.csv\""); 
echo $csv;


?>
