<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js" defer></script>
    <title>CST 310 Final Project Home</title>
</head>

<body>

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

    <div class="main_page">
        <h1>Welcome to the Company Portal</h1>       
    </div>

    <div class="flex_side">
        <div>
            <h2>Company News</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel sapien eget nunc efficitur efficitur. Sed at ligula a enim efficitur commodo. Curabitur ac odio id nisl convallis tincidunt. Proin in mi sed nisi efficitur fermentum. Nulla facilisi.</p>
        </div>  
        <div>
            <h2>Employee Resources</h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec vel sapien eget nunc efficitur efficitur. Sed at ligula a enim efficitur commodo. Curabitur ac odio id nisl convallis tincidunt. Proin in mi sed nisi efficitur fermentum. Nulla facilisi.</p>
        </div>
        </div>
        
    
    </body>


    </html>