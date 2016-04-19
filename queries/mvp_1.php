
<?php
	
// Start the session
session_start();

//Get Post variables
$mvp_1 = $_GET['mvp_1'];
$mvp_2 = $_GET['mvp_2'];

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
//MVP - midfielder - 1
 	$query_m_1 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_1' and position = 'm' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_m_1 = oci_parse($conn, $query_m_1);
	oci_execute($stid_m_1);
	


//MVP - attacker - 1	
	$query_a_1 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_1' and position = 'a' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_a_1 = oci_parse($conn, $query_a_1);
	oci_execute($stid_a_1);

//MVP - defender - 1
 	$query_d_1 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_1' and position = 'd' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_d_1 = oci_parse($conn, $query_d_1);
	oci_execute($stid_d_1);
	

//MVP - goalkeeper - 1	
	$query_g_1 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_1' and position = 'g' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_g_1 = oci_parse($conn, $query_g_1);
	oci_execute($stid_g_1);
	
	
	
	
//MVP - midfielder -2
 	$query_m_2 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_2' and position = 'm' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_m_2 = oci_parse($conn, $query_m_2);
	oci_execute($stid_m_2);
	


//MVP - attacker - 2	
	$query_a_2 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_2' and position = 'a' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_a_2 = oci_parse($conn, $query_a_2);
	oci_execute($stid_a_2);

//MVP - defender - 2
 	$query_d_2 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_2' and position = 'd' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_d_2 = oci_parse($conn, $query_d_2);
	oci_execute($stid_d_2);
	

//MVP - goalkeeper - 2	
	$query_g_2 = "select * from (select name, club, position, Sum(p) as Points from player, playerdata where player.id = playerdata.id and club = '$mvp_2' and position = 'g' group by name, club, position order by Sum(p) desc) where rownum <=1";
	$stid_g_2 = oci_parse($conn, $query_g_2);
	oci_execute($stid_g_2);
	
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System</title>
<link rel="stylesheet" type="text/css" href="..\css\style.css">
<link rel="stylesheet" type="text/css" href="..\css\ma_right_content_style.css">

</head>
<body>


<center>
<br>
<br>

<table class="result_table">
    <tr><td class="accent"><font size="+1"><?php echo $mvp_1; ?>'s MVPs</font></td>
    <td class="accent"><font size="+1">Position</font></td>
    <td class="accent"><font size="+1">Points</font></td></tr>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	$row_m_1 = oci_fetch_array($stid_m_1, OCI_BOTH);
	$num_row_m_1 = oci_num_rows($stid_m_1);
	$row_a_1 = oci_fetch_array($stid_a_1, OCI_BOTH);
	$num_row_a_1 = oci_num_rows($stid_a_1);
	$row_d_1 = oci_fetch_array($stid_d_1, OCI_BOTH);
	$num_row_d_1 = oci_num_rows($stid_d_1);
	$row_g_1 = oci_fetch_array($stid_g_1, OCI_BOTH);
	$num_row_g_1 = oci_num_rows($stid_g_1);
		
?>
        <tr><td><hr class="hr_alt"/></td><td><hr class="hr_alt"/></td></td><td><hr class="hr_alt"/></td>
		<tr><td><?php echo $row_m_1[0]; ?></td>
        	<td>Mid-fielder</td>
        	<td><?php echo $row_m_1[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_a_1[0]; ?></td>
        	<td>Striker</td>
        	<td><?php echo $row_a_1[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_g_1[0]; ?></td>
        	<td>Goalkeeper</td>
        	<td><?php echo $row_g_1[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_d_1[0]; ?></td>
        	<td>Defender</td>
        	<td><?php echo $row_d_1[3]; ?></td>
        </tr>
        <?php $points_sum_1 = $row_m_1[3] + $row_a_1[3] + $row_g_1[3] + $row_d_1[3]; ?>
</table>

<br><br>

<table class="result_table">
    <tr><td class="accent"><font size="+1"><?php echo $mvp_2; ?>'s MVPs</font></td>
    <td class="accent"><font size="+1">Position</font></td>
    <td class="accent"><font size="+1">Points</font></td></tr>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	$row_m_2 = oci_fetch_array($stid_m_2, OCI_BOTH);
	$num_row_m_2 = oci_num_rows($stid_m_2);
	$row_a_2 = oci_fetch_array($stid_a_2, OCI_BOTH);
	$num_row_a_2 = oci_num_rows($stid_a_2);
	$row_d_2 = oci_fetch_array($stid_d_2, OCI_BOTH);
	$num_row_d_2 = oci_num_rows($stid_d_2);
	$row_g_2 = oci_fetch_array($stid_g_2, OCI_BOTH);
	$num_row_g_2 = oci_num_rows($stid_g_2);
		
?>
        <tr><td><hr class="hr_alt"/></td><td><hr class="hr_alt"/></td></td><td><hr class="hr_alt"/></td>
		<tr><td><?php echo $row_m_2[0]; ?></td>
        	<td>Mid-fielder</td>
        	<td><?php echo $row_m_2[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_a_2[0]; ?></td>
        	<td>Striker</td>
        	<td><?php echo $row_a_2[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_g_2[0]; ?></td>
        	<td>Goalkeeper</td>
        	<td><?php echo $row_g_2[3]; ?></td>
        </tr>
        <tr><td><?php echo $row_d_2[0]; ?></td>
        	<td>Defender</td>
        	<td><?php echo $row_d_2[3]; ?></td>
        </tr>
		<?php $points_sum_2 = $row_m_2[3] + $row_a_2[3] + $row_g_2[3] + $row_d_2[3]; ?>
</table><br><br>

<?php
 	
	if($points_sum_1 > $points_sum_2){
		echo $mvp_1." ";
		?>
        	seems to have a more promising squadron compared to that of
        <?php	
		echo " ".$mvp_2;
	}
	else if($points_sum_1 < $points_sum_2){
		echo $mvp_2." ";
		?>
        	seems to have a more promising squadron compared to that of
        <?php	
		echo " ".$mvp_1.".";	
	}
?>
</center>



</body>
</html>