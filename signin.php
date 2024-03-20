<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);


// Check if form is submitted

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username and password are not empty
    if (!empty($username) && !empty($password)) {
        $host = "localhost";
        $dbusername = "root";
        $dbpassword = "";
        $dbname = "skillstream";

        // Create connection
        $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

        // Check connection
        if (mysqli_connect_error()) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        } else {
            // Prepare and execute SELECT query
            $SELECT = "SELECT * FROM signin WHERE username = ? AND password = ?";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("ss", $username, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if user exists
            if ($result->num_rows == 1) {
                // User found, redirect to index.html or any other page
                echo "Login successful!";
                header("Location: index.html");
            } else {
                echo "Invalid username or password";
            }

            // Close statement and connection
            $stmt->close();
            $conn->close();
        }
    } else {
        echo "All fields are required";
    }
} else {
    echo "Form submission method not recognized";
}
?>
