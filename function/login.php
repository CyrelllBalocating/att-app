<?php
session_start();
require 'conn.php'; // Your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNumber = trim($_POST['id_number']);

    $password = $_POST['password'];


    if (empty($idNumber) && empty($password)) {
        $_SESSION['message'] = "ID Number and Password are required.";
        $_SESSION['old'] = $_POST;
        header('Location: ../index.php');
        exit();
    } elseif (empty($idNumber)) {
        $_SESSION['message'] = "ID Number is required.";
        $_SESSION['old'] = $_POST;
        header('Location: ../index.php');
        exit();
    } elseif (empty($password)) {
        $_SESSION['message'] = "Password is required.";
        $_SESSION['old'] = $_POST;
        header('Location: ../index.php');
        exit();
    }

    // Database query and password verification
    $query = "SELECT id_number, password, role FROM user_details WHERE id_number = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $idNumber);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $dbIdNumber, $dbPassword, $dbRole);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Password verification and redirection
    // $logData = "Debugging: ID Number = $idNumber, Password = $password, DB Password = $dbPassword\n";
    // file_put_contents('debug.log', $logData, FILE_APPEND);
    if ($password == $dbPassword) {
        $_SESSION['id_number'] = $dbIdNumber;
        $_SESSION['role'] = $dbRole;

        // Redirect based on user role
        if ($dbRole === 'instructor') {
            // echo "instructor page";
            $_SESSION['user_role'] = 'instructor';
            $_SESSION['old'] = [];
            header('Location: ../public/instructor/index.php');
        } elseif ($dbRole === 'admin') {
            // echo "adminpage";
            $_SESSION['user_role'] = 'admin';
            $_SESSION['old'] = [];
            header('Location: ../admin/home.php');
        } elseif ($dbRole === 'student') {
            // echo "studentpage";
            $_SESSION['id_number'] = $dbIdNumber;
            $_SESSION['user_role'] = 'student';
            $_SESSION['old'] = [];
            header('Location: ../public/student/student_dashboard.php');
        }
    } else {
        $_SESSION['message'] = "Invalid ID Number or password.";
        $_SESSION['old'] = $_POST;
        header('Location: ../index.php');
        exit();
    }
}
