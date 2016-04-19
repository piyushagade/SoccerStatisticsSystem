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



$('#pr_team_compare').click(function (e) {
    
	sParameter1 = $("#selected_team").val().replace(/ /g,"%20");
	sParameter2 = $("#selected_team_compare").val().replace(/ /g,"%20");
	if(sParameter1 !== sParameter2){
   		showResultFrame();
    	$("#result_frame").load("queries/teams_compare.php?team_1="+sParameter1+"&team_2="+sParameter2);
	}
});
