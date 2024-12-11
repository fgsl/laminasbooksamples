/**
 * Show a confirmation window
 */
$(function() {
	$("button.delete").click(function() {
		if (window.confirm('Deseja realmente apagar?')) {
			window.location.replace($(this).attr("url"));
		}
	})
});
