$(document).ready(function(e) {   
	$('#register_container').fadeOut(1);

      $('#registration').click(function (e) {    
	   $('#login_container').fadeOut(600);
	   setTimeout(function() {
       $('#login_container').addClass('hidden');
       $('#register_container').removeClass('hidden');
	   $('#register_container').fadeIn(600);
   }, 600);
      });
	  
	  $('#login').click(function (e) {    
	   $('#register_container').fadeOut(600);
	   setTimeout(function() {
       $('#register_container').addClass('hidden');
       $('#login_container').removeClass('hidden');
	   $('#login_container').fadeIn(600);
   }, 600);
      });
	  
	 
	 
	 
var body = $('#background-image');
var backgrounds = [
      'url(img/bg_1.jpg)', 
      'url(img/bg_2.jpg)', 
      'url(img/bg_3.jpg)', 
      'url(img/bg_4.jpg)'];
var current = 0;
function nextBackground() {
        body.css(
            'background',
        backgrounds[current = ++current % backgrounds.length]);

        setTimeout(nextBackground, 10000);
}
setTimeout(nextBackground, 10000);
body.css('background', backgrounds[0]);
	
	
	
	
	
// Member area animation
$('#ma_app_title').fadeOut(0);
	
	setTimeout(function() {	 
	$('#ma_app_title').fadeIn(1200);
	$('#member_area_container').fadeIn(1200);
   }, 600);
	  
});
	
	
	