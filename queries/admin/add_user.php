
<?php
	
// Start the session
session_start();

//Get Post variables
$selected_username = $_GET['username'];
$selected_name = $_GET['name'];
$selected_password = $_GET['password'];
$selected_admin = $_GET['admin'];
$selected_premium = $_GET['premium'];
$selected_team = $_GET['team'];

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

//Delete User
 	$query_main = "insert into USERS values ('$selected_username', '$selected_password', '$selected_name', '$selected_admin', '$selected_premium', '$selected_team', (SELECT TO_TIMESTAMP('9999/01/01 00:00:00', 'YYYY/MM/DD HH24:MI:SS') FROM dual))";
	$stid_main = oci_parse($conn, $query_main);
	oci_execute($stid_main);
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System</title>
<link rel="stylesheet" type="text/css" href="css\style.css">
<link rel="stylesheet" type="text/css" href="css\ma_right_content_style.css">

</head>
<body>


<center>
<br>

    <table class="result_table">
    <tr><td class="accent"><font size="+1"><?php echo $selected_name ?></font></td><td ><font size="+1">added.</font></td></tr>

</table>
</center>



</body>
</html>