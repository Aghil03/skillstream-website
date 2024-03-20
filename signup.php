<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email  = $_POST['email'];
    $password = $_POST['password'];

    // Perform sign-up logic
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Database connection
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "skillstream";

        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        if ($conn->connect_error) {
            die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
        } else {
            // Check if email already exists
            $SELECT = "SELECT email FROM signup WHERE email = ?";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            $num_rows = $stmt->num_rows;

            if ($num_rows == 0) {
                // Insert new user data
                $INSERT = "INSERT INTO signup (username, email, password) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($INSERT);
                $stmt->bind_param("sss", $username, $email, $password);
                $stmt->execute();
                echo "Sign Up Successful";
            } else {
                echo "Someone is already using this email";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "All fields are required";
    }
}

?>
