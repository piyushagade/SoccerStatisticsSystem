$('#pr_mvp_1').click(function (e) {

	
	sParameter_1 = $("#selected_mvp_1").val().replace(/ /g,"%20");
	sParameter_2 = $("#selected_mvp_2").val().replace(/ /g,"%20");
	
	if(sParameter_1 != sParameter_2){
   		showResultFrame();
    	$("#result_frame").load("queries/mvp_1.php?mvp_1="+sParameter_1+"&mvp_2="+sParameter_2);
	}

});
