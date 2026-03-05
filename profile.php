<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

require_once "includes/Database.php";

$db = new Database();
$con = $db->createConnection();

$userId = $_SESSION["user_id"];

$stmt = $con->prepare("SELECT email, password, firstName, lastName, address, phone, salary, SSN
                       FROM tblUser
                       WHERE id = ?");

$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Employee Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

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
    <a href="profile.php">Profile</a>
    <a href="upload.php">Upload</a>
</div>

<!-- Main Profile Content -->
<main class="profile_page">

    <div class="form_wrapper">

        <h1>Employee Profile</h1>

        <div class="profile_info">
            <h1>Employee Profile</h1>

            <p><strong>Email:</strong> <?php echo htmlspecialchars($user["email"]); ?></p>
            <p><strong>Password:</strong> ********</p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($user["firstName"]); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($user["lastName"]); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user["address"]); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user["phone"]); ?></p>
            <p><strong>Salary:</strong> <?php echo htmlspecialchars($user["salary"]); ?></p>
            <p><strong>SSN:</strong> <?php echo htmlspecialchars($user["SSN"]); ?></p>

            

        <div class="profile_actions">
            <a class="button_primary" href="logout.php">Logout</a>
        </div>

    </div>

</main>

</body>
</html>