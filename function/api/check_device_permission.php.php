<?php
// Set headers to allow cross-origin requests
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include your database connection file
include('../conn.php');

// Define the API routes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request data as JSON
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract device_name from the request data
    $deviceName = isset($data['device_name']) ? $data['device_name'] : '';

    // Validate the input (you can add more validation here)
    if (empty($deviceName)) {
        // Respond with an error message for missing or empty fields
        echo json_encode(["message" => "Device name is required"]);
    } else {
        // Check if the device is permitted
        $deviceSql = "SELECT * FROM permitted_devices WHERE device_name='$deviceName'";
        $deviceResult = $conn->query($deviceSql);

        if ($deviceResult->num_rows > 0) {
            // Device is permitted, respond with a success message
            echo json_encode(["message" => "Device is permitted"]);
        } else {
            // Device is not permitted, respond with an error message
            echo json_encode(["message" => "Device is not permitted"]);
        }
    }
} else {
    // Respond with an error message for unsupported HTTP methods
    echo json_encode(["message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>
