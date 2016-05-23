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
$nameErr = $genderErr = $passwordErr =  "";
$name = $password = "";

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
	<input type="button" onclick="window.location.href='customer_login_check.php?name=$name'" value="submit">
</form>

<?php
/*
$con = mysql_connect("127.0.0.1", "root", "");
if(! $con)
{
    die('Could not connect: ' . mysql_error());
}
mysql_select_db("mydb", $con);
$result = mysql_query("SELECT * FROM CONSUMER WHERE name = '$name'");
if (! $result) {
	die('Error: ' . mysql_error());
}

$row = mysql_fetch_array($result);
if (! ($row['password'] == $password)) {
	echo "Wrong password.";
} else {
	echo "Log in successfully.";
	if ($row['MEMBERSHIP_id'] == null) {
		echo 'You are not our member yet.';
	} else {
		echo 'You are already our member.';
	}
}
mysql_close($con);
*/
/*
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
$query = "SELECT password FROM CONSUMER WHERE name = '$name'";
$result = mysqli_query($con, $query);
$row = mysqli_fetch_array($result);
echo $row['password'];
echo "<br>";
echo $row['id'];
echo "<br>";
mysqli_close($con);
*/
?>
    
</body>
</html>
