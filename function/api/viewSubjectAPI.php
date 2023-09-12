<?php
require '../conn.php'; // Include the database configuration

// Initialize the response data
$responseData = [];

if (strcasecmp($_SERVER['REQUEST_METHOD'], 'GET') === 0 && isset($_GET['device_name'])) {
    $deviceName = trim($_GET['device_name']); // Trim whitespace
    error_log("Device name received: " . $deviceName);
    $deviceData = fetchDeviceData($deviceName);
    
    if ($deviceData !== null) {
        if ($deviceData['permission'] == 1) {
            $subjects = fetchSubjects($deviceName);

            if ($subjects !== null) {
                $responseData['success'] = true;
                $responseData['message'] = 'Subjects fetched successfully';
                $responseData['subjects'] = $subjects;
            } else {
                $responseData['success'] = false;
                $responseData['message'] = 'Failed to fetch subjects';
                $responseData['error'] = 'Database query error';
            }
        } else {
            $responseData['success'] = false;
            $responseData['message'] = 'Device not permitted';
        }
    } else {
        $responseData['success'] = false;
        $responseData['message'] = 'Device not found in the database';
    }
} else {
    http_response_code(400);
    $responseData['success'] = false;
    $responseData['message'] = 'Unsupported request';
}

header('Content-Type: application/json');
echo json_encode($responseData);

function fetchDeviceData($deviceName) {
    global $conn; // Access the database connection

    $query = "SELECT * FROM device_details WHERE BINARY device_name = ?"; // Case-sensitive comparison

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $deviceName);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    } else {
        error_log("Database error in fetchDeviceData: " . mysqli_error($conn));
        return null; // Handle query execution error
    }
}

function fetchSubjects($deviceName) {
    global $conn; // Access the database connection

    $query = "SELECT s.subject_name FROM subject_details s
              INNER JOIN instructor_details i ON s.instructor_idfk = i.instructor_id
              INNER JOIN device_details d ON i.device_idfk = d.device_id
              WHERE BINARY d.device_name = ?"; // Case-sensitive comparison

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $deviceName);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $subjects = [];

        while ($row = $result->fetch_assoc()) {
            $subjects[] = $row['subject_name'];
        }

        return $subjects;
    } else {
        // Log the database error for debugging
        error_log("Database error in fetchSubjects: " . mysqli_error($conn));
        return null; // Handle query execution error
    }
}
?>
