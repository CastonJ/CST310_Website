<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>

    <!-- Top Navigation Bar -->
<div class="topnav">
    <a href="javascript:void(0);" class="icon" onclick="openNav()">&#9776;</a>
    <a class="active" href="index.php">Home</a>

    <?php if (!isset($_SESSION["user_id"])): ?>
        <a href="login.php">Login</a>
        <a href="registration.php">Register</a>
    <?php else: ?>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    <?php endif; ?>

    <a href="upload.php">Upload</a>
    <a href="#contact">Contact</a>
</div>



    <!-- Side Navigation Bar -->
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a class="active" href="index.php">Home</a>
        <a href="login.php">Login</a>
        <a href="registration.php">Register</a>
        <a>Future Use!</a>

    </div>






<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION["first_name"] ?? "Employee"); ?>!</h1>
    <p>You are logged in as <?php echo htmlspecialchars($_SESSION["user_email"] ?? ""); ?></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>