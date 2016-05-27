<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Log in</title>
<style>
.error {color: #FF0000;}
</style>
</head>

<body>

<?php
    if (!isset($_SESSION["username"])){
        echo "<script>alert(\"Please Login First!\");</script>";
        echo "<meta http-equiv=\"refresh\" content=\"0;url=customer_login.php\">";
    }
    else{
		$con = mysqli_connect("127.0.0.1", "root", "", "mydb");
		$name = $_SESSION["username"];
        echo $name;
		$query = "SELECT * FROM CONSUMER WHERE name = '$name'";
		$result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);

        $goods = mysqli_query($con,"SELECT * FROM CATAGORY ");
        $goodsnum = mysqli_num_rows($goods);
        for($i = 0;$i < $goodsnum;$i++){

        }
        echo 'Info:<br />';
        echo 'Username:',$name,'<br />';
        echo 'Password:',$row['password'],'<br/>';
        echo '<a href="customer_login.php?action=logout">Logout</a><br/>';

    }

?>

</body>
</html>
