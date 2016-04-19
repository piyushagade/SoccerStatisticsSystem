$('#search_player').click(function (e) {
	
	sParameter_1 = $("#selected_search_club").val().replace(/ /g,"%20");
	sParameter_2 = $("#selected_search_position").val().replace(/ /g,"%20");
	
	if(sParameter_1 != 'default' || sParameter_2 != 'default'){
    	showResultFrame();
    	$("#result_frame").load("queries/search_player.php?club="+sParameter_1+"&position="+sParameter_2);
	}

});

$('#search_team').click(function (e) {
	
	sParameter = $("#selected_search_player").val().replace(/ /g,"%20");
	
	if(sParameter != 'default'){
    	showResultFrame();
    	$("#result_frame").load("queries/search_team.php?player="+sParameter);
	}

});
