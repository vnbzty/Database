<!DOCTYPE html>
<html>

<head>
<title>Database</title>
</head>

<body>
<?php
$con = mysql_connect("127.0.0.1", "root", "");
if(! $con )
{
  die('Could not connect: ' . mysql_error());
}
mysql_close($con);
?>

<form action="welcome.php" method="post">
<input type="button" onclick="window.location.href='customer_login.php'" value="I'm a return customer">
<input type="button" onclick="window.location.href='customer_register.php'" value="I'm a new customer">
<input type="button" onclick="window.location.href='employee_login.php'" value="I'm an employee">
<input type="button" onclick="window.location.href='employee_register.php'" value="Employee register">
<input type="button" onclick="window.location.href='department_register.php'" value="Deparment register">
</form>

</body>
</html>
