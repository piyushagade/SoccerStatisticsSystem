
<?php
	
// Start the session
session_start();

//Get Post variables
$selected_team_1 = $_GET['team_1'];
$selected_team_2 = $_GET['team_2'];

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
//	Wins for team 1
 	$query_wins_1 = "select count(*) from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'H') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'A'))";
	$stid_wins_1 = oci_parse($conn, $query_wins_1);
	oci_execute($stid_wins_1);


//	Wins for team 2
 	$query_wins_2 = "select count(*) from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'A') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'H'))";
	$stid_wins_2 = oci_parse($conn, $query_wins_2);
	oci_execute($stid_wins_2);


//	Draws
 	$query_draw = "select count(*) from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'D') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'D'))";
	$stid_draw = oci_parse($conn, $query_draw);
	oci_execute($stid_draw);



//	Stats
 	$query_stats = "select (DRAWS.A1) / (DRAWS.A1 + WINS1.A2 + WINS2.A3),( WINS1.A2) / (DRAWS.A1 + WINS1.A2 + WINS2.A3),(WINS2.A3) / (DRAWS.A1 + WINS1.A2 + WINS2.A3) FROM 
  (select count(*) A1 from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'D') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'D'))) DRAWS ,
  (select count(*) A2 from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'H') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'A'))) WINS1 ,
  (select count(*) A3 from games,result where games.id = result.id and games.div = result.div and 
((hometeam = '$selected_team_1' and awayteam = '$selected_team_2' and result.FTR = 'A') or (awayteam = '$selected_team_1' and hometeam = '$selected_team_2' and result.FTR = 'H'))) WINS2 ";
	$stid_stats = oci_parse($conn, $query_stats);
	oci_execute($stid_stats);

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
<span>Following table shows the comparision between <u><?php echo $selected_team_1 ?></u> and <u><?php echo $selected_team_2 ?></u>.<br></span>
<br><br>

<table class="result_table">
<tr><td class="accent"><font size="+1"></font></td><td class="accent"><font size="+1"><?php echo $selected_team_1; ?></font></td><td class="accent"><font size="+1"><?php echo $selected_team_2; ?></font></td></tr>

<?php
	$row_wins_1 = oci_fetch_array($stid_wins_1, OCI_BOTH);
	$row_wins_2 = oci_fetch_array($stid_wins_2, OCI_BOTH);
	$row_draws = oci_fetch_array($stid_draw, OCI_BOTH);
	$row_stats = oci_fetch_array($stid_stats, OCI_BOTH);
	
	
	$no_games = 0;
	$wins_1 = $row_wins_1[0];
	$wins_2 = $row_wins_2[0];
	$draws = $row_draws[0];
	$no_games = $wins_1 + $wins_2 + $draws;
	$loss_1 = $no_games - $wins_1 - $draws;
	$loss_2 = $no_games - $wins_2 - $draws;
	
	if($no_games === 0){
		//No matches played between the teams
		?>
        <script type="text/javascript">
			$("#result_frame").load("no_results.html");
		</script>
        <?php
	}
?>

<tr><td></td><td><hr class="hr_alt"/></td><td><hr class="hr_alt"/></td>
		<tr>
        <td>Wins</td>
        <td><?php echo $wins_1; ?></td>
        <td><?php echo $wins_2; ?></td>
        </tr>
        
        <tr>
        <td>Winning chances</td>
        <td><?php echo number_format((float)$row_stats[1], 2, '.', ''); ?></td>
        <td><?php echo number_format((float)$row_stats[2], 2, '.', ''); ?></td>
        </tr>
        
        <tr>
        <td>Draws</td>
        <td colspan="2"><?php echo $draws; ?></td>
</table>

<br><br>
Clearly, statistically <?php 
if($row_stats[1] > $row_stats[2]){ echo $selected_team_1;}
else if($row_stats[1] < $row_stats[2]){ echo $selected_team_2;} ?>
 has a better chance of winning in this fixture.

</center>

</body>
</html>