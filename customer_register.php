<!DOCTYPE html>
<html>
<head>
<title>Registe</title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// 定义变量并设置为空值
$nameErr = $passwordErr =  "";
$name = $gender = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "name is required";
	} else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z1-9_]*$/",$name)) {
			$nameErr = "number, character and _ only"; 
		}
	}
 
	if (empty($_POST["password"])) {
		$passwordErr = "password is required";
	} else {
		$password = test_input($_POST["password"]);
	}
   
  $gender = test_input($_POST["gender"]);
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
   gender: 
   <input type="radio" name="gender" value="w">female
   <input type="radio" name="gender" value="m">male
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
if (!mysql_query("INSERT INTO CONSUMER (id, name, password, gender) VALUES (NULL, '$name', '$password', '$gender')")) {
	die('Error: ' . mysql_error());
}
echo "Registe successfully.";
// preset customer's infoes here.
mysql_close($con);
?>
	
</body>
</html>
