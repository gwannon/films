<?php

include_once("./inc/config.php");

$film = new films($_REQUEST['id']);
$title = $film->getTitle();

if(isset($_REQUEST['deleteview']) && $_REQUEST['deleteview'] != '') { $film->deleteView($_REQUEST['deleteview']); }
if(isset($_REQUEST['createview']) && $_REQUEST['createview'] != '') { 
	$temp = explode("-", $_REQUEST['createview']);
	$film->insertView(date("Y-m-d", strtotime($temp[2]."-".$temp[1]."-".$temp[0])), $_REQUEST['mode']); 
}

include_once("./inc/header.php"); ?>
<div class="grid-x grid-padding-x">
        <div class="minifilm large-12 cell">
		<div class="box">
			<p class="title"><?php echo $film->getTitle(); ?></p>
		</div>
	</div>
        <div class="minifilm large-4 medium-5 small-5 cell">
		<a href="#" data-open="popup"><img src="<?php echo $film->getImgURl(); ?>" /></a>
		<?php $views = $film->getViews(); ?> 
		<div class="box">
			<p class="views">Visionados (<?php echo count($views); ?>)</p>
			<?php if(count($views) > 0) { ?>
			<ul>		
				<?php foreach ($views as $view_id => $data) { ?>
				<li><?php echo date("d-m-Y", strtotime($data['date'])); ?> - <?php echo getModeText($data['mode']); ?> <a href="/films/film.php?id=<?php echo $film->getId(); ?>&deleteview=<?php echo $view_id; ?>">&#10006;</a></li>
				<?php } ?>
			</ul> 
			<?php } ?><br/>
			<form method="post">
				<select style="width: 100%;" name="mode" style="width: 172px; display: inline-block; margin: 0px;">
					<?php $modes = 	array('tv','mobile','cinema','room'); foreach ($modes as $mode) { ?>
					<option value="<?php echo $mode; ?>"><?php echo getModeText($mode); ?></option>
					<?php } ?>
				</select><br/>
				<input style="width: 100%;" type="date" name="createview" style="max-width: 172px; display: inline-block; margin: 0px;" format="dd/MM/yyyy" value="" /><br/>
				<input style="width: 100%;" type="submit" class="button" name="savefilm" value="Guardar" style="margin: 0px;" />
			</form>
		</div>
	</div>
        <div class="minifilm large-8 medium-7 small-7 cell">
		<div class="box nopaddingtop">
			<p class="titleoriginal"><?php echo $film->getTitleOriginal(); ?></p>
			<p class="year"><?php echo $film->getTag('year'); ?></p>
			<p class="duration"><?php echo $film->getDuration(); ?>"</p>
			<?php if($film->getTag('author') != '') { ?><p class="author"><?php echo $film->getTag('author'); ?></p><br/><?php } ?>
			<?php if($film->getTag('genre') != '') { ?><p class="genre"><?php echo $film->getTag('genre'); ?></p><br/><?php } ?>
			<?php if($film->getTag('saga') != '') { ?><p class="saga"><?php echo $film->getTag('saga'); ?></p><br/><?php } ?>
			<?php if($film->getTag('format') != '') { ?><p class="icons"><img src="/films/imgs/<?php echo $film->getTag('format'); ?>.png" /></p><br/><?php } ?>
			<p class="duration"><?php echo getResolutionText($film->getResolution()); ?></p>
			<p class="duration"><?php echo getSoundText($film->getSound()); ?> <?php echo getChannelText($film->getChannel()); ?></p>
			<p class="duration"><?php echo getLanguageText($film->getLanguage()); ?></p><br/>
			<?php if($film->getStatus() != '') { ?><p class="duration"><?php echo getStatusText($film->getStatus()); ?></p><br/><?php } ?>
			<?php if($film->getNotes() != '') { ?><p class="notes"><?php echo nl2br($film->getNotes()); ?></p><?php } ?>
			<?php if($film->getIMDB() != '') { ?><p class="imdb"><a href="<?php echo $film->getIMDB(); ?>" target="_blank"><img src="/films/imgs/imdb.png" /></a></p><br/><?php } ?>
			
		</div>
	</div>
</div><br/><br/><br/>
<div class="reveal" id="popup" data-reveal>
	<img src="<?php echo $film->getImgURl(); ?>" />
	<button class="close-button" data-close aria-label="Close modal" type="button">
		<span aria-hidden="true">&#10006;</span>
	</button>
</div>
<a class="back" href="/films/">Volver</a>
<a class="edit" href="/films/edit.php?id=<?php echo $film->getId(); ?>">Editar</a>
<?php include_once("./inc/footer.php"); ?>
