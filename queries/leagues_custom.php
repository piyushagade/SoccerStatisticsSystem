
<?php
	
// Start the session
session_start();

//Get Post variables
$selected_league = $_GET['league'];
$rank = $_GET['rank'];
$num_seasons = $_GET['num_seasons'];
$query = $_GET['query'];

echo($query);

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

$ns = $num_seasons;
$like_statement = '';
while($ns!=-1){
	$year = 15 - $ns;
	if($ns!=0)
		{
			$like_statement = $like_statement . " dated LIKE '%".$year."' OR" ;
		}
		else
		{
			$like_statement = $like_statement . " dated LIKE '%".$year."'" ;
		}
	$ns = $ns-1;
}

//Get division
$query_div = "select ID from LEAGUE where lower(TITLE)=lower('$selected_league')";
	$stid_div = oci_parse($conn, $query_div);
	oci_execute($stid_div);
	$row_div = oci_fetch_array($stid_div, OCI_BOTH);
	$div=$row_div[0];

// Execute the query
//Most home games won
 	$query_main = $query;
	
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
<span>Following table shows the <u>top ten</u> teams in <u><?php echo $selected_league ?></u> that performed better than other teams on their home grounds.<br>
The teams have been ranked based on number of home ground wins in ascending order. The score represents number of such wins.</span>
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
		<tr><td><?php echo $row_main[0]; ?></td>
        	<td><?php echo $row_main[1]; ?></td>
        </tr>
<?php
	
		
		}
	}
 ?>
</table>
</center>



</body>
</html>