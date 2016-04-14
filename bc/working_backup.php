#!/usr/local/bin/php
<?php
$connection = oci_connect($username = 'pagade',
                          $password = 'agadeoracle',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, 'SELECT * FROM GAME ORDER BY ID');
oci_execute($statement);

   
?>
<table>
<tr><td>ID</td><td>Home</td><td>H_Score</td><td>A_Score</td><td>Away</td></tr>
<?php while (($row = oci_fetch_object($statement))) {
?>
<tr><td><?php echo $row->ID . "\n";?>
</td>
<td><?php echo $row->HOMETEAM . "\n"; ?>
</td>
<td><?php echo $row->FTHG . "\n- "; ?>
</td>
<td><?php echo $row->FTAG . "\n"; ?>
</td>
<td><?php echo $row->AWAYTEAM . " <br> \n"; ?>
</td></tr>

<?php

}


oci_free_statement($statement);
oci_close($connection);

?>