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
		$con = mysqli_connect("127.0.0.1", "root", "vnbzty", "mydb");
		$name = $_SESSION["username"];
		$query = "SELECT * FROM CONSUMER WHERE name = '$name'";
		$result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        echo 'Info:<br />';
        echo 'Username:',$name,'<br />';
        echo 'Password:',$row['password'],'<br/>';
        echo '<a href="login.php?action=logout">zhuxiao</a>denglu<br/>';
    }

?>

</body>
</html>
