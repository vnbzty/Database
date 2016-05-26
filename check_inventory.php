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
$con = mysqli_connect("127.0.0.1", "root", "vnbzty", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
// 定义变量并设置为空值
$idErr  = $amountErr = "";
$id = $name = $amount = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["id"])) {
	    $idErr = "id is required";
	    $flag = 0;
    } else {
      	$id = test_input($_POST["id"]);
	}
	if (empty($_POST["amount"])) {
	    $amountErr = "amount is required";
	    $flag = 0;
    } else {
      	$amount = test_input($_POST["amount"]);
	}

    if ($flag == 1) {
		$query = "SELECT * FROM GOODS WHERE id = '$id'";
		$result = mysqli_query($con, $query);
		if($row = mysqli_fetch_array($result)){
			$real_amount = $row['amount'];
			if ($amount > $real_amount){
				echo "<script>alert(\"Transaction Details Incorrect. Please try again.\");</script>";
			}
			else{
				$prize = $row['prize'];
				$total_prize = $amount * $prize;
				$transaction = "INSERT INTO TRANSACTION (number, date, total_prize, CONSUMER_id, EMPLOYEE_id) VALUES (NULL, NOW(), $total_prize, $customer_id, 2);";
				exe_query($con,$transaction);

				$new_amount = $real_amount - $amount;
				$inventory = "UPDATE GOODS SET amount = '$new_amount' WHERE id = '$id'";
				exe_query($con,$inventory);
				// $transaction_detail = "INSERT INTO TRANSACTION_DETAIL (amount, unit_prize, total_prize, TRANSACTION_number, GOODS_id) VALUES ($amount, $prize, $total_price,$,$number)";
				// exe_query($con,$transaction_detail);

				echo "Submit successfully. <br />";
		    	echo 'Click <a href="customer_index.php">here</a> back to Customer Centre.<br />';
		    	exit;
			}
		} else {
			echo "<script>alert(\"Transaction Details Incorrect. Please try again.\");</script>";
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

<h3>Buy goods</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="text" name="id">
	<span class="error">* <?php echo $idErr;?></span>
	<br><br>
	amount: <input type="number" name="amount">
	<span class="error">* <?php echo $amountErr;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing items</h3>

<?php
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
?>
</body>
</html>
