<?php
class Database {

    // Create a database connection and return it
    public function createConnection() {
        $con = new mysqli("localhost", "root", "", "employee_portal");

        if ($con->connect_error) {
            die("Database connection failed: " . $con->connect_error);
        }

        return $con;
    }

    // Executes a SELECT query and returns the results
    public function executeSelectQuery($con, $sql) {
        $result = $con->query($sql);

        if (!$result) {
            die("Select query failed: " . $con->error);
        }

        return $result;
    }

    // Executes INSERT, UPDATE, or DELETE queries
    public function executeQuery($con, $sql) {
        $success = $con->query($sql);

        if (!$success) {
            die("Query failed: " . $con->error);
        }

        return $success;
    }
}
?>
