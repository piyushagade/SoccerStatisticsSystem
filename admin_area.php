
<?php

// Start the session
session_start();

// Set session variables
if(isset($_POST['signin'])){
	$_SESSION["username"] = $_POST['username'];
	$_SESSION["password"] = $_POST['password'];
}

$username = $_SESSION["username"];
$password = $_SESSION["password"];

//$con=oci_connect('userame','password','oracle_sid');
$conn=oci_connect('pagade','agadeoracle','oracle.cise.ufl.edu:1521/orcl');
if($conn){

}
	
else
{
    $err = oci_error();
	trigger_error(htmlentities($err['message'], ENT_QUOTES), E_USER_ERROR);
}
 	$query = "SELECT name, admin, premium FROM USERS WHERE username = '$username' AND password = '$password'";
	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	$row = oci_fetch_array($stid, OCI_BOTH);
	
	if($row !== false){
		$authorized = 1;
		$_SESSION["authorized"]=1;
		$name = $row[0];
		$admin = $row[1];
	}
	else{
		$authorized = 0;
		$name="Unauthorized";
		$_SESSION["authorized"]=0;
		header("Location: 403.html"); 
        session_destroy();
	}
?>

<?php
if($admin == 0){
	$chars="stackoverflowrules";
?>
<html>
<form name='redirect' action='member_area.php' method='POST'>
<input type='hidden' name='chars' value='<?php echo $chars; ?>'>
<input type='submit' value='Proceed'>
</form>
<script type='text/javascript'>
document.redirect.submit();
</script>
</html>

<?php
     }
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System (Admin)</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/ma_right_content_style.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js" type="text/javascript"></script>

</head>
<body>
<div id="background-image" class="background-image"></div>

<!-- Member Area Container -->

<div id="member_area_container" class="member_area_container">
<div id="form">
    <section>
    
    <!-- ********** Left Menu Area *********** -->
	<div id="left_menu">
    	<font size="+2">Menu</font><br><br>
        <button class="button_menu" id="open_menu_leagues">Users</button>
		<br><br>
        <button class="button_menu" id="open_menu_teams">Teams</button>
		<br><br>
        <button class="button_menu" id="open_menu_3">About</button>
		<br><br>
        <button class="button_menu" id="open_menu_4">Help</button>
		<br><br>
        <hr><br>
		<center>Admin: <span class="accent"><?php echo $name ?></span>.</center>
        <br><br>
        <button class="button_menu_alt" id="ma_logout">Logout</button>
    </div>
    
    
    <!-- ********** Right Area Content *********** -->
    <div id="right_menu">
    	<div id="ma_right_default" class="ma-right_default"><br><br><br><br><br><br><br>
        	<center>Select an item from the left menu.</center>
        </div>
        
     
    <!-- ******************* Users ****************** -->
    
    <!-- Page 1 -->
    <div id="ma_right_leagues_1" class="hidden" style="padding-top: 10px;">
    <font size="+2">Leagues</font><br><br>
    To begin, select a league from the drop-down menu. Select the query you want to perform.
    <br><hr><br>
    
    <!--Delete a user -->
	<?php
     	$query_users = "SELECT NAME, USERNAME, ADMIN FROM USERS";
		$users = oci_parse($conn, $query_users);
		oci_execute($users);
	?>
    Delete a user:
    <Select class="input_alt" id="delete_selected_user" name="delete_selected_user">
    <?php
	$selected_user = '';
	while(($row_users = oci_fetch_array($users, OCI_BOTH)) != false){
		$num_row_users = oci_num_rows($users);
		
		if($row_users[1] !='' && $row_users[2] != 1){
			echo '<option value="'.$row_users[1].'">'.$row_users[0].'</option>';
		
		}
	}
	?>
    
 	</Select>
    <button style="margin-bottom: 10px; margin-top: 10px; margin-right:10px;" class="button_content_alt button-block" id="admin_delete_user">Delete</button><br>
    <hr class="hr_alt"/>
    
    <!--Add a user -->
    Add a user:<br>
    <label>Username:</label><input type="text" class="input_alt" id="new_username" name="new_username">
    <label>Name:</label><input type="text" class="input_alt" id="new_name" name="new_name">
    <label>Password:</label><input type="password" class="input_alt" id="new_password" name="new_password">
    <label>Admin:</label><input type="checkbox" class="input_alt_chkbox" id="new_admin" name="new_admin">
    <label>Premium User:</label><input type="checkbox" class="input_alt_chkbox" id="new_premium" name="new_premium">
    
    <button style="margin-bottom: 10px; margin-top: 10px; margin-right:10px;" class="button_content_alt button-block" id="admin_add_user">Add</button><br>
    <hr class="hr_alt"/>
    
    
    </div>
    
    
        
    <div id="ma_right_teams" class="hidden"><br><br><br><br><br><br><br>
        	<center><font color="#FFC107">Select a team from the left menu.</font></center>
        </div>
    </div>
 
	</section>
	</div>
</div>

<div class="result_frame hidden" id="result_frame"></div>
<div class="result_frame_bg hidden" id="result_frame_bg"></div>
 
 <button class="button_special result_frame_close hidden" id="result_frame_close">X</button>

   <!-- ********** Import scripts *********** -->
	<script src="js/w3-include-HTML.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/scripts.js" ></script>
	<script type="text/javascript" src="js/ma_menu.js" ></script>
	<script type="text/javascript" src="js/admin_queries.js" ></script>
	<script type="text/javascript" src="js/league_queries.js" ></script>
 
 
</body>
</html>

