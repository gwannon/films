<?php

include_once("./inc/config.php");

$title = "Películas";

include_once("./inc/header.php"); 

if(isset($_REQUEST['deleted']) && $_REQUEST['deleted'] == 'yes') { ?><div class="callout success"><p>PELíCULA BORRADA</p></div><?php }

if(isset($_REQUEST['filter']) && $_REQUEST['filter'] != '') {
	if($_REQUEST['orderby'] == "yeardesc") $films = getFilmsFiltered($_REQUEST['filter'], 'year', 'DESC', $_REQUEST['search']); 
	else if($_REQUEST['orderby'] == "durationdesc") $films = getFilmsFiltered($_REQUEST['filter'], 'duration', 'DESC', $_REQUEST['search']);
	else $films = getFilmsFiltered($_REQUEST['filter'], $_REQUEST['orderby'], "ASC", $_REQUEST['search']);

} else $films = getFilms(0, 0, 'id', 'DESC'); ?>
<form method="post" id="filters">
	<div class="grid-x grid-padding-x">
		<div class="filter large-2 medium-2 small-2 cell">
			<select name="filter[year]">
				<option value="">Año</option>
				<?php foreach(getFilter("year") as $value) { ?>
				<option value="<?php echo $value['value']; ?>"<?php if($value['value'] == $_REQUEST['filter']['year']) echo " selected='selected'"; ?>><?php echo $value['value']; ?> (<?php echo $value['total']; ?>)</option>
				<?php } ?>
			</select>
		</div>
		<div class="filter large-2 medium-2 small-2 cell">
			<select name="filter[genre]">
				<option value="">Género</option>
				<?php foreach(getFilter("genre") as $value) { ?>
				<option value="<?php echo $value['value']; ?>"<?php if($value['value'] == $_REQUEST['filter']['genre']) echo " selected='selected'"; ?>><?php echo $value['value']; ?> (<?php echo $value['total']; ?>)</option>
				<?php } ?>
			</select>
		</div>
		<div class="filter large-2 medium-2 small-2 cell">
			<select name="filter[author]">
				<option value="">Autor</option>
				<?php foreach(getFilter("author") as $value) { ?>
				<option value="<?php echo $value['value']; ?>"<?php if($value['value'] == $_REQUEST['filter']['author']) echo " selected='selected'"; ?>><?php echo $value['value']; ?> (<?php echo $value['total']; ?>)</option>
				<?php } ?>
			</select>
		</div>
		<div class="filter large-2 medium-2 small-2 cell">
			<select name="filter[saga]">
				<option value="">Saga</option>
				<?php foreach(getFilter("saga") as $value) { ?>
				<option value="<?php echo $value['value']; ?>"<?php if($value['value'] == $_REQUEST['filter']['saga']) echo " selected='selected'"; ?>><?php echo $value['value']; ?> (<?php echo $value['total']; ?>)</option>
				<?php } ?>
			</select>
		</div>
		<div class="filter large-2 medium-2 small-2 cell">
			<select name="filter[format]">
				<option value="">Formato</option>
				<?php foreach(getFilter("format") as $value) { ?>
				<option value="<?php echo $value['value']; ?>"<?php if($value['value'] == $_REQUEST['filter']['format']) echo " selected='selected'"; ?>><?php echo getFormatText($value['value']); ?> (<?php echo $value['total']; ?>)</option>
				<?php } ?>
			</select>
		</div>
		<div class="filter large-1 medium-1 small-1 cell">
			<input type="text" name="search" value="<?php echo $_REQUEST['search']; ?>" />
		</div>
		<div class="filter large-1 medium-1 small-1 cell">
			<select name="orderby">
				<option value="">Ordenar por</option>
				<option value="year"<?php if("year" == $_REQUEST['orderby']) echo " selected='selected'"; ?>>Año ASC</option>
				<option value="yeardesc"<?php if("yeardesc" == $_REQUEST['orderby']) echo " selected='selected'"; ?>>Año DESC</option>
				<option value="duration"<?php if("duration" == $_REQUEST['orderby']) echo " selected='selected'"; ?>>Duración ASC</option>
				<option value="durationdesc"<?php if("durationdesc" == $_REQUEST['orderby']) echo " selected='selected'"; ?>>Duración DESC</option>
			</select>
		</div>
	</div>
</form>
<div class="grid-x grid-padding-x">
	<?php $counter = 0; foreach($films as $id) { $counter++;?>
        <div class="film large-2 medium-3 small-6 cell<?php if($counter > 48) echo " hidden"; ?>">
		<?php $film = new films($id); ?>
		<span class="info">!</span>
		<a class="href" href="/films/film.php?id=<?php echo $film->getId(); ?>">
			<img src="<?php echo $film->getImgURl(); ?>" />
			<div class="box">
				<p class="title"><?php echo $film->getTitle(); ?></p>
				<p class="year"><?php echo $film->getTag('year'); ?></p>
				<p class="duration"><?php echo $film->getDuration(); ?>"</p>
				<?php if($film->getTag('author') != '') { ?><p class="author"><?php echo $film->getTag('author'); ?></p><?php } ?>
				<?php if($film->getTag('genre') != '') { ?><p class="genre"><?php echo $film->getTag('genre'); ?></p><?php } ?>
				<?php if($film->getTag('saga') != '') { ?><p class="saga"><?php echo $film->getTag('saga'); ?></p><?php } ?>
				<?php if(count($film->getViews()) > 0) { ?><p class="views"><?php foreach($film->getViews() as $view) { echo date("d-m-Y", strtotime($view['date']))." - ".getModeText($view['mode']); break; } ?></p><?php } ?>
			</div>
		</a>
	</div>
	<?php } ?>
	<div class="large-212 cell">
		<a href="#" class="viewmore"<?php if($counter <= 12) echo " style='opacity: 0;'"; ?>>ver más</a>
	</div>
</div>
<a href="/films/new.php" class="add">+</a>
<a href="/films/export.php" class="export">&#9660;</a>
<?php include_once("./inc/footer.php"); ?>
