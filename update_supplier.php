<!DOCTYPE html>
<html>
<head>
<title>Update supplier</title>
<style>
	h3 {color: #3399FF;}
  .error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all suppliers.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
if ($_SERVER["REQUEST_METHOD"] != "POST") {
?>
<h3>Existing suppliers</h3>
<?php
	$result = mysqli_query($con, "SELECT * FROM SUPPLIER");
	echo "<table width=450 height=35 border=1 cellspacing=1>";
	echo "<th width=150 scope=col>supplier id</th> ";
	echo "<th width=200 scope=col>supplier name</th> ";
	echo "<th width=100 scope=col>address</th> ";
	echo "<th width=200 scope=col>phone number</th>";
	echo "</tr>";
	while ($row = mysqli_fetch_array($result)) {
	    echo "<tr>";
	    echo "<td>".$row['id']."</td>";
	    echo "<td>".$row['name']."</td>";
	    echo "<td>".$row['address']."</td>";
	    echo "<td>".$row['phone_number']."</td>";
	    echo "</tr>";
	}
	echo "</table>";
};
// 定义变量并设置为空值
$name0Err = $name1Err = $addErr = $phoneErr = "";
$id = $name0 = $name1 = $address = $phone_number = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = test_input($_POST["id"]);

  if ($id) { // update
    $name0 = test_input($_POST["name0"]);
    if (!preg_match("/^[a-zA-Z1-9_]*$/",$name0)) {
      $name0Err = "number, character and _ only";
      $flag = 0;
    }
		$address = test_input($_POST["address"]);
		$phone_number = test_input($_POST["phone_number"]);
    if ($flag == 1) {
      if ($name0) {
        $query = "UPDATE SUPPLIER SET name = '$name0' WHERE id = '$id'";
				exe_query($con, $query);
			}
			if ($address) {
				$query = "UPDATE SUPPLIER SET address = '$address' WHERE id = '$id'";
				exe_query($con, $query);
			}
			if ($phone_number) {
				$query = "UPDATE SUPPLIER SET phone_number = '$phone_number' WHERE id = '$id'";
				exe_query($con, $query);
			}
      echo "Update successfully. <br />";
      echo 'Back to <a href="employee_index.php">Employee Centre</a><br />';
      mysqli_close($con);
      exit;
    }
	} else { // insert
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
    if (empty($_POST["address"])) {
      $addErr = "address is required";
      $flag = 0;
    } else {
      $address = test_input($_POST["address"]);
		}
    if (empty($_POST["phone_number"])) {
      $phoneErr = "phone number is required";
      $flag = 0;
    } else {
      $phone_number = test_input($_POST["phone_number"]);
		}
    if ($flag == 1) {
      exe_query($con, "INSERT INTO SUPPLIER(id, name, address, phone_number) VALUES (NULL, '$name1', '$address', '$phone_number')");
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

<h3>Update an existing supplier</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	name: <input type="text" name="name0">
	<span class="error"> <?php echo $name0Err;?></span>
	<br><br>
	address: <input type="text" name="address">
	<br><br>
	phone number: <input type="text" name="phone_number">
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Insert a new supplier</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	name: <input type="text" name="name1">
	<span class="error">* <?php echo $name1Err;?></span>
	<br><br>
	address: <input type="text" name="address">
	<span class="error">* <?php echo $addErr;?></span>
	<br><br>
	phone number: <input type="text" name="phone_number">
	<span class="error">* <?php echo $phoneErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>

</body>
</html>
