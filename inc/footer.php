	<script src="/films/js/vendor/jquery.js"></script>
	<script src="/films/js/vendor/what-input.js"></script>
	<script src="/films/js/vendor/foundation.js"></script>
	<script src="/films/js/app.js?date=<?php echo date('His'); ?>"></script>

	<?php if(basename($_SERVER['PHP_SELF']) == 'edit.php' || basename($_SERVER['PHP_SELF']) == 'new.php') { ?>
	<script src="/films/js/autocomplete/jquery.easy-autocomplete.min.js"></script> 
	<link rel="stylesheet" href="/films/js/autocomplete/easy-autocomplete.min.css"> 
	<script>
		<?php $options = array(); foreach (getFilter("author") as $value) { $options[] = $value['value']; } ?>
		var options = {	data: ['<?php echo implode("','", $options); ?>'], list: { match: { enabled: true } }};
		jQuery("#authorinput").easyAutocomplete(options);

		<?php $options = array(); foreach (getFilter("saga") as $value) { $options[] = $value['value']; } ?>
		var options = {	data: ['<?php echo implode("','", $options); ?>'], list: { match: { enabled: true } }};
		jQuery("#sagainput").easyAutocomplete(options);

		<?php $options = array(); foreach (getFilter("genre") as $value) { $options[] = $value['value']; } ?>
		var options = {	data: ['<?php echo implode("','", $options); ?>'], list: { match: { enabled: true } }};
		jQuery("#genreinput").easyAutocomplete(options);
	</script>
	<?php } ?>
</body>
</html>
<?php $db->close(); ?>
