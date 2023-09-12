<?php
session_start();
include('conn.php');

$errors = [];
$notifications = [];

if (isset($_POST['save_manual_data'])) {
    $employee_number = $_POST['employee_number'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $mname = $_POST['mname'];
    $dept = $_POST['department'];
    $device_idfk = null; 

    // Check for duplicate employee number
    $checkQuery = "SELECT COUNT(*) as count FROM instructor_details WHERE employee_number = ?";
    $checkStmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, "s", $employee_number);
    mysqli_stmt_execute($checkStmt);
    $result = mysqli_stmt_get_result($checkStmt);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        // Set old input values for notification of duplication
        $_SESSION['old'] = [
            'employee_number' => $employee_number,
            'fname' => $fname,
            'lname' => $lname,
            'mname' => $mname,
            'dept' => $dept,
        ];
        $errors[] = "Employee number already exists.";
    } else {
        // Insert new instructor if no duplicate found
        $insertQuery = "INSERT INTO instructor_details (employee_number, fname, lname, mname, dept, device_idfk) 
                        VALUES (?, ?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "ssssss", $employee_number, $fname, $lname, $mname, $dept, $device_idfk);

        if (mysqli_stmt_execute($insertStmt)) {
            // Capture the generated instructor_id
            $instructorId = mysqli_insert_id($conn);

            // Insert user account for the instructor
            $userQuery = "INSERT INTO user_details (id_number, idfk2, role, password) VALUES (?, ?, ?, ?)";
            $userStmt = mysqli_prepare($conn, $userQuery);
            $idNumber = $employee_number; // Using employee_number as id_number
            $idfk2 = $instructorId; // Using the generated instructor_id
            $role = "instructor";
            $password = "password12345";
            // password_hash("password12345", PASSWORD_DEFAULT); 
            mysqli_stmt_bind_param($userStmt, "siss", $idNumber, $idfk2, $role, $password);

            if (mysqli_stmt_execute($userStmt)) {
                $notifications[] = "Instructor added successfully.";
                $_SESSION['old'] = [];
            } else {
                $errors[] = "Error adding instructor account: " . mysqli_error($conn);
            }

            mysqli_stmt_close($userStmt); 
        } else {
            $errors[] = "Error adding instructor details: " . mysqli_error($conn);
        }

        mysqli_stmt_close($insertStmt); 
    }

    mysqli_stmt_close($checkStmt); 

    // Store errors and notifications in session variables
    $_SESSION['errors'] = $errors;
    $_SESSION['notifications'] = $notifications;

    header('Location: ../admin/add_instructors.php');
    exit();
}
?>
