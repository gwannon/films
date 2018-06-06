<?php

/*

CREATE TABLE `films` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `title_original` text NOT NULL,
  `img` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('year,author,genre,saga') NOT NULL,
  `value` text NOT NULL,
  `film_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

*/

class films {
	private $id;
	private $title;
	private $title_original;
	private $duration;
	//private $format;
	private $resolution;
	private $language;
	private $sound;
	private $channel;
	private $img;
	private $tags;
	private $views;
	private $notes;
	private $status;
	private $imdb;

	function __construct ($id) {
		global $db;
		$res = $db->query("SELECT * FROM `films` WHERE `id` = '{$id}';");
		$data = $res->fetch_assoc();
		$this->id = $data['id'];
		$this->title = $data['title'];
		$this->title_original = $data['title_original'];
		$this->duration = $data['duration'];
		//$this->format = $data['format'];
		$this->resolution = $data['resolution'];
		$this->language = $data['language'];
		$this->sound = $data['sound'];
		$this->channel = $data['channel'];
		$this->img = $data['img'];
		$this->notes = $data['notes'];
		$this->status = $data['status'];
		$this->imdb = $data['imdb'];
		$res = $db->query("SELECT type, value FROM `tags` WHERE `film_id` = '{$id}';");
		$tags = array();
		while($data = $res->fetch_assoc()) {
			$label = $data['type'];
			$tags[$label] = $data['value'];
		}
		$this->tags = $tags;
		$res = $db->query("SELECT id, date, mode FROM `views` WHERE `film_id` = '{$id}' ORDER BY date DESC;");
		$views = array();
		while($data = $res->fetch_assoc()) {
			$label = $data['id'];
			$views[$label] = array("date" => $data['date'], "mode" => $data['mode']);
		}
		$this->views = $views;	
	
		return;
	}

	// GETs -------------------------------
	function getId() { return $this->id; }
	function getTitle() { return $this->title; }
	function getTitleOriginal() { return $this->title_original; }
	function getDuration() { return $this->duration; }
	//function getFormat() { return $this->format; }
	function getResolution() { return $this->resolution; }
	function getLanguage() { return $this->language; }
	function getSound() { return $this->sound; }
	function getChannel() { return $this->channel; }
	function getImg() { return $this->img; }
	function getNotes() { return $this->notes; }
	function getStatus() { return $this->status; }
	function getIMDB() { return $this->imdb; }
	function getImgURl() { return "/films/imgs/portraits/".$this->img; }
	function getTag($label) { $temp = $this->tags; return $temp[$label]; }	
	function getViews() { return $this->views; }	

	// SETs -------------------------------
	function setTitle($value) { 
		 global $db;
		$this->title = $value; 
		$db->query("UPDATE `films` SET title = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setTitleOriginal($value) { 
		global $db;
		$this->title_original = $value; 
		$db->query("UPDATE `films` SET title_original = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setDuration($value) { 
		global $db;
		$this->duration = $value; 
		$db->query("UPDATE `films` SET duration = '{$value}' WHERE id = '".$this->id."';"); 
	}
	/*function setFormat($value) { 
		global $db;
		$this->format = $value; 
		$db->query("UPDATE `films` SET format = '{$value}' WHERE id = '".$this->id."';"); 
	}*/
	function setResolution($value) { 
		global $db;
		$this->resolution = $value; 
		$db->query("UPDATE `films` SET resolution = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setLanguage($value) { 
		global $db;
		$this->language = $value; 
		$db->query("UPDATE `films` SET language = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setSound($value) { 
		global $db;
		$this->sound = $value; 
		$db->query("UPDATE `films` SET sound= '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setChannel($value) { 
		global $db;
		$this->channel = $value; 
		//echo "UPDATE `films` SET channel= '{$value}' WHERE id = '".$this->id."';";
		$db->query("UPDATE `films` SET channel= '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setImg($value) { 
		global $db;
		$this->img = $value; 
		$db->query("UPDATE `films` SET img = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setNotes($value) { 
		global $db;
		$this->notes = $value; 
		$db->query("UPDATE `films` SET notes = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setStatus($value) { 
		global $db;
		$this->status = $value;
		$db->query("UPDATE `films` SET status = '{$value}' WHERE id = '".$this->id."';"); 
	}
	function setIMDB($value) { 
		global $db;
		$this->imdb = $value;
		$db->query("UPDATE `films` SET imdb = '{$value}' WHERE id = '".$this->id."';"); 
	}

	function setTag($label, $value) {
		global $db;
		$temp = $this->tags; 
		$temp[$label] = $value; 
		$this->tags = $temp;
		/*if ($value == '') {
			//echo "DELETE FROM `tags` WHERE `film_id` = '".$this->id."' AND `type` = '".$label."';";
			$res = $db->query("DELETE FROM `tags` WHERE `film_id` = '".$this->id."' AND `type` = '".$label."';");
		} else {*/
			$res = $db->query("SELECT id FROM `tags` WHERE `film_id` = '".$this->id."' AND `type` = '".$label."';");
			if($res->num_rows > 0) {
				$db->query("UPDATE `tags` SET value = '{$value}' WHERE `film_id` = '".$this->id."' AND `type` = '".$label."';"); 
			} else {
				$db->query("INSERT INTO `tags` (`type`, `value`, `film_id`) VALUES ('{$label}', '{$value}', ".$this->id.");");  
			}
		/*}*/
	}

	//Views
	function insertView ($date, $mode) {
		global $db;
		//echo "INSERT INTO `views` (`date`, `mode`, `film_id`) VALUES ('{$date}', '{$mode}', ".$this->id.");";
		$db->query("INSERT INTO `views` (`date`, `mode`, `film_id`) VALUES ('{$date}', '{$mode}', ".$this->id.");");
		$res = $db->query("SELECT id, date, mode FROM `views` WHERE `film_id` = '".$this->id."' ORDER BY date DESC;");
		$views = array();
		while($data = $res->fetch_assoc()) {
			$label = $data['id'];
			$views[$label] = array("date" => $data['date'], "mode" => $data['mode']);
		}
		$this->views = $views;
		return;
	}

	function deleteView ($id) {
		global $db;
		$res = $db->query("DELETE FROM `views` WHERE `id` = '".$id."'");
		$res = $db->query("SELECT id, date, mode FROM `views` WHERE `film_id` = '".$this->id."' ORDER BY date DESC;");
		$views = array();
		while($data = $res->fetch_assoc()) {
			$label = $data['id'];
			$views[$label] = array("date" => $data['date'], "mode" => $data['mode']);
		}
		$this->views = $views;
		return;
	}
	
}

function getFilms($offset = 0, $maxitems = 0, $orderby = 'title', $order = 'ASC') {
	global $db;
	if($maxitems > 0) $limit = " LIMIT {$offset}, {$maxitems}";
	else $limit = "";
	$sql = "SELECT id FROM `films` ORDER BY `{$orderby}` {$order}".$limit.";";
	$res = $db->query($sql);
	$ids = array();
	while($data = $res->fetch_assoc()) {
		$ids[] = $data['id'];
	}
	return $ids;
}

function getFilmsFiltered($filter, $orderby, $order = 'ASC', $search = '', $offset = 0, $maxitems = 0) {
	global $db;
	if($maxitems > 0) $limit = " LIMIT {$offset}, {$maxitems}";
	else $limit = "";
	if($orderby == "duration") $orderbysql = " ORDER BY f.".$orderby." {$order}, f.title ASC";
	else if($orderby != "") $orderbysql = " ORDER BY t".$orderby.".value {$order}, f.title ASC";
	else $orderbysql = " ORDER BY f.title {$order}";

	if($search != "") $where = " WHERE f.title LIKE '%".$search."%' OR  f.title_original LIKE '%".$search."%'";
	else $where = "";


	$filters = "";
	foreach ($filter as $key => $value) {
		if ($value != '') $filters .= " INNER JOIN tags t".$key." ON t".$key.".film_id = f.id AND t".$key.".type = '".$key."' AND t".$key.".value = '".$value."'"; 
		else if ($key == $orderby) $filters .= " INNER JOIN tags t".$key." ON t".$key.".film_id = f.id AND t".$key.".type = '".$key."'";  
	} 
	$sql = "SELECT DISTINCT f.id FROM films f".$filters." ".$where." ".$orderbysql." ".$limit.";";
	//echo "<p style='color: #ffffff;'>".$sql."</p>";
	$res = $db->query($sql);
	$ids = array();
	while($data = $res->fetch_assoc()) {
		$ids[] = $data['id'];
	}
	return $ids;
}

function getFilter($type) {
	global $db;
	$res = $db->query("SELECT DISTINCT value, COUNT(id) AS total FROM `tags` WHERE `type` = '{$type}' AND `value` != '' GROUP BY value ORDER BY `value` ASC;");
	$values = array();
	while($data = $res->fetch_assoc()) {
		$values[] = array("value" => $data['value'], "total" => $data['total']);
	}
	return $values;
}

function print_pre($data) {
	echo "<pre>";
	print_r ($data);
	echo "</pre>";	
}

function createFilm ($title, $title_original) {
	global $db;
	$res = $db->query("INSERT INTO `films` (`title`, `title_original`) VALUES ('{$title}', '{$title_original}');");
	return $db->insert_id;
}

function deleteFilm ($id) {
	global $db;
	$film = new films($id);
	unlink (__DIR__."/imgs/portraits/".$film->getImg());
	$res = $db->query("DELETE FROM `films` WHERE `id` = '{$id}'");
	$res = $db->query("DELETE FROM `tags` WHERE `film_id` = '{$id}'");
	$res = $db->query("DELETE FROM `views` WHERE `film_id` = '{$id}'");
	return true;
}

$modetext = array('tv' => "TV", 'mobile' => "Disp. Móvil", 'cinema' => "Cine", 'room' => "Sala de Cine");
function getModeText($label) {
	global $modetext;
	return $modetext[$label];
}

$formattext = array('archivo-digital' => "Archivo Digital", 'blu-ray' => "Blu-Ray", 'dvd' => "DVD", 'blu-ray-3d' => "Blu-Ray 3D");
function getFormatText($label) {
	global $formattext;
	return $formattext[$label];
}

$resolutiontext = array('sd' => "SD", '720' => "720", '1080' => "1080");
function getResolutionText($label) {
	global $resolutiontext;
	return $resolutiontext[$label];
}

$languagetext = array('muda' => "Muda", 'doblada' => "Doblada", 'dual' => "Dual", 'vose' => "VOSE", 'v-original' => "V. Original");
function getLanguageText($label) {
	global $languagetext;
	return $languagetext[$label];
}

$soundtext = array('dolby-digital' => "Dolby Digital", 'dts' => "DTS", 'flac' => "FLAC", 'dolby-digital-ex' => "Dolby Digital EX", 'dolby-true-hd' => "Dolby True HD", 'dts-hd' => "DTS-HD", 'pcm' => "PCM", 'mp3' => "MP3", 'acc' => "ACC");
function getSoundText($label) {
	global $soundtext;
	return $soundtext[$label];
}

$channeltext = array('1-0' => "1.0",'2-0' => "2.0",'5-1' => "5.1", '7-1' => "7.1");
function getChannelText($label) {
	global $channeltext;
	return $channeltext[$label];
}

$statustext = array('seleccionada' => "Seleccionada",'para-reordenar' => "Para Reordenar",'para-borrar' => "Para Borrar",'para-reemplazar' => "Para Reemplazar");
function getStatusText($label) {
	global $statustext;
	return $statustext[$label];
}






?>
