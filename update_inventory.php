<!DOCTYPE html>
<html>
<head>
<title>Update inventory</title>
<style>
	h3 {color: #3399FF;}
  .error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all goods.
$con = mysqli_connect("127.0.0.1", "root", "vnbzty", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SELECT * FROM GOODS");

echo "<table width=700 height=35 border=1 cellspacing=1>";
echo "<th width=100 scope=col>item id</th> ";
echo "<th width=150 scope=col>item name</th> ";
echo "<th width=100 scope=col>prize</th>";
echo "<th width=100 scope=col>amount</th>";
echo "<th width=150 scope=col>employee id</th>";
echo "<th width=150 scope=col>catagory id</th>";
echo "<th width=150 scope=col>supplier id</th>";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "<td>".$row['prize']."</td>";
    echo "<td>".$row['amount']."</td>";
    echo "<td>".$row['EMPLOYEE_id']."</td>";
    echo "<td>".$row['CATAGORY_id']."</td>";
    echo "<td>".$row['SUPPLIER_id']."</td>";
    echo "</tr>";
}
// 定义变量并设置为空值
$name0Err = $name1Err= $prizeErr = $amountErr = $employeeErr = $cataErr = $supErr = "";
$id = $name0 = $name1 = $prize = $amount = $employee = $catagory = $supplier = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = test_input($_POST["id"]);

  if ($id) { // update
    $name0 = test_input($_POST["name0"]);
    if (!preg_match("/^[a-zA-Z1-9_]*$/", $name0)) {
      $name0Err = "Only numbers, leters and _ allowed";
      $flag = 0;
    }
    if ($flag == 1) {
      if ($name0) {
        $query = "UPDATE GOODS SET name = '$name0' WHERE id = '$id'";
        exe_query($con, $query);
      }
      if ($prize) {
        $query = "UPDATE GOODS SET prize = '$prize' WHERE id = '$id'";
        exe_query($con, $query);
      }
      if ($amount) {
				$query = "SELECT * FROM GOODS WHERE id = '$id'";
				$result = mysqli_query($con, "SELECT * FROM GOODS WHERE id = '$id'");
				$row = mysqli_fetch_array($result);
				$amount = $amount + $row['amount'];
        $query = "UPDATE GOODS SET amount = '$amount' WHERE id = '$id'";
        exe_query($con, $query);
      }
      if ($employee) {
        $query = "UPDATE GOODS SET EMPLOYEE_id = '$employee' WHERE id = '$id'";
        exe_query($con, $query);
      }
      if ($catagory) {
        $query = "UPDATE GOODS SET CATAGORY_id = '$catagory' WHERE id = '$id'";
        exe_query($con, $query);
      }
      if ($supplier) {
        $query = "UPDATE GOODS SET SUPPLIER_id = '$supplier' WHERE id = '$id'";
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
    if (empty($_POST["prize"])) {
      $prizeErr = "prize is required";
      $flag = 0;
    } else {
      $prize = test_input($_POST["prize"]);
		}
    if (empty($_POST["amount"])) {
      $amountErr = "amount is required";
      $flag = 0;
    } else {
      $amount = test_input($_POST["amount"]);
		}
    if (empty($_POST["employee"])) {
      $employeeErr = "employee is required";
      $flag = 0;
    } else {
      $employee = test_input($_POST["employee"]);
		}
    if (empty($_POST["catagory"])) {
      $cataErr = "catagory is required";
      $flag = 0;
    } else {
      $catagory = test_input($_POST["catagory"]);
		}
    if (empty($_POST["supplier"])) {
      $supErr = "supplier is required";
      $flag = 0;
    } else {
      $supplier = test_input($_POST["supplier"]);
		}
    if ($flag == 1) {
      $query = "INSERT INTO GOODS(id, name, prize, amount, EMPLOYEE_id, CATAGORY_id, SUPPLIER_id) VALUES (NULL, '$name1', '$prize', '$amount', '$employee', '$catagory', '$supplier')";
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

<h3>Update an existing item</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	name: <input type="text" name="name0">
	<span class="error"> <?php echo $name0Err;?></span>
	<br><br>
	prize: <input type="number" name="prize">
	<br><br>
	amount: <input type="number" name="amount">
	<br><br>
	employee id: <input type="number" name="employee">
	<br><br>
	catagory id: <input type="number" name="catagory">
	<br><br>
	supplier id: <input type="number" name="supplier">
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Insert a new item</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	name: <input type="text" name="name1">
	<span class="error">* <?php echo $name1Err;?></span>
	<br><br>
	prize: <input type="number" name="prize">
	<span class="error">* <?php echo $prizeErr;?></span>
	<br><br>
	amount: <input type="number" name="amount">
	<span class="error">* <?php echo $amountErr;?></span>
	<br><br>
	employee id: <input type="number" name="employee">
	<span class="error">* <?php echo $employeeErr;?></span>
	<br><br>
	catagory id: <input type="number" name="catagory">
	<span class="error">* <?php echo $cataErr;?></span>
	<br><br>
	supplier id: <input type="number" name="supplier">
	<span class="error">* <?php echo $supErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing items</h3>

</body>
</html>
