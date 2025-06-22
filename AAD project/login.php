<?php
// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");

// Database connection
$conn = new mysqli("localhost", "root", "", "anime");

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}
$method = $_SERVER['REQUEST_METHOD'];

// Fetch input data
$data = json_decode(file_get_contents("php://input"), true);

// Check if required parameters are present
switch($method){
    case 'GET':
        if (isset($_GET["c_name"]) && isset($_GET["c_password"])) {
            $c_name = $_GET["c_name"];
            $c_password = $_GET["c_password"];
        
            // Prevent SQL Injection
            $c_name = $conn->real_escape_string($c_name);
            $c_password = $conn->real_escape_string($c_password);
        
            // ✅ Corrected SQL Query
            $sql = "SELECT * FROM user WHERE c_name='$c_name' AND c_password='$c_password'";
            $result = $conn->query($sql);
        
            if ($result->num_rows > 0) {
                echo json_encode(["success" => true, "message" => "Login successful"]);
            } else {
                echo json_encode(["success" => false, "message" => "Invalid Name or Password"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Missing parameters"]);
        }
        # code...
        break;
}

$conn->close();
?>
