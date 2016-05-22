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
$nameErr =  "";
$name = $manager = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "name is required";
	} else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z1-9_]*$/",$name)) {
			$nameErr = "number, character and _ only"; 
		}
	}
 
	$manager = test_input($_POST["manager"]);
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
   manager: <input type="number" name="manager">
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
if (!mysql_query("INSERT INTO DEPARTMENT (id, name, EMPLOYEE_id) VALUES (NULL, '$name', '$manager')")) {
	die('Error: ' . mysql_error());
}
echo "Registe successfully.";
// present department's infoes here.
mysql_close($con);
?>
	
</body>
</html>
