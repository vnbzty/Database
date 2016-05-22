<!DOCTYPE html>
<html>
<head>
<title>Log in</title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// 定义变量并设置为空值
$nameErr = $passwordErr = $genderErr = $levelErr = $idcardErr = $departmentidErr = "";
$name = $password = $gender = $level = $idcard = $departmentid = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "name is required";
  } else {
    $name = test_input($_POST["name"]);
  }
    
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";
  } else {
    $password = test_input($_POST["password"]);
  }  
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	name: <input type="text" name="name">
	<span class="error">* <?php echo $nameErr;?></span>
	<br><br>
	password: <input type="password" name="password">
	<span class="error">* <?php echo $passwordErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>

<?php
$con = mysql_connect("127.0.0.1", "root", "");
if(! $con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("mydb", $con);
$result = mysql_query("SELECT * FROM EMPLOYEE WHERE name = '$name'");
if (! $result) {
	die('Error: ' . mysql_error());
}

$row = mysql_fetch_array($result);
if (! ($row['password'] == $password)) {
	echo "Wrong password.";
} else {
	echo "Log in successfully.";
}
mysql_close($con);
?>
    
</body>
</html>
