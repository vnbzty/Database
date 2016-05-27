<!DOCTYPE html>
<html>
<head>
<title>Update department</title>
<style>
	h3 {color: #3399FF;}
	.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all departments.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
	die('Could not connect: ' . mysqli_error($con));
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
?>
<h3>Existing departments</h3>
<?php
	$result = mysqli_query($con, "SELECT * FROM DEPARTMENT");
	echo "<table width=430 height=35 border=1 cellspacing=1>";
	echo "<th width=100 scope=col>department id</th> ";
	echo "<th width=120 scope=col>department name</th> ";
	echo "<th width=90 scope=col>manager id</th>";
	echo "</tr>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<tr>";
		echo "<td>".$row['id']."</td>";
		echo "<td>".$row['name']."</td>";
		echo "<td>".$row['EMPLOYEE_id']."</td>";
		echo "</tr>";
	}
	echo "</table>";
}
// 定义变量并设置为空值
$name0Err = $name1Err=  "";
$id = $name0 = $name1 = $manager = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$id = test_input($_POST["id"]);
  $manager = test_input($_POST["manager"]);

	if ($id) {
		$name0 = test_input($_POST["name0"]);
		if (!preg_match("/^[a-zA-Z1-9_]*$/",$name0)) {
			$name0Err = "number, character and _ only";
			$flag = 0;
		}
		if ($flag == 1) {
			if ($name0) {
				$query = "UPDATE DEPARTMENT SET name = '$name0' WHERE id = '$id'";
				exe_query($con, $query);
			}
			if ($manager) {
				$query = "UPDATE DEPARTMENT SET EMPLOYEE_id = '$manager' WHERE id = '$id'";
				exe_query($con, $query);
			}
			echo "Update successfully. <br />";
			echo 'Back to <a href="employee_index.php">Employee Centre</a><br />';
			mysqli_close($con);
			exit;
		}
	} else {
		if (empty($_POST["name1"])) {
			$name1Err = "name is required";
			$flag = 0;
		} else {
			$name1 = test_input($_POST["name1"]);
			if (!preg_match("/^[a-zA-Z1-9_]*$/",$name1)) {
				$name1Err = "number, character and _ only";
				$flag = 0;
			}
		}
		if ($flag == 1) {
			if (! $manager) {
				$query = "INSERT INTO DEPARTMENT(id, name) VALUES (NULL, '$name1')";
			} else {
				$query = "INSERT INTO DEPARTMENT(id, name, EMPLOYEE_id) VALUES (NULL, '$name1', '$manager')";
			}
			exe_query($con, $query);
			echo "Insert successfully. <br />";
			echo 'Back to <a href="employee_index.php">Employee Centre</a><br />';
			mysqli_close($con);
			exit;
		}
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

<h3>Update an existing department</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	name: <input type="text" name="name0">
	<span class="error"> <?php echo $name0Err;?></span>
	<br><br>
	manager id: <input type="number" name="manager">
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Insert a new department</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	name: <input type="text" name="name1">
	<span class="error">* <?php echo $name1Err;?></span>
	<br><br>
	manager id: <input type="number" name="manager">
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>

</body>
</html>
