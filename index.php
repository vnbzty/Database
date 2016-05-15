<html>
<head>
<title>Connecting MySQL Server</title>
</head>
<body>
<?php
    $conn = mysql_connect("127.0.0.1", "vnb", "vnbzty");
    if(! $conn )
    {
     die('Could not connect: ' . mysql_error());
    }
    echo 'Connected successfully';
    mysql_close($conn);
?>
</body>
</html>
