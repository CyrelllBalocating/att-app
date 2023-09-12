<?php
session_start();
include('conn.php');

$errors = [];
$notifications = [];
$old = [];

if (isset($_POST['save_subject'])) {
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $section = $_POST['section'];
    $department = $_POST['department'];
    $instructor_idfk = $_POST['instructor_idfk'];

    // Store old input data
    $_SESSION['old'] = [
        'subject_code' => $subject_code,
        'subject_name' => $subject_name,
        'course' => $course,
        'year' => $year,
        'section' => $section,
        'department' => $department,
        'instructor_idfk' => $instructor_idfk,
    ];

    // Check for duplicate subject code
    $duplicateQuery = "SELECT * FROM subject_details WHERE subject_code = ?";
    $duplicateStmt = mysqli_prepare($conn, $duplicateQuery);
    mysqli_stmt_bind_param($duplicateStmt, "s", $subject_code);
    mysqli_stmt_execute($duplicateStmt);
    $result = mysqli_stmt_get_result($duplicateStmt);

    if (mysqli_num_rows($result) > 0) {
        $errors[] = "Subject code already exists.";
    } else {
        $insertQuery = "INSERT INTO subject_details (subject_code, subject_name, course_idfk, year, section, department, instructor_idfk)
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, "sssssss", $subject_code, $subject_name, $course, $year, $section, $department, $instructor_idfk);

        if (mysqli_stmt_execute($insertStmt)) {
            $notifications[] = "Subject added successfully.";
            unset($_SESSION['old']); // Clear old input data
        } else {
            $errors[] = "Error adding subject.";
        }

        mysqli_stmt_close($insertStmt);
    }

    mysqli_stmt_close($duplicateStmt);
}

// Store errors and notifications in session variables
$_SESSION['errors'] = $errors;
$_SESSION['notifications'] = $notifications;

header('Location: ../admin/add_subject.php');
exit();
?>
