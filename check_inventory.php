<?php
session_start();
?>
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
$customer_name = $_SESSION["username"];
$customer_id = $_SESSION["userid"];
// list all goods.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}

// 定义变量并设置为空值
$flag = 1;
$total_prize = 0;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$result = mysqli_query($con, "SELECT * FROM GOODS");
	while ($row = mysqli_fetch_array($result)) {
		$name = "item".$row['id'];
		if (empty($_POST[$name])) {
		    $amount = 0;
	    } else {
	      	$amount = test_input($_POST[$name]);
		}
		$real_amount = $row['amount'];
		if ($amount > $real_amount){
			$flag = 0;
		}
		$prize = $row['prize'];
		$total_prize = $total_prize + $amount * $prize;
	}

    if ($flag == 1) {
		$transaction = "INSERT INTO TRANSACTION (number, date, total_prize, CONSUMER_id, EMPLOYEE_id) VALUES (NULL, NOW(), $total_prize, $customer_id, 2);";
		exe_query($con,$transaction);
		$result = mysqli_query($con, "SELECT * FROM GOODS");
		while($row = mysqli_fetch_array($result)){
			$name = "item".$row['id'];
			if (empty($_POST[$name])) {
			    $amount = 0;
		    } else {
		      	$amount = test_input($_POST[$name]);
			}
			if ($amount > 0){
				$real_amount = $row['amount'];
				$new_amount = $real_amount - $amount;

				$id = $row['id'];
				$inventory = "UPDATE GOODS SET amount = '$new_amount' WHERE id = '$id'";
				exe_query($con,$inventory);

				$prize = $row['prize'];
				$temp_result = mysqli_query($con, "SELECT * FROM TRANSACTION WHERE number = (SELECT max(number) FROM TRANSACTION)");
				$temp_row = mysqli_fetch_array($temp_result);
				$number = $temp_row['number'];

				$transaction_detail = "INSERT INTO TRANSACTION_DETAIL (amount, unit_prize, total_prize, TRANSACTION_number, GOODS_id) VALUES ($amount, $prize, $amount*$prize,$number,$id)";
				exe_query($con,$transaction_detail);
			}
		}
		echo "Submit successfully. <br />";
		echo 'Click <a href="customer_index.php">here</a> back to Customer Centre.<br />';
		exit;
	}
	else{
		echo "<script>alert(\"Transaction Details Incorrect. Please try again.\");</script>";
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

<h3>Buy goods</h3>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<?php

	echo "<table width=700 height=35 border=1 cellspacing=1>";
	echo "<th width=200 scope=col>item id</th> ";
	echo "<th width=200 scope=col>item name</th> ";
	echo "<th width=100 scope=col>prize</th>";
	echo "<th width=100 scope=col>amount</th>";
	echo "<th width=200 scope=col>employee id</th>";
	echo "<th width=200 scope=col>catagory id</th>";
	echo "<th width=200 scope=col>supplier id</th>";
	echo "<th width=100 scope=col>purchase</th>";
	echo "</tr>";
	$result = mysqli_query($con, "SELECT * FROM GOODS");
	while ($row = mysqli_fetch_array($result)) {
	    echo "<tr>";
	    echo "<td>".$row['id']."</td>";
	    echo "<td>".$row['name']."</td>";
	    echo "<td>".$row['prize']."</td>";
	    echo "<td>".$row['amount']."</td>";
	    echo "<td>".$row['EMPLOYEE_id']."</td>";
	    echo "<td>".$row['CATAGORY_id']."</td>";
	    echo "<td>".$row['SUPPLIER_id']."</td>";
		echo "<td><input type=\"number\" name=\"item".$row['id']."\"></td>";
	    echo "</tr>";
	}
	echo "</table>"
?>

	<input type="submit" name="submit" value="submit">
</form>

</body>
</html>
