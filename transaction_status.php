<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Transaction Status</title>
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
<h3>Existing transaction</h3>

<?php
$result = mysqli_query($con, "SELECT * FROM TRANSACTION");

echo "<table width=700 height=35 border=1 cellspacing=1>";
echo "<th width=100 scope=col>transaction id</th> ";
echo "<th width=100 scope=col>date</th>";
echo "<th width=100 scope=col>prize</th>";
echo "<th width=150 scope=col>customer id</th>";
echo "<th width=150 scope=col>employee id</th>";
echo "<th width=100 scope=col>details</th>";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
	echo "<form method=\"post\" action=\"transaction_detail.php\">";
    echo "<tr>";
    echo "<td><input type=\"hidden\" name=\"number\" value=\"".$row['number']."\">".$row['number']."</td>";
    echo "<td>".$row['date']."</td>";
    echo "<td>".$row['total_prize']."</td>";
    echo "<td>".$row['CONSUMER_id']."</td>";
    echo "<td>".$row['EMPLOYEE_id']."</td>";
	echo "<td><input type=\"submit\" name=\"submit".$row['number']."\"value=\"details\"></td>";
    echo "</tr>";
	echo "</form>";
}
?>
</body>
</html>
