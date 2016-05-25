<!DOCTYPE html>
<html>
<head>
<title>Update catagory</title>
<style>
	h3 {color: #3399FF;}
	.error {color: #FF0000;}
</style>
</head>

<body>
<?php
// list all catagories.
$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
if (! $con) {
    die('Could not connect: ' . mysqli_error($con));
}
$result = mysqli_query($con, "SELECT * FROM CATAGORY");

echo "<table width=300 height=70 border=1 cellspacing=1>";
echo "<th width=100 scope=col>catagory id</th> ";
echo "<th width=100 scope=col>catagory name</th> ";
echo "</tr>";
while ($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['name']."</td>";
    echo "</tr>";
}
// 定义变量并设置为空值
$name0Err = $name1Err=  "";
$id = $name0 = $name1 = "";
$flag = 1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = test_input($_POST["id"]);
  
  if ($id) {
    $name0 = test_input($_POST["name0"]);
    if (!preg_match("/^[a-zA-Z1-9_]*$/",$name0)) {
      $name0Err = "number, character and _ only";
      $flag = 0;
    }
    if ($flag == 1) {
      if ($name0) {
        $query = "UPDATE CATAGORY SET name = '$name0' WHERE id = '$id'";
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
      $query = "INSERT INTO CATAGORY(id, name) VALUES (NULL, '$name1')";
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

<h3>Update an existing catagory</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	id: <input type="number" name="id">
	<br><br>
	name: <input type="text" name="name0">
	<span class="error"> <?php echo $name0Err;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Insert a new catagory</h3>
<p><span class="error">* required</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	name: <input type="text" name="name1">
	<span class="error">* <?php echo $name1Err;?></span>
	<br><br>
	<input type="submit" name="submit" value="submit">
</form>
<h3>Existing catagories</h3>

</body>
</html>
