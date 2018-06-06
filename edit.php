<?php

include_once("./inc/config.php");

$film = new films($_REQUEST['id']);
$title = $film->getTitle();

include_once("./inc/header.php"); 

if(isset($_REQUEST['created']) && $_REQUEST['created'] == 'yes') { ?><div class="callout success"><p>CREADA NUEVA PELíCULA</p></div><?php }

if(isset($_REQUEST['savefilm']) && $_REQUEST['savefilm'] != '') { 

	//print_pre ($_FILES);
	if(isset($_FILES['img']) && $_FILES['img']['error'] == 0) {
		//echo "Borramos ".__DIR__."/imgs/portraits/".$film->getImg();
		unlink (__DIR__."/imgs/portraits/".$film->getImg());
		//echo "Subimos ".__DIR__."/imgs/portraits/".$_FILES['img']['name'];
		move_uploaded_file($_FILES['img']['tmp_name'], __DIR__."/imgs/portraits/".$_FILES['img']['name']);
		$film->setImg($_FILES['img']['name']);
	}

	$film->setTitle($_REQUEST['title']);
	$film->setTitleOriginal($_REQUEST['title_original']);
	$film->setDuration($_REQUEST['duration']);
	//$film->setFormat($_REQUEST['format']);
	$film->setResolution($_REQUEST['resolution']);
	$film->setLanguage($_REQUEST['language']);
	$film->setSound($_REQUEST['sound']);
	$film->setChannel($_REQUEST['channel']);
	$film->setStatus($_REQUEST['status']);
	$film->setIMDB($_REQUEST['imdb']);
	$film->setNotes($_REQUEST['notes']);
	$film->setTag('format', $_REQUEST['format']);
	$film->setTag('year', $_REQUEST['year']);
	$film->setTag('author', $_REQUEST['author']);
	$film->setTag('genre', $_REQUEST['genre']);
	$film->setTag('saga', $_REQUEST['saga']);
	?><div class="callout success"><p>GUARDADO</p></div><?php 
} ?>
<form method="post" action="/films/edit.php?id=<?php echo $film->getId(); ?>" enctype="multipart/form-data">
	<div class="grid-x grid-padding-x">
		<div class="minifilm large-3 medium-4 cell">
			<img src="<?php echo $film->getImgURl(); ?>" />
			
		</div>
		<div class="minifilm large-9 medium-8 cell">
			<div class="box">
				<p><input type="text" name="title" value="<?php echo $film->getTitle(); ?>" placeholder="Título" /></p>
				<p><input type="text" name="title_original" value="<?php echo $film->getTitleOriginal(); ?>" placeholder="Título orden" /></p>
				<p><input type="text" name="duration" value="<?php echo $film->getDuration(); ?>" placeholder="Duración" /></p>
				<p><input type="text" name="year" value="<?php echo $film->getTag('year'); ?>" placeholder="Año" /></p>
				<p><input type="text" id="authorinput" name="author" value="<?php echo $film->getTag('author'); ?>" placeholder="Autor" /></p>
				<p><input type="text" id="genreinput" name="genre" value="<?php echo $film->getTag('genre'); ?>" placeholder="Género" /></p>
				<p><input type="text" id="sagainput" name="saga" value="<?php echo $film->getTag('saga'); ?>" placeholder="Saga" /></p>

				<select name="format">
					<option value="">--</option>
					<?php foreach ($formattext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getTag('format')) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="resolution">
					<option value="">--</option>
					<?php foreach ($resolutiontext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getResolution()) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="language">
					<option value="">--</option>
					<?php foreach ($languagetext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getLanguage()) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="sound">
					<option value="">--</option>
					<?php foreach ($soundtext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getSound()) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="channel">
					<option value="">--</option>
					<?php foreach ($channeltext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getChannel()) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="status">
					<option value="">--</option>
					<?php foreach ($statustext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"<?php if($label == $film->getStatus()) echo "selected='selected'"; ?>><?php echo $item; ?></option>
					<?php } ?> 
				<select>
				<p><input type="text" id="imdbinput" name="imdb" value="<?php echo $film->getIMDB(); ?>" placeholder="IMDB" /></p>
				<p><textarea name="notes" rows="4"><?php echo $film->getNotes(); ?></textarea></p>

				<input type="file" name="img" />
				<input type="submit" class="button" name="savefilm" value="Guardar" />
			</div>
			
		</div>
	</div>
</form>
<a class="back" href="/films/film.php?id=<?php echo $film->getId(); ?>">Volver</a>
<a class="edit" href="/films/delete.php?id=<?php echo $film->getId(); ?>">Borrar</a>
<?php include_once("./inc/footer.php"); ?>
