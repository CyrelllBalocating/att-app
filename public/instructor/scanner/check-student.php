<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'att_app';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['studentNumber']) && isset($_POST['subject_id'])) {
    $studentNumber = $_POST['studentNumber'];
    $subjectId = $_POST['subject_id'];

$query = "SELECT student_details.student_number, enrolled_sub.subject_idfk, enrolled_sub.enrolled_id
              FROM student_details
              JOIN enrolled_sub ON student_details.student_id = enrolled_sub.student_idfk
              WHERE student_details.student_number = ? AND enrolled_sub.subject_idfk = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('si', $studentNumber, $subjectId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
          
            $row = $result->fetch_assoc();
            $enrolledId = $row['enrolled_id'];
            $date = date('Y-m-d');
            $attAt = date('Y-m-d H:i:s');

            $checkQuery = "SELECT * FROM att_details WHERE enrolled_idfk = ? AND date = ?";
            $checkStmt = $conn->prepare($checkQuery);
            $checkStmt->bind_param('is', $enrolledId, $date);
            $checkStmt->execute();
            $existingRecord = $checkStmt->get_result()->fetch_assoc();

            if ($existingRecord) {
                echo json_encode(['message' => 'Duplicate attendance record']);
            } else {
                $insertQuery = "INSERT INTO att_details (enrolled_idfk, date, att_at) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param('iss', $enrolledId, $date, $attAt);

                if ($insertStmt->execute()) {
                    echo json_encode(['message' => 'Student is present']);
                } else {
                    echo json_encode(['message' => 'Failed to insert data']);
                }

                $insertStmt->close();
            }
            
            $checkStmt->close();
        } else {
            echo json_encode(['message' => 'Student not found or not enrolled to this class']);
        }
    } else {
        echo json_encode(['message' => 'Query execution failed: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['message' => 'Missing data']);
}

$conn->close();
