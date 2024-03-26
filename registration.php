<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "root@123";
$dbname = "LoginProject";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$first_name = validate($_POST['first_name']);
$last_name = validate($_POST['last_name']);
$cell_phone = validate($_POST['cell_phone']);
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

// Validate input (error handling, password matching, etc.)
validatePassword($password, $confirm_password);
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function validatePassword($password, $confirmPassword)
{
    if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,}$/', $password)) {
        die("Password must be at least 8 characters long and contain at least 1 number, 1 uppercase letter, 1 lowercase letter, and 1 special character.");
    }
    if ($password != $confirmPassword) {
        die("Passwords do not match.");
    }
}

// Insert into database
$sql = "INSERT INTO users (first_name, last_name, cell_phone, password) VALUES ('$first_name', '$last_name', '$cell_phone', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registration successful!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
