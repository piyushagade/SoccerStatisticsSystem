$connection = oci_connect($username = 'pagade',
                          $password = 'agadeoracle',
                          $connection_string = '//oracle.cise.ufl.edu/orcl');
$statement = oci_parse($connection, 'SELECT * FROM USERS WHERE username =' $username ' AND password =' $password 'ORDER BY ID');
oci_execute($statement);

