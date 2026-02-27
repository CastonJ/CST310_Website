<?php
session_start();
require_once __DIR__ . "/includes/Database.php";

$message = "";
$messageType = ""; // "success" or "error"

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $message = "Please enter both email and password.";
        $messageType = "error";
    } else {

        $db = new Database();
        $con = $db->createConnection();

        // Use prepared statements (prevents SQL injection)
        $sql = "SELECT id, email, password, firstName, lastName FROM tblUser WHERE email = ? LIMIT 1";
        $stmt = $con->prepare($sql);

        if (!$stmt) {
            $message = "Database error preparing query.";
            $messageType = "error";
        } else {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();

                // If registration stored hashed passwords using password_hash():
                if (password_verify($password, $user["password"])) {

                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_email"] = $user["email"];
                    $_SESSION["first_name"] = $user["firstName"];
                    $_SESSION["last_name"] = $user["lastName"];

                    header("Location: profile.php");
                    exit;
                } else {
                    $message = "Invalid email or password.";
                    $messageType = "error";
                }
            } else {
                $message = "Invalid email or password.";
                $messageType = "error";
            }

            $stmt->close();
        }

        $con->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js" defer></script>
    <title>Employee Login</title>
</head>

<body>

<!-- Top Navigation -->
<div class="topnav">
    <a href="javascript:void(0);" class="icon" onclick="openNav()">&#9776;</a>
    <a href="index.php">Home</a>

    <?php if (!isset($_SESSION["user_id"])): ?>
        <a class="active" href="login.php">Login</a>
        <a href="registration.php">Register</a>
    <?php else: ?>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
    
    <a href="upload.php">Upload</a>    
    <a href="#">Contact</a>
</div>

<!-- Side Navigation -->
<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="index.php">Home</a>

    <?php if (!isset($_SESSION["user_id"])): ?>
        <a class="active" href="login.php">Login</a>
        <a href="registration.php">Register</a>
    <?php else: ?>
        <a href="profile.php">Profile</a>
        <a href="logout.php">Logout</a>
    <?php endif; ?>
</div>

<main class="login_page">
    <div class="login_wrapper">
        <h1>Employee Login</h1>

        <div class="login_card">
            <?php if ($message !== ""): ?>
                <p class="form_message <?php echo htmlspecialchars($messageType); ?>">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php endif; ?>

            <form class="login_form" method="POST" action="login.php" autocomplete="off">
                <div>
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" required>
                </div>

                <div>
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button class="login_button" type="submit">Login</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>