
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content main').toggleClass('push-margin');
        $('#content .navbar').toggleClass('push-margin');
    });


	setTimeout(function() {
		$("#app #content .alert").alert('close');
	}, 3000);

	$(function () {
	  $('[data-toggle="tooltip"]').tooltip()
	})

	$('#date_of_birth').datepicker();
});

