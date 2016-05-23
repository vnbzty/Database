
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
    echo $_SESSION["username"];
    if (!isset($_SESSION["username"])){
        echo "<script>alert(\"Please Login First!\");</script>";
        < meta http-equiv="refresh" content="1;url=customer_login.php"> 
    }
    else{
		$con = mysqli_connect("127.0.0.1", "root", "vnbzty", "mydb");
		$name = $_SESSION["username"];
		$query = "SELECT * FROM CONSUMER WHERE name = '$name'";
		$result = mysqli_query($con, $query);
        $row = mysql_fetch_array($result);
        echo '用户信息：<br />';
        echo '用户名：',$name,'<br />';
        echo '<a href="login.php?action=logout">注销</a> 登录<br />';
    }

?>

</body>
</html>
