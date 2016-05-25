<!DOCTYPE html>
<html>
<head>
<title>Employee Log In</title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// 定义变量并设置为空值
$nameErr = $passwordErr = "";
$name = $password = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$nameErr = "name is required";
		$flag = 0;
  } else {
    $name = test_input($_POST["name"]);
  }
    
  if (empty($_POST["password"])) {
    $passwordErr = "password is required";
		$flag = 0;
  } else {
    $password = test_input($_POST["password"]);
  }
  if ($flag == 1){
    $con = mysqli_connect("127.0.0.1", "root", "", "mydb");
    $name = $_POST['name'];
    $passowrd = $_POST['password'];
    $result = mysqli_query($con, "SELECT * FROM EMPLOYEE WHERE name = '$name' AND password = '$password'");
    if($row = mysqli_fetch_array($result)){
      $_SESSION['username'] = $name;
      $_SESSION['userid'] = $row['id'];
      echo 'Hi, ',$name,'.<br />', 'Welcome!<br />';
			echo 'Your employee id: ', $row['id'], '<br />';
			echo 'Your gender: ';
			if ($row['gender'] == 'w') {
				echo 'female';
			} else {
				echo 'male';
			}
			echo '<br />';
			echo 'Your level: ', $row['level'], '<br />';
			echo 'Your ID card number: ', $row['id_card'], '<br />';
			echo 'Your department id: ', $row['DEPARTMENT_id'], '<br />';
			echo 'Go <a href="employee_index.php">Employee Centre</a><br />';
      echo 'Click <a href="employee_login.php?action=logout">here</a> to cancel login!<br />';
      exit;
    } else {
			exit('Failed!Click <a href="javascript:history.back(-1);">Back</a> Retry	');
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

</body>
</html>
