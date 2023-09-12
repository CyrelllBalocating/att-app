<?php
session_start();

if (isset($_POST['save_course'])) {
    $courseCode = $_POST['course_code'];
    $courseName = $_POST['course_name'];

    if (empty($courseCode) || empty($courseName)) {
        $_SESSION['errors'][] = "All fields are required.";
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add_course.php");
        exit();
    }

    include('conn.php'); 
    $checkQuery = "SELECT COUNT(*) as count FROM course_details WHERE course_code = ? OR course_name = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);

    if (!$stmt) {
        $_SESSION['errors'][] = "Database error: " . mysqli_error($conn);
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add_course.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $courseCode, $courseName);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    // Check if a course with the same code or name already exists
    if ($count > 0) {
        $_SESSION['errors'][] = "Error adding course: Duplicate course code or course name.";
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add_course.php");
        exit();
    }

    $insertQuery = "INSERT INTO course_details (course_code, course_name) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    if (!$stmt) {
        $_SESSION['errors'][] = "Database error: " . mysqli_error($conn);
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add_course.php");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $courseCode, $courseName);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['notifications'][] = "Course added successfully.";
        header("Location: ../admin/add_course.php");
    } else {
        $_SESSION['errors'][] = "Error adding course: " . mysqli_error($conn);
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add_course.php");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    $_SESSION['errors'][] = "Invalid request.";
    header("Location: ../admin/add_course.php");
}

