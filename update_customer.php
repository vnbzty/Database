<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Update customer</title>
<style>
	h3 {color: #3399FF;}
	.error {color: #FF0000;}
</style>
</head>

<body>
<?php
$name = $_SESSION["username"];
$id = $_SESSION["userid"];

$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
// 定义变量并设置为空值
$password = $gender = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$password = test_input($_POST["password"]);
	$gender = test_input($_POST["gender"]);

	if ($flag == 1) {
		if ($password) {
			$query = "UPDATE CONSUMER SET password = '$password' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($gender) {
			$query = "UPDATE CONSUMER SET gender = '$gender' WHERE id = '$id'";
			exe_query($con, $query);
		}
		echo "Update successfully. <br />";
		echo 'Back to <a href="customer_index.php">Customer Centre</a><br />';
		mysqli_close($con);
		exit;
	}
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function exe_query($con, $query) {
	if (!mysqli_query($con, $query)) {
		die('Error: ' . mysqli_error($con));
	}
}
?>

<h3>Update my info</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <?php echo $id;?>
	<br><br>
	name: <?php echo $name;?>
	<br><br>
	password: <input type="password" name="password">
	<br><br>
	gender:
	<input type="radio" name="gender" value="w">female
	<input type="radio" name="gender" value="m">male
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>

</body>
</html>
