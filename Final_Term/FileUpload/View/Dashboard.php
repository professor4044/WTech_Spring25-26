<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: ../View/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <?php echo "Hello " . htmlspecialchars($_SESSION['name']) . ", welcome to dashboard."; ?><br>
    <a href="../Controller/logout.php">Logout</a><br>
    
</body>
</html>