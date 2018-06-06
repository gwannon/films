<?php

include_once("./inc/config.php");

$title = "Nueva película";

if(isset($_REQUEST['newfilm']) && $_REQUEST['newfilm'] != '') { 
	$id = createFilm($_REQUEST['title'], $_REQUEST['title_original']);
	$film = new films($id);
	if(isset($_FILES['img']) && $_FILES['img']['error'] != 1) {
		move_uploaded_file($_FILES['img']['tmp_name'], __DIR__."/imgs/portraits/".$_FILES['img']['name']);
		$film->setImg($_FILES['img']['name']);
	}
	$film->setDuration($_REQUEST['duration']);
	//$film->setFormat($_REQUEST['format']);
	$film->setResolution($_REQUEST['resolution']);
	$film->setLanguage($_REQUEST['language']);
	$film->setSound($_REQUEST['sound']);
	$film->setChannel($_REQUEST['channel']);
	$film->setTag('format', $_REQUEST['format']);
	$film->setTag('year', $_REQUEST['year']);
	$film->setTag('author', $_REQUEST['author']);
	$film->setTag('genre', $_REQUEST['genre']);
	$film->setTag('saga', $_REQUEST['saga']);
	
	header('Location: /films/edit.php?created=yes&id='.$film->getId());
	exit;	
}

include_once("./inc/header.php"); ?>
<form method="post" action="/films/new.php" enctype="multipart/form-data">
	<div class="grid-x grid-padding-x">
		<div class="minifilm large-12 cell">
			<div class="box">
				<p><input type="text" name="title" placeholder="Título" /></p>
				<p><input type="text" name="title_original" placeholder="Título original" /></p>
				<p><input type="text" name="duration" placeholder="Duración" /></p>
				<p><input type="text" name="year" placeholder="Año" /></p>
				<p><input type="text" id="authorinput" name="author" placeholder="Autor" /></p>
				<p><input type="text" id="genreinput" name="genre" placeholder="Género" /></p>
				<p><input type="text" id="sagainput" name="saga" placeholder="Saga" /></p>

				<select name="format">
					<option value="">--</option>
					<?php foreach ($formattext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="resolution">
					<option value="">--</option>
					<?php foreach ($resolutiontext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="language">
					<option value="">--</option>
					<?php foreach ($languagetext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"><?php echo $item; ?></option>
					<?php } ?> 
				<select>

				<select name="sound">
					<option value="">--</option>
					<?php foreach ($soundtext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"><?php echo $item; ?></option>
					<?php } ?> 
				<select>
				<select name="channel">
					<option value="">--</option>
					<?php foreach ($channeltext as $label => $item) { ?>
					<option value="<?php echo $label; ?>"><?php echo $item; ?></option>
					<?php } ?> 
				<select>


				<input type="file" name="img" />
				<input type="submit" class="button" name="newfilm" value="Crear" />
			</div>
			
		</div>
	</div>
</form>
<br/><br/>
<a class="back" href="/films/">Volver</a>
<?php include_once("./inc/footer.php"); ?>
