$('#eq_teams_1').click(function (e) {

    showResultFrame();
	
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_1.php?team="+sParameter);


});


$('#eq_teams_2').click(function (e) {

    showResultFrame();
    
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_2.php?team="+sParameter);

});

$('#eq_teams_3').click(function (e) {

    showResultFrame();
    
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_3.php?team="+sParameter);

});


$('#eq_teams_4').click(function (e) {

    showResultFrame();
    
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_4.php?team="+sParameter);

});

$('#eq_teams_5').click(function (e) {

    showResultFrame();
    
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_5.php?team="+sParameter);

});

$('#eq_teams_6').click(function (e) {

    showResultFrame();
    
	sParameter = $("#selected_team").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/teams_6.php?team="+sParameter);

});
