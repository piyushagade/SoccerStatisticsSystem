
<?php
	
// Start the session
session_start();

//Get Post variables
$club = $_GET['club'];
$position = $_GET['position'];

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

	if($club == 'default'){ $query_m_1 = "select * from PLAYER where position='$position'"; }
	else if($position == 'default'){ $query_m_1 = "select * from PLAYER where club='$club'"; }
	else if($position != 'default' && $club != 'default') { $query_m_1 = "select * from PLAYER where club='$club' AND position='$position'"; }
	$stid_m_1 = oci_parse($conn, $query_m_1);
	oci_execute($stid_m_1);
	
	if($position == 'd'){ $pos = 'Defender'; }
	else if($position == 'g'){ $pos = 'Goalkeeper'; }
	else if($position == 'a'){ $pos = 'Striker'; }
	else if($position == 'm'){ $pos = 'Mid-fielder'; }
	
	
	if($position == 'default'){ $pos = 'Player'; }
	if($club == 'default'){ $club = 'All team'; }
			
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
    <tr><td class="accent"><font size="+1"><?php echo $club; ?>'s <?php echo $pos; ?>s</font></td>
<?php
	echo '<script type="text/javascript"> //alert(); </script>';
	
	while(($row_m_1 = oci_fetch_array($stid_m_1, OCI_BOTH)) != false){
		$num_rows_m_1 = oci_num_rows($stid_m_1);
		
		if($row_m_1[0] !=''){
?>

        <tr><td><hr class="hr_alt"/></td>
		<tr><td><?php echo $row_m_1[1]; ?></td>
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