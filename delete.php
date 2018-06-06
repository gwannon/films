<?php

include_once("./inc/config.php");

if(isset($_REQUEST['id']) && $_REQUEST['id'] != '') { 
	deleteFilm($_REQUEST['id']);
	header('Location: /films/?deleted=yes');
	exit;	
} ?>
