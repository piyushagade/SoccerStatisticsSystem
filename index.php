<?php
	session_start();
	session_destroy();
	$_SESSION['authorized'] = 0;


    $conn=oci_connect('pagade','agadeoracle','oracle.cise.ufl.edu:1521/orcl');

?>

<html>
<head>
<meta charset="utf-8">
<title>Soccer Statistics System</title>
<link rel="stylesheet" type="text/css" href="css/style.css">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.js" type="text/javascript"></script>

</head>
<body>
<div id="background-image" class="background-image"></div>

<!-- Login Container -->
<div id="login_container" class="login_container">
<h1>Soccer Statistics System</h1>
<h2>Sign In</h2>
<div id="form">
    <!--Login Form-->
    <div id="ui_device_form">
    <form id="signin_form" action="member_area.php" method="post">
    <font face="cf1" size="2px" class="input_label">Username</font>
    <center>
	<input class="input_default" placeholder="john_doe" name="username" id="username" required/><br>
    </center>
    
    <font face="cf1" size="2px" class="input_label">Password</font>
    <center>
	<input class="input_default" placeholder="********" id="password" type="password" name="password" required/><br>
    </center>
    
    <center>
    <font face="cf1" size="2px" class="input_label"><a id="registration">Not registerd? Sign up!</a></font>
    </center>
    
    <div class="login_buttons">
    <center>
  	<button class="button button-block" name="signin" id="signin" type="submit" onClick="validate()">Sign In</button>
    </center>
    </div>
    </form>
	</div>
	</div>
</div>



<!-- Register Container -->
<div id="register_container" class="register_container hidden">
<h1>Soccer Statistics System</h1>
<h2>Register</h2>
<div id="register_div">
    <!--Register Form-->
    <form id="register_form" method="post" action="register.php">
    <div id="ui_register_form">
    <font face="cf1" size="2px" class="input_label">Username</font>
    <center>
	<input class="input_default" placeholder="john_doe" name="username" required/><br>
    </center>
    
    <font face="cf1" size="2px" class="input_label">Password</font>
    <center>
	<input class="input_default" placeholder="********" name="password" type="password" required/><br>
    </center>
    
    <font face="cf1" size="2px" class="input_label">Name</font>
    <center>
	<input class="input_default" placeholder="John Doe" name="name" type="text" required/><br>
    </center>

    <font face="cf1" size="2px" class="input_label">Fav team</font>
    <center>

    <!-- Dropdown Menu -->
        <?php
         	$query_teams = "SELECT ID, LEAGUE FROM TEAM";
    		$teams = oci_parse($conn, $query_teams);
    		oci_execute($teams);
    	?>

        <Select class="dropdown" id="team" name="team">
        <?php
    	$selected_league = '';
    	while(($row_teams = oci_fetch_array($teams, OCI_BOTH)) != false){
    		$num_rows_teams = oci_num_rows($teams);
    		if($row_teams[0] !=''){
    			echo '<option value="'.$row_teams[0].'">'.$row_teams[0].'</option>';
    		}
    	}
    	?>

     	</Select><br>
    </center>
    
    <center>
    <font face="cf1" size="2px" class="input_label"><a id="login">Already a member? Sign in!</a></font>
    </center>
    
    <div class="register_buttons">
    <center>
  	<button class="button button-block" id="register" type="submit">Register</button>
    </center>
    </div>
	</div>
    </form>
	</div>
</div>
 
<script type="text/javascript" src="js/scripts.js" ></script>

</body>
</html>
<?php

?>