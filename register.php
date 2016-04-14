<?php
// Start the session
session_start();

$username = $_POST['username'];
$password = $_POST['password'];
$team = $_POST['team'];
$name = $_POST['name'];

$conn=oci_connect('pagade','agadeoracle','oracle.cise.ufl.edu:1521/orcl');
if($conn){

}
	
else
{
    $err = oci_error();
	trigger_error(htmlentities($err['message'], ENT_QUOTES), E_USER_ERROR);
}

	$query = "SELECT name FROM USERS WHERE username = '$username'";
	$stid = oci_parse($conn, $query);
	oci_execute($stid);

	$row = oci_fetch_array($stid, OCI_BOTH);
	
	if($row !== false){
  		echo "Username exists";
	}
	else{
		$admin = 0;
		$premium = 0;

		//Update PrevVisit Entry
		$query_prevvisit = "SELECT CURRENT_TIMESTAMP  FROM DUAL";
		$stid_prevvisit = oci_parse($conn, $query_prevvisit);
		oci_execute($stid_prevvisit);

		$row_prevvisit = oci_fetch_array($stid_prevvisit, OCI_BOTH);
		if($row_prevvisit != false){
          		$prevvisit = $row_prevvisit[0];
        }

		$query = "INSERT INTO USERS VALUES ('$username', '$password', '$name', 'admin', '$premium', '$team', (SELECT TO_TIMESTAMP('9999/01/01 00:00:00', 'YYYY/MM/DD HH24:MI:SS') FROM dual))";
		$stid = oci_parse($conn, $query);
		oci_execute($stid);
		
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;

		;


	}
?>

<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js" type="text/javascript"></script>

</head>
<body>
<div class="background-image"></div>


<div id="login_container" class="login_container">
<h1>Soccer Statistics System</h1>
<div id="form">
    <div id="ui_device_form">
      <center>
        <br> 
        <font face="cf1" color="#FFFFFF" size="16px">Signup Successful</font><br> 
        </center><center>
    </center>
    
    <div class="login_buttons">
    <center> <a href="member_area.php">
  	<button class="button button-block">My Account</button>
    
    </center>
    </div>
	</div>
	</div>
</div>


</body>
</html>