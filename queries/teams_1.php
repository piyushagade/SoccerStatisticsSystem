
<?php
	
// Start the session
session_start();

//Get Post variables
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
	

// Execute the query
//Most home games won
 	$query_main = "select count(*) from game where (hometeam='$selected_team' and ftr = 'H') or (awayteam='$selected_team' and ftr = 'A')";
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
<span>Following table shows the number of matches won by <u><?php echo $selected_team ?></u> (either as a Home or Away team.)<br>
The score represents the number of total wins.</span>
<br><br>

    <table class="result_table">
    <tr><td class="accent"><font size="+1">Team</font></td><td class="accent"><font size="+1">Score</font></td></tr>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	while(($row_main = oci_fetch_array($stid_main, OCI_BOTH)) != false){
		$num_rows_main = oci_num_rows($stid_main);
		if($row_main[0] !=''){
		
?>
        <tr><td><hr class="hr_alt"/></td><td><hr class="hr_alt"/></td>
		<tr><td><?php echo $selected_team; ?></td>
        	<td><?php echo $row_main[0]; ?></td>
        </tr>
<?php
	
		
		}
	}
 ?>
</table>
</center>



</body>
</html>