
<?php
	
// Start the session
session_start();

//Get Post variables
$player = $_GET['player'];

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

// Execute the query
// Search Player

	$query_t = "select CLUB from PLAYER where name='$player'";
	$stid_t = oci_parse($conn, $query_t);
	oci_execute($stid_t);
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
<br>

<table class="result_table">
    <tr><td class="accent"><font size="+1"><?php echo $player; ?>'s team:</font></td>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	
	while(($row_t = oci_fetch_array($stid_t, OCI_BOTH)) != false){
		$num_rows_t = oci_num_rows($stid_t);
		
		if($row_t[0] !=''){
?>

        <tr><td><hr class="hr_alt"/></td>
		<tr><td><?php echo $row_t[0]; ?></td>
        </tr>
 <?php
	
		
		}
	}
 ?>
</table>

<br><br>

</center>



</body>
</html>