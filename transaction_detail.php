<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Transaction Details</title>
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
?>

<form>
	id: <?php echo $customer_id;?>
	<br><br>
	name: <?php echo $customer_name;?>
	<br><br>
</form>
<h3>Transaction Details</h3>

<?php
$number = $_POST["number"];
$result = mysqli_query($con, "SELECT * FROM TRANSACTION_DETAIL WHERE TRANSACTION_number = '$number'");

echo "<table width=600 height=35 border=1 cellspacing=1>";
echo "<th width=100 scope=col>transaction id</th> ";
echo "<th width=100 scope=col>goods id</th>";
echo "<th width=100 scope=col>prize</th>";
echo "<th width=150 scope=col>unit prize</th>";
echo "<th width=150 scope=col>total prize</th>";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>".$row['TRANSACTION_number']."</td>";
    echo "<td>".$row['GOODS_id']."</td>";
    echo "<td>".$row['amount']."</td>";
    echo "<td>".$row['unit_prize']."</td>";
    echo "<td>".$row['total_prize']."</td>";
    echo "</tr>";
}
?>
</body>
</html>
