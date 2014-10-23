$(document).ready(function() {
	var arrayFromPHP = <?php echo json_encode($classes); ?>;
	$.each(arrayFromPHP, function (time, classes) {
		console.log(classes);
    		$("input[value=time]").parent().remove();
	});
});