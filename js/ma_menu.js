//Open Pages/Navigation
$('#open_menu_leagues').click(function (e) {
	   fadeOutAll();
	   
	   setTimeout(function() {
       hideAll();
	   
       $('#ma_right_leagues_1').removeClass('hidden');
	   $('#ma_right_leagues_1').fadeIn(600);
   }, 600);
});

$('#open_menu_teams').click(function (e) {
	   fadeOutAll();
	   
	   setTimeout(function() {
       hideAll();
	   
       $('#ma_right_teams_1').removeClass('hidden');
	   $('#ma_right_teams_1').fadeIn(600);
   }, 600);
});



//Proceed Buttons
$('#pr_leagues_1').click(function (e) {
	   $("#league_title_1").text($('#selected_league').val());
	   $("#league_title_2").text($('#selected_league').val());
	   
	   $('#ma_right_leagues_1').fadeOut(600);
	   
	   
	   setTimeout(function() {	   
       $('#ma_right_leagues_2').removeClass('hidden');
	   $('#ma_right_leagues_2').fadeIn(600);
   }, 600);
});


$('#pr_teams_1').click(function (e) {
	   $("#team_title_1").text($('#selected_team').val());
	   $("#team_title_2").text($('#selected_team').val());
	   
	   $('#ma_right_teams_1').fadeOut(600);
	   
	   
	   setTimeout(function() {	   
       $('#ma_right_teams_2').removeClass('hidden');
	   $('#ma_right_teams_2').fadeIn(600);
   }, 600);
});


//Closes and logouts
$('#ma_logout').click(function (e) {
    window.location.href = "index.php";
});

$("#result_frame_close").click(function (e) {
	closeResultFrame();
});

$("#result_frame_bg").click(function (e) {
	closeResultFrame();
});



//Fade All Pages
function fadeOutAll(){
	   $('#ma_right_default').fadeOut(500);
	   $('#ma_right_leagues_1').fadeOut(500);
	   $('#ma_right_leagues_2').fadeOut(500);
	   $('#ma_right_teams_1').fadeOut(500);
	   $('#ma_right_teams_2').fadeOut(500);
}  

//Hide All Pages
function hideAll(){
	   $('#ma_right_default').addClass('hidden');
       $('#ma_right_leagues_1').addClass('hidden');
	   $('#ma_right_leagues_2').addClass('hidden');
	   $('#ma_right_teams_1').addClass('hidden');
	   $('#ma_right_teams_2').addClass('hidden');
}


//Result Frame
function showResultFrame(){
	
	setTimeout(function() {	 
	$("#result_frame_bg").removeClass("hidden");
	$("#result_frame_bg").animate({width:"100%"},400);
	
	result_frame_width = ($('#result_frame').width()+100).toString();
	result_frame_width_added = ($('#result_frame').width()+150).toString();
	result_frame_width_half = (($('#result_frame').width()+200)/2).toString();
	showLoading();
	
	while(result_frame_width == 100){
		
		
		setTimeout(function() {	 
			result_frame_width = ($('#result_frame').width()+100).toString();
			result_frame_width_added = ($('#result_frame').width()+150).toString();
		}, 500);
	}
	
	
		
	$('#member_area_container').animate({
    'marginLeft' : "-="+result_frame_width_added
	});
	
	$('#result_frame').animate({
    'marginLeft' : "-="+result_frame_width
	});
	$('#result_frame_close').animate({
    'marginLeft' : "-="+"490",
	'marginTop' : "+=20",
	});
	
	$("#result_frame").removeClass("hidden");
    $("#result_frame_close").removeClass("hidden");
	
	setTimeout(function() {	
	hideLoading();
	}, 1000);
	
   }, 800);
}


function closeResultFrame(){
	hideLoading();
	
	result_frame_width = ($('#result_frame').width()+100).toString();
	result_frame_width_added = ($('#result_frame').width()+150).toString();
	result_frame_width_half = (($('#result_frame').width()+200)/2).toString();
	
	$('#member_area_container').animate({
    'marginLeft' : "+="+result_frame_width_added
	});
	$("#result_frame_bg").animate({width:"0px"},400);
	//$("#result_frame").fadeOut(400);
	//$("#result_frame_close").fadeOut(400);
	
	$('#result_frame').animate({
    'marginLeft' : "+="+result_frame_width
	});
	
	$('#result_frame_close').animate({
    'marginLeft' : "+="+"490",
	'marginTop' : "-=20"
	});
	
	setTimeout(function() {	   
	$("#result_frame_bg").addClass("hidden");
    $("#result_frame").addClass("hidden");
    $("#result_frame_close").addClass("hidden");
   }, 600);
}

//Show loading animation
function showLoading(){
	$('#loading').fadeIn(300);
}

//Hide loading animation
function hideLoading(){
	$('#loading').fadeOut(300);
}



$( document ).ready(function() {
	setTimeout(function() {	
	hideLoading();
	}, 1800);

});