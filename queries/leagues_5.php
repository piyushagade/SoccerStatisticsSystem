
<?php

// Start the session
session_start();

//Get Post variables
$selected_league = $_GET['league'];
$rank = $_GET['rank'];
$num_seasons = $_GET['num_seasons'];

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

//Get division
$query_div = "select ID from LEAGUE where TITLE='$selected_league'";
	$stid_div = oci_parse($conn, $query_div);
	oci_execute($stid_div);
	$row_div = oci_fetch_array($stid_div, OCI_BOTH);
	$div=$row_div[0];
	
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

// Execute the query
//Most games with goals only in 2nd half by Away team
 	$query_main = "select * from (select awayteam,count(*) from GAMES G, SCORES S, RESULT R where G.ID = R.ID AND G.ID = S.ID AND G.DIV = R.DIV AND G.DIV = S.DIV AND htag = 0 and ftag > htag and G.div = '$div' and ($like_statement) group by awayteam order by count(*) desc) where rownum <= '$rank'";
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
<span>Following table shows the <u>top ten</u> away teams in <u><?php echo $selected_league ?></u> that managed to score only in the second half.<br>
The teams have been ranked based on number of such matches in ascending order. The score represents number of such matches.</span>
<br><br>

    <table class="result_table">
    <tr><td class="accent"><font size="+1">Team</font></td><td class="accent"><font size="+1">Score</font></td></tr>
<?php
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