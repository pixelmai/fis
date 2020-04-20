
$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content main').toggleClass('push-margin');
        $('#content .navbar').toggleClass('push-margin');
    });


	setTimeout(function() {
		$("#app .alert").alert('close');
	}, 5000);

	$('body').tooltip({selector: '[data-toggle="tooltip"]'});

  /*
	$("select").dropkick({
	  mobile: true
	});

  */

  $('select').selectpicker();

});

window.generateNotif=function(data){
  var alertHtml = '<div id="notifAlert" class="alert alert-'+data.status+' alert-dismissible" role="alert"><span>'+ data.message +'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
  $("#app").append(alertHtml);

  setTimeout(function(){
    $("#notifAlert").fadeOut("1000");
  }, 5000);
};



