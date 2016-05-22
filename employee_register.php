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
  
  if (empty($_POST["gender"])) {
    $genderErr = "gender is required";
  } else {
    $gender = test_input($_POST["gender"]);
  }  
	
  $level = test_input($_POST["level"]);
 
  if (empty($_POST["idcard"])) {
    $idcardErr = "idcard is required";
  } else {
    $idcard = test_input($_POST["idcard"]);
  } 
  
  $departmentid = test_input($_POST["departmentid"]);
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
	<span class="error">* <?php echo $genderErr;?></span>
	<br><br>
	level: <input type="number" name="level">
	<br><br>
	ID card number: <input type="text" name="idcard">
	<span class="error">* <?php echo $idcardErr;?></span>
	<br><br>
	department id: <input type="number" name="departmentid">
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
if (!mysql_query("INSERT INTO EMPLOYEE(id, name, password, gender, level, id_card, DEPARTMENT_id) VALUES (NULL, '$name', '$password', '$gender', '$level', '$idcard', '$departmentid')")) {
	die('Error: ' . mysql_error());
}
echo "Registe successfully.";
// present employee's infoes here.
mysql_close($con);
?>
    
</body>
</html>
