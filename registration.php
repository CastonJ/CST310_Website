<?php
require_once __DIR__ . "/includes/Database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect form values safely
    $email     = trim($_POST["email"] ?? "");
    $password  = $_POST["password"] ?? "";
    $firstName = trim($_POST["firstName"] ?? "");
    $lastName  = trim($_POST["lastName"] ?? "");
    $address   = trim($_POST["address"] ?? "");
    $phone     = trim($_POST["phone"] ?? "");
    $salary    = trim($_POST["salary"] ?? "");
    $ssn       = trim($_POST["ssn"] ?? "");

    // Basic validation (minimum required fields)
    if ($email === "" || $password === "" || $firstName === "" || $lastName === "") {
        $message = "Please fill out Email, Password, First Name, and Last Name.";
    } else {
        // Hash password for storage
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        // Create DB connection
        $db  = new Database();
        $con = $db->createConnection();

        // NOTE: For Week 2 this is okay, but prepared statements are safer.
        // Escape strings to reduce SQL issues
        $emailEsc     = $con->real_escape_string($email);
        $passEsc      = $con->real_escape_string($passwordHash);
        $firstEsc     = $con->real_escape_string($firstName);
        $lastEsc      = $con->real_escape_string($lastName);
        $addressEsc   = $con->real_escape_string($address);
        $phoneEsc     = $con->real_escape_string($phone);
        $salaryValue  = ($salary === "") ? "NULL" : (float)$salary; // decimal
        $ssnEsc       = $con->real_escape_string($ssn);

        $sql = "INSERT INTO tblUser (email, password, firstName, lastName, address, phone, salary, SSN)
                VALUES ('$emailEsc', '$passEsc', '$firstEsc', '$lastEsc', '$addressEsc', '$phoneEsc', $salaryValue, '$ssnEsc')";

        $db->executeQuery($con, $sql);

        $message = "Registration successful! (User added to database.)";

        $con->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
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

<div class="background_image"></div>

<main class="centered_page">
    
    <div class="form_wrapper">
        <h1>Registration</h1>

        <?php if ($message !== ""): ?>
            <p class="form_message">
                <strong><?php echo htmlspecialchars($message); ?></strong>
            </p>
        <?php endif; ?>

        <form method="POST" action="registration.php">

            <div class="field">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="field">
                <label for="firstName">First Name</label>
                <input type="text" id="firstName" name="firstName" required>
            </div>

            <div class="field">
                <label for="lastName">Last Name</label>
                <input type="text" id="lastName" name="lastName" required>
            </div>

            <div class="field">
                <label for="address">Address</label>
                <input type="text" id="address" name="address">
            </div>

            <div class="field">
                <label for="phone">Phone</label>
                <input type="text" id="phone" name="phone">
            </div>

            <div class="field">
                <label for="salary">Salary</label>
                <input type="number" step="0.01" id="salary" name="salary">
            </div>

            <div class="field">
                <label for="ssn">SSN</label>
                <input type="text" id="ssn" name="ssn" placeholder="123-45-6789">
            </div>

            <button type="submit">Register</button>

        </form>
    </div>

</main>


</body>
</html>
