$('#admin_delete_user').click(function (e) {

    showResultFrame();
	
	sParameter = $("#delete_selected_user").val().replace(/ /g,"%20");
    $("#result_frame").load("queries/admin/delete_user.php?user="+sParameter);


});


$('#admin_add_user').click(function (e) {

    showResultFrame();
	
	sParameter_1 = $("#new_username").val().replace(/ /g,"%20");
	sParameter_2 = $("#new_name").val().replace(/ /g,"%20");
	sParameter_3 = $("#new_password").val().replace(/ /g,"%20");
	
	if ($('#new_admin').is(':checked')) {
		sParameter_4 = '1';
	}
	else{
		sParameter_4 = '0';
	}
	if ($('#new_premium').is(':checked')) {
		sParameter_5 = '1';
	}
	else{
		sParameter_5 = '0';
	}
	
	
	sParameter_6 = $("#admin_selected_team").val().replace(/ /g,"%20");
	
    $("#result_frame").load("queries/admin/add_user.php?username="+sParameter_1+"&name="+sParameter_2+"&password="+sParameter_3+"&admin="+sParameter_4+"&premium="+sParameter_5+"&team="+sParameter_6);


});


