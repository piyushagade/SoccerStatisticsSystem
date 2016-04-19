$('#eq_leagues_1').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
	
	
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_1.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);


});


$('#eq_leagues_2').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
	$("#result_frame").load("queries/leagues_2.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
});

$('#eq_leagues_3').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_3.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});


$('#eq_leagues_4').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_4.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});

$('#eq_leagues_5').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_5.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});

$('#eq_leagues_6').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_6.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});

$('#eq_leagues_7').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_7.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});

$('#eq_leagues_8').click(function (e) {

    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_8.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);

});

$('#eq_leagues_9').click(function (e) {
	if($('#premium_box').html() === '1'){
    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_9.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}
});

$('#eq_leagues_10').click(function (e) {
	
	if($('#premium_box').html() === '1'){
    showResultFrame();
	
	setLeagueVariables();
    
	sParameter = $("#selected_league").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/leagues_10.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}
});





$('#leagues_outcome').on('change', function() {
 if($(this).val() != 'default'){
	 hideFade('#td_leagues_half');
 }
 else{
	 fadeShow('#td_leagues_half');
 }
});

$('#leagues_half').on('change', function() {
 if($(this).val() != 'default'){
	 hideFade('#td_leagues_outcome');
 }
 else{
	 fadeShow('#td_leagues_outcome');
 }
});



function setLeagueVariables(){
	rank = $("#rank").val();
	num_seasons = $("#num_seasons").val();
	
	if(jQuery.trim(rank).length == 0){
		rank = 10;
	}
	
	if(jQuery.trim(num_seasons).length == 0){
		num_seasons = 15;
	}
	
}

// *******************   Custom Query   *****************  //

$('#custom_execute').click(function (e) {
    executeCustomLeaguesQuery();
});


function executeCustomLeaguesQuery(){
	var outcome = $("#leagues_outcome").val();
	var as = $("#leagues_away_home").val();
	var half = $("#leagues_half").val();
	
	var sParameter= $("#selected_league").val().replace(/ /g,"%20");

	setLeagueVariables();
	
	if(outcome === 'win' && as === 'home' && half === 'default'){
		//Query 1
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_1.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}	
	
	else if(outcome === 'win' && as === 'away' && half === 'default'){
		//Query 2
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_2.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}		
	
	else if(outcome === 'lose' && as === 'home' && half === 'default'){
		//Query 14
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_14.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}		
	
	else if(outcome === 'lose' && as === 'away' && half === 'default'){
		//Query 15
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_15.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}	
	
	
	
	
	
	
	else if(outcome === 'default' && as === 'home' && half === 'second_half'){
		//Query 3
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_3.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}		
	
	else if(outcome === 'default' && as === 'away' && half === 'second_half'){
		//Query 11
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_11.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}			
	
	else if(outcome === 'default' && as === 'home' && half === 'first_half'){
		//Query 12
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_12.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}			
	
	else if(outcome === 'default' && as === 'away' && half === 'first_half'){
		//Query 13
		showResultFrame();
		
    	$("#result_frame").load("queries/leagues_13.php?league="+sParameter+"&rank="+rank+"&num_seasons="+num_seasons);
	}			
	
	
}
