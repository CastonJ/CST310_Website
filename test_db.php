<?php
require_once __DIR__ . "/includes/Database.php";

$db = new Database();
$con = $db->createConnection();

// 1) TEST: SELECT (should work even if table is empty)
$sql = "SELECT COUNT(*) AS total FROM tblUser";
$result = $db->executeSelectQuery($con, $sql);
$row = $result->fetch_assoc();

echo "Connected! Rows in tblUser: " . $row["total"];
