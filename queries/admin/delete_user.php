
<?php
	
// Start the session
session_start();

//Get Post variables
$selected_user = $_GET['user'];

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

//Get Name
$query_name = "select NAME from USERS where lower(username)=lower('$selected_user')";
	$stid_name = oci_parse($conn, $query_name);
	oci_execute($stid_name);
	$row_name = oci_fetch_array($stid_name, OCI_BOTH);
	$name=$row_name[0];
	

//Delete User
 	$query_main = "delete from USERS where lower(username)=lower('$selected_user')";
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
    <tr><td class="accent"><font size="+1"><?php echo $name ?></font></td><td ><font size="+1">deleted.</font></td></tr>

</table>
</center>



</body>
</html>