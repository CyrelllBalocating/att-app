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

    // Extract username and password from the request data
    $username = isset($data['username']) ? $data['username'] : '';
    $password = isset($data['password']) ? $data['password'] : '';

    // Validate the input (you can add more validation here)
    if (empty($username) || empty($password)) {
        // Respond with an error message for missing or empty fields
        echo json_encode(["message" => "Username and password are required"]);
    } else {
        // Perform the database query using the provided SQL query
        $query = "SELECT *, user_details.idfk2 AS instructor_idfk2 FROM user_details LEFT JOIN instructor_details ON user_details.idfk2 = instructor_details.instructor_id WHERE id_number=? AND password=? LIMIT 0, 25";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // If login is successful, retrieve user details
            $row = $result->fetch_assoc();
            $userRole = $row['role'];

            if ($userRole === 'instructor') {
                // If the user is an instructor, update the instructor's device_idfk
                $deviceName = isset($data['device_name']) ? $data['device_name'] : '';

                if (!empty($deviceName)) {
                    // Check if the device already exists in the table
                    $checkDeviceSql = "SELECT device_id FROM device_details WHERE device_name=?";
                    $stmt = $conn->prepare($checkDeviceSql);
                    $stmt->bind_param("s", $deviceName);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Device already exists, update the instructor's device_idfk
                        $deviceId = $result->fetch_assoc()['device_id'];
                        $instructorId = $row['instructor_idfk2'];
                        $updateInstructorSql = "UPDATE instructor_details SET device_idfk=? WHERE instructor_id=?";
                        $stmt = $conn->prepare($updateInstructorSql);
                        $stmt->bind_param("ii", $deviceId, $instructorId);
                        $stmt->execute();
                        echo json_encode(["message" => "Device updated successfully"]);
                    } else {
                        // Insert a new device since it doesn't exist
                        $insertDeviceSql = "INSERT INTO device_details (device_name, permission) VALUES (?, 1)";
                        $stmt = $conn->prepare($insertDeviceSql);
                        $stmt->bind_param("s", $deviceName);
                        $stmt->execute();
                        $deviceId = $stmt->insert_id;

                        // Update the instructor's device_idfk
                        $instructorId = $row['instructor_idfk2'];
                        $updateInstructorSql = "UPDATE instructor_details SET device_idfk=? WHERE instructor_id=?";
                        $stmt = $conn->prepare($updateInstructorSql);
                        $stmt->bind_param("ii", $deviceId, $instructorId);
                        $stmt->execute();

                        echo json_encode(["message" => "Device added successfully"]);
                    }
                }
            }

            // Respond with a success message and user role
            echo json_encode(["message" => "Login successful", "user_role" => $userRole]);
        } else {
            // If login fails, respond with an error message
            echo json_encode(["message" => "Login failed"]);
        }
    }
} else {
    // Respond with an error message for unsupported HTTP methods
    echo json_encode(["message" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>
