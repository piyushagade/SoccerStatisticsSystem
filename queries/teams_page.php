
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
//Games
 	$query_games = "select count(*) from games where hometeam = '$selected_team' or awayteam = '$selected_team'";
	$stid_games = oci_parse($conn, $query_games);
	oci_execute($stid_games);


//Won
 	$query_won = "select count(*) from games, result where games.id = result.id and games.div = result.div and ((hometeam = '$selected_team' and ftr = 'H') or (awayteam = '$selected_team' and ftr = 'A'))";
	$stid_won = oci_parse($conn, $query_won);
	oci_execute($stid_won);


//Winning ratio
 	$query_winning_ratio_a = "select count(*) from games,result where games.id = result.id and games.div = result.div and ((hometeam = '$selected_team' and ftr = 'H') or (awayteam = '$selected_team' and ftr = 'A'))";
	$stid_winning_ratio_a = oci_parse($conn, $query_winning_ratio_a);
	oci_execute($stid_winning_ratio_a);
	
	$query_winning_ratio_b = "select count(*) from games where hometeam = '$selected_team' or awayteam = '$selected_team'";
	$stid_winning_ratio_b = oci_parse($conn, $query_winning_ratio_b);
	oci_execute($stid_winning_ratio_b);
	
//Favorite opponent at home
	$query_fav_opponenet_home = "select * from (select games.awayteam, count(*) from games,result where games.id = result.id and games.div = 	result.div and (hometeam = '$selected_team' and ftr = 'H') group by games.AWAYTEAM order by count(*) desc) where rownum=1";
	$stid_fav_opponenet_home = oci_parse($conn, $query_fav_opponenet_home);
	oci_execute($stid_fav_opponenet_home);

	
//Favorite opponent away
	$query_fav_opponenet_away = "select * from (select games.hometeam,count(*) from games,result where games.id = result.id and games.div = result.div and (awayteam = '$selected_team' and ftr = 'A')
group by games.Hometeam order by count(*) desc) where rownum=1";
	$stid_fav_opponenet_away = oci_parse($conn, $query_fav_opponenet_away);
	oci_execute($stid_fav_opponenet_away);


	
//Deadliest opponent at home
	$query_dead_opponenet_home = "select * from (select games.awayteam,count(*) from games,result where games.id = result.id and games.div = result.div and (hometeam = '$selected_team' and ftr = 'A') group by games.AWAYTEAM order by count(*) desc) where rownum=1";
	$stid_dead_opponenet_home = oci_parse($conn, $query_dead_opponenet_home);
	oci_execute($stid_dead_opponenet_home);

	

	
//Deadliest opponent away
	$query_dead_opponenet_away = "select * from (select games.hometeam,count(*) from games,result where games.id = result.id and games.div = result.div and (awayteam = '$selected_team' and ftr = 'H')
group by games.Hometeam order by count(*) desc) where rownum=1";
	$stid_dead_opponenet_away = oci_parse($conn, $query_dead_opponenet_away);
	oci_execute($stid_dead_opponenet_away);


//Best year
$year_count = 15;
$best_year = -1000;
$best_count = -1000;

while($year_count != 0){
	$year_count = str_pad($year_count, 2, '0', STR_PAD_LEFT);
	
 	$query_best_count = "select count(*) from games, result where games.id = result.id and games.div = result.div and dated like '%$year_count' and ((hometeam = '$selected_team' and ftr = 'H') or (awayteam = '$selected_team' and ftr = 'A'))";
	
	$stid_best_count = oci_parse($conn, $query_best_count);
	oci_execute($stid_best_count);
	
	$row_best_count = oci_fetch_array($stid_best_count, OCI_BOTH);
	
	if($row_best_count > $best_count){
		$best_count = $row_best_count;
		$best_year = $year_count + 2000;
	}
	
$year_count = $year_count - 1;
}
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

<font class="black" size="+2">Team Performance & History</font>
<br><br>

<table border="0px" style="background: rgba(255, 255, 255, 0.2);" cellpadding="10px" cellspacing="20px">
    	<tr>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	while(($row_games = oci_fetch_array($stid_games, OCI_BOTH)) != false){
		$num_rows_games = oci_num_rows($stid_games);
		if($row_games[0] !=''){
		
?>
        
        <td valign="top">
        <font size="2px">Games played</font><br>
        <font size="32px" class="accent short_line_height"><?php echo $row_games[0]; $no_games=$row_games[0]; ?></font>
        </td>
<?php
		}
	}
 ?>        


