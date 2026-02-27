<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>


<?php
$message = "";
$messageType = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_FILES["myFile"]) || $_FILES["myFile"]["error"] !== 0) {
        $message = "Please select a file.";
        $messageType = "error";
    } else {

        $uploadDirectory = "uploads/";

        // Create uploads folder if it doesn't exist
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $fileName = basename($_FILES["myFile"]["name"]);
        $targetFile = $uploadDirectory . $fileName;

        $fileSize = $_FILES["myFile"]["size"];
        $fileTmp = $_FILES["myFile"]["tmp_name"];
        $fileExtension = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Allowed file types
        $allowedTypes = ["jpg", "jpeg", "png", "pdf"];

        // Validate file type
        if (!in_array($fileExtension, $allowedTypes)) {
            $message = "Invalid file type. Only JPG, PNG, and PDF allowed.";
            $messageType = "error";
        }
        // Validate file size (2MB limit)
        elseif ($fileSize > 2 * 1024 * 1024) {
            $message = "File is too large. Maximum size is 2MB.";
            $messageType = "error";
        }
        else {

            // Prevent overwriting files
            $uniqueName = uniqid() . "_" . $fileName;
            $targetFile = $uploadDirectory . $uniqueName;

            if (move_uploaded_file($fileTmp, $targetFile)) {
                $message = "File uploaded successfully!";
                $messageType = "success";
            } else {
                $message = "Error uploading file.";
                $messageType = "error";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="script.js" defer></script>
    <title>Upload File</title>
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
    <a href="login.php">Login</a>
    <a href="registration.php">Register</a>
</div>

<main class="upload_page">

    <div class="upload_card">
        <h1>Upload File</h1>

        <?php if ($message !== ""): ?>
            <p class="upload_message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label class="upload_box">
                Click to select a file
                <input type="file" name="myFile" required>
            </label>

            <button class="upload_button" type="submit">
                Upload
            </button>

        </form>
    </div>

</main>

</body>
</html>