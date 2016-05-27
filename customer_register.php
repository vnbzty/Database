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
$flag = 1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "name is required";
		$flag = 0;
	} else {
		$name = test_input($_POST["name"]);
		if (!preg_match("/^[a-zA-Z1-9_]*$/",$name)) {
			$nameErr = "number, character and _ only";
			$flag = 0;
		}
	}

	if (empty($_POST["password"])) {
		$passwordErr = "password is required";
		$flag = 0;
	} else {
		$password = test_input($_POST["password"]);
	}
	$gender = test_input($_POST["gender"]);

	if ($flag == 1){
		$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
		if(! $con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		if (!mysqli_query($con,"INSERT INTO CONSUMER (id, name, password, gender) VALUES (NULL, '$name', '$password', '$gender')")) {
			die('Error: ' . mysqli_error($con));
		}
        echo "Register successfully. <br />";
    		echo 'Click <a href="index.php">here</a> back to home page.<br />';
        mysqli_close($con);
    		exit;
		// preset customer's infoes here.

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
   gender:
   <input type="radio" name="gender" value="w">female
   <input type="radio" name="gender" value="m">male
   <br><br>
   <input type="submit" name="submit" value="submit">
</form>
</body>
</html>