<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	while(($row_won = oci_fetch_array($stid_won, OCI_BOTH)) != false){
		$num_rows_won = oci_num_rows($stid_won);
		if($row_won[0] !=''){
		
?>
        
        <td valign="top">
        <font size="2px">Games won</font><br>
        <font size="32px" class="accent short_line_height"><?php echo $row_won[0]; $games_won = $row_won[0]; ?></font>
        </td>
<?php
		}
	}
 ?> 
 
 
 <?php
        $row_games = oci_fetch_array($stid_games, OCI_BOTH);
?>
        <td valign="top">
        <font size="2px">Winning ratio</font><br>
        <font size="32px" class="accent short_line_height"><?php echo number_format((float)$games_won/$no_games, 2, '.', ''); ?></font>
        </td>


        </tr>
    </table>
    






<table border="0px" style="background: rgba(255, 255, 255, 0.14);" cellpadding="20px" cellspacing="10px">
    	<tr>
<td><font size="26px" class="black short_line_height"><?php echo $selected_team; ?></font></td>

        </tr>
</table>


<table border="0px" style="background: rgba(255, 255, 255, 0.2);" cellpadding="10px" cellspacing="10px">
    	<tr>
 

        <td valign="top">
        <font size="2px">Best year</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $best_year ?></font>
        </td>
        
        <td valign="top" style="padding-left:20px;">
        <font size="2px">Wins</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $best_count[0] ?></font>
        </td>
</td>

        </tr>
</table>


<table border="0px" style="background: rgba(255, 255, 255, 0.2);" cellpadding="10px" cellspacing="10px">
    	<tr>
 
<?php
	while(($row_fav_opponenet_home = oci_fetch_array($stid_fav_opponenet_home, OCI_BOTH)) != false){
		$num_rows_fav_opponenet_home = oci_num_rows($stid_fav_opponenet_home);
		if($row_fav_opponenet_home[0] !=''){
?>
        <td valign="top">
        <font size="2px">Best opponent on home ground</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_fav_opponenet_home[0].":"; ?></font>
        </td>
        
        <td valign="top" style="padding-left:10px;">
        <font size="2px">Wins</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_fav_opponenet_home[1]; } }?></font>
        </td>
</td>


<?php
	while(($row_fav_opponenet_away = oci_fetch_array($stid_fav_opponenet_away, OCI_BOTH)) != false){
		$num_rows_fav_opponenet_away = oci_num_rows($stid_fav_opponenet_away);
		if($row_fav_opponenet_away[0] !=''){
?>
        <td valign="top" style="padding-left:30px;">
        <font size="2px">Best opponent on away ground</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_fav_opponenet_away[0].":"; ?></font>
        </td>
        
        <td valign="top" style="padding-left:10px;">
        <font size="2px">Wins</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_fav_opponenet_away[1]; } }?></font>
        </td>
</td>

        </tr>
</table>



<table border="0px" style="background: rgba(255, 255, 255, 0.14);" cellpadding="10px" cellspacing="10px">
    	<tr>
 
<?php
	while(($row_dead_opponenet_home = oci_fetch_array($stid_dead_opponenet_home, OCI_BOTH)) != false){
		$num_rows_dead_opponenet_home = oci_num_rows($stid_dead_opponenet_home);
		if($row_dead_opponenet_home[0] !=''){
?>
        <td valign="top">
        <font size="2px">Deadliest opponent on home ground</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_dead_opponenet_home[0].":"; ?></font>
        </td>
        
        <td valign="top" style="padding-left:10px;">
        <font size="2px">Loss</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_dead_opponenet_home[1]; } }?></font>
        </td>
</td>


<?php
	while(($row_dead_opponenet_away = oci_fetch_array($stid_dead_opponenet_away, OCI_BOTH)) != false){
		$num_rows_dead_opponenet_away = oci_num_rows($stid_dead_opponenet_away);
		if($row_dead_opponenet_away[0] !=''){
?>
        <td valign="top" style="padding-left:30px;">
        <font size="2px">Deadliest opponent on away ground</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_dead_opponenet_away[0].":"; ?></font>
        </td>
        
        <td valign="top" style="padding-left:10px;">
        <font size="2px">Loss</font><br>
        <font size="32px" class="accent short_line_height"><?php echo  $row_dead_opponenet_away[1]; } }?></font>
        </td>
</td>

        </tr>
</table>
<br>
<br>

<hr class="hr_alt"/>
    



</body>
</html>