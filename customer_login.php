<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Log in</title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>


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
// 定义变量并设置为空值
$nameErr = $genderErr = $passwordErr =  "";
$name = $password = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if (empty($_POST["name"])){
		$nameErr = "Name is required";
		$flag = 0;
	}
	else{
		$name = test_input($_POST["name"]);
	}

	if (empty($_POST["password"])){
		$passwordErr = "Password is required";
		$flag = 0;
	}
	else{
		$password = test_input($_POST["password"]);
	}
	if ($flag == 1){
		$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
		$name = $_POST['name'];
		$passowrd = $_POST['password'];
		$query = "SELECT * FROM CONSUMER WHERE name = '$name' and password = '$password'";
		$result = mysqli_query($con, $query);
		if($info = mysqli_fetch_array($result)){
			$_SESSION["username"] = $name;
			echo "<script language=\"javascript\">";
			echo "document.location=\"customer.php\"";
			echo "</script>";
		} else {
			echo "<script>alert(\"Login Details Incorrect. Please try again.\");</script>";
		}
	}
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
?>

</body>
</html>
