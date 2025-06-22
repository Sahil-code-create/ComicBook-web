<?php
// Enable CORS for API access
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "anime";  // Make sure this is the correct database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Fetch input data
$data = json_decode(file_get_contents("php://input"), true);

// Check if required fields exist
if (!isset($data["c_name"]) || !isset($data["c_password"])) {
    echo json_encode(["success" => false, "message" => "Missing required fields"]);
    exit;
}

$c_name = $data["c_name"];
$c_password =$data["c_password"]; // Hash password for security

// Insert into the database using prepared statements
$stmt = $conn->prepare("INSERT INTO user (c_name, c_password) VALUES (?, ?)");
$stmt->bind_param("ss", $c_name, $c_password);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User registered successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to register user", "error" => $conn->error]);
}

$stmt->close();
$conn->close();
?>
