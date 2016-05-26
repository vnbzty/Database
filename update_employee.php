<!DOCTYPE html>
<html>
<head>
<title>Update employee</title>
<style>
	h3 {color: #3399FF;}
	.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all employees.
$con = mysqli_connect("127.0.0.1", "root", "vnbzty", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SELECT * FROM EMPLOYEE");

echo "<table width=800 height=50 border=1 cellspacing=1>";
echo "<th width=200 scope=col>employee id</th> ";
echo "<th width=270 scope=col>employee name</th> ";
echo "<th width=100 scope=col>gender</th>";
echo "<th width=100 scope=col>level</th>";
echo "<th width=200 scope=col>ID card number</th>";
echo "<th width=270 scope=col>department id</th>";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
		if ($row['gender'] == 'w') {
			echo "<td>".'female'."</td>";
		} else {
			echo "<td>".'male'."</td>";
		}
    echo "<td>".$row['level']."</td>";
    echo "<td>".$row['id_card']."</td>";
    echo "<td>".$row['DEPARTMENT_id']."</td>";
    echo "</tr>";
}
// 定义变量并设置为空值
$idErr = $nameErr = "";
$id = $name = $password = $gender = $level = $idcard = $departmentid = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["id"])) {
		$idErr = "id is required";
    $flag = 0;
  } else {
    $id = test_input($_POST["id"]);
	}
	$name = test_input($_POST["name"]);
	if (!preg_match("/^[a-zA-Z1-9_]*$/",$name)) {
		$nameErr = "number, character and _ only";
		$flag = 0;
	}
	$password = test_input($_POST["password"]);
	$gender = test_input($_POST["gender"]);
  $level = test_input($_POST["level"]);
  $idcard = test_input($_POST["idcard"]);
  $departmentid = test_input($_POST["departmentid"]);

	if ($flag == 1) {
		if ($name) {
			$query = "UPDATE EMPLOYEE SET name = '$name' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($password) {
			$query = "UPDATE EMPLOYEE SET password = '$password' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($gender) {
			$query = "UPDATE EMPLOYEE SET gender = '$gender' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($level) {
			$query = "UPDATE EMPLOYEE SET level = '$level' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($idcard) {
			$query = "UPDATE EMPLOYEE SET id_card = '$idcard' WHERE id = '$id'";
			exe_query($con, $query);
		}
		if ($departmentid) {
			$query = "UPDATE EMPLOYEE SET DEPARTMENT_id = '$departmentid' WHERE id = '$id'";
			exe_query($con, $query);
		}
		echo "Update successfully. <br />";
		echo 'Back to <a href="employee_index.php">Employee Centre</a><br />';
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

<h3>Update an existing employee</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	name: <input type="text" name="name">
	<span class="error"> <?php echo $nameErr;?></span>
	<br><br>
	password: <input type="password" name="password">
	<br><br>
	gender:
	<input type="radio" name="gender" value="w">female
	<input type="radio" name="gender" value="m">male
	<br><br>
	level: <input type="number" name="level">
	<br><br>
	ID card number: <input type="text" name="idcard">
	<br><br>
	department id: <input type="number" name="departmentid">
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing employees</h3>

</body>
</html>
