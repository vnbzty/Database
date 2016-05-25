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
// list all memberships.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SELECT * FROM CONSUMER");
// WHERE id not in (SELECT id FROM MEMBERSHIP)");

echo "<table width=550 height=70 border=1 cellspacing=1>";
echo "<th width=80 scope=col>customer id</th> ";
echo "<th width=100 scope=col>customer name</th> ";
echo "<th width=30 scope=col>gender</th>";
echo "<th width=100 scope=col>membership id</th>";
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
    echo "<td>".$row['MEMBERSHIP_id']."</td>";
    echo "</tr>";
}

// 定义变量并设置为空值
$id = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["id"])) {
		$idErr = "id is required";
    $flag = 0;
  } else {
    $id = test_input($_POST["id"]);
  }
  if ($flag == 1) {
    $result = mysqli_query($con, "SELECT * FROM CONSUMER WHERE id = '$id'");
		$row = mysqli_fetch_array($result);
		if ($row['MEMBERSHIP_id']) {
			echo 'This customer is alreay our member.';
		} else {
			if (!mysqli_query($con, "INSERT INTO MEMBERSHIP(id, total_cost) VALUES (NULL, '0')")) {
				die('Error: ' . mysqli_error($con));
			}
			$result = mysqli_query($con, "SELECT * FROM MEMBERSHIP WHERE id = (SELECT max(id) FROM MEMBERSHIP)");
			$row = mysqli_fetch_array($result);
			$membershipid = $row['id'];
			if (!mysqli_query($con, "UPDATE CONSUMER SET MEMBERSHIP_id = '$membershipid' WHERE id = '$id'")) {
				die('Error: ' . mysqli_error($con));
			}
			echo "Update successfully. <br />";
      echo 'Back to <a href="employee_index.php">Employee Centre</a><br />';
    }
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

function update($con, $query) {
    if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
    }
}
?>

<h3>Update an existing customer</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing departments</h3>

</body>
</html>
