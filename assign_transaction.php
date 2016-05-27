<!DOCTYPE html>
<html>
<head>
<title>Assign transaction</title>
<style>
	h3 {color: #3399FF;}
  .error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all transactions.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SELECT * FROM TRANSACTION WHERE EMPLOYEE_id is not null");

echo "<table width=530 height=35 border=1 cellspacing=1>";
echo "<th width=100 scope=col>transaction id</th> ";
echo "<th width=120 scope=col>transaction date</th> ";
echo "<th width=90 scope=col>total prize</th>";
echo "<th width=90 scope=col>consumer id</th>";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>".$row['number']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "<td>".$row['total_prize']."</td>";
    echo "<td>".$row['CONSUMER_id']."</td>";
    echo "</tr>";
}
// 定义变量并设置为空值
$idErr = $employeeErr = "";
$id = $EMPLOYEE_id = "";
$flag = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["id"])) {
		$idErr = "id is required";
		$flag = 0;
	} else {
		$id = test_input($_POST["id"]);
	}
	if (empty($_POST["employee"])) {
		$employeeErr = "employee id is required";
		$flag = 0;
	} else {
		$employee = test_input($_POST["employee"]);
	}
	if ($flag == 1) {
		exe_query($con, "UPDATE TRANSACTION SET EMPLOYEE_id = '$employee' WHERE number = '$id'");
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

<h3>Update an existing transaction</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	employee id: <input type="number" name="employee">
	<span class="error">* <?php echo $employeeErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing transactions</h3>

</body>
</html>
