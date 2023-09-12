<?php

use PhpOffice\PhpSpreadsheet\IOFactory;
session_start();
include('conn.php');

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_POST['save_excel_data'])) {
    $allowedExtensions = ['xls', 'csv', 'xlsx'];
    $file = $_FILES['import_file'];
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedExtensions)) {
        $_SESSION['message'][] = "Invalid file format. Allowed formats: xls, csv, xlsx";
        header('Location: ../admin/add.php');
        exit();
    }

    require 'conn.php';
    require '../vendor/autoload.php';

    try {
        $spreadsheet = IOFactory::load($file['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        include 'conn.php';

        foreach ($data as $rowIndex => $rowData) {
            if ($rowIndex === 0) {
                continue;
            }

            list($studentNumber, $lname, $fname, $mname, $course, $department, $year, $section) = $rowData;

            // Check for existing student number
            $checkQuery = "SELECT COUNT(*) as count FROM student_details WHERE student_number = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, "s", $studentNumber);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $count);
            mysqli_stmt_fetch($stmt);

            mysqli_stmt_close($stmt);

            if ($count > 0) {
                $_SESSION['message'][] = "Student number '$studentNumber' already exists. Skipping...";
                continue; // Skip inserting this row
            }

            // Insert data
            $studentQuery = "INSERT INTO student_details (student_number, lname, fname, mname, course, department, year, section) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $studentQuery);
            mysqli_stmt_bind_param($stmt, "ssssssss", $studentNumber, $lname, $fname, $mname, $course, $department, $year, $section);

            if (mysqli_stmt_execute($stmt)) {
                // Insert user account for the student
                $studentId = mysqli_insert_id($conn);
                $userQuery = "INSERT INTO user_details (id_number, idfk, role, password) VALUES (?, ?, ?, ?)";
                $userStmt = mysqli_prepare($conn, $userQuery);
                $idNumber = $studentNumber; // Using student_number as id_number
                $idfk1 = $studentId; // Using the generated student_id
                $role = "student";
                $password = password_hash("password12345", PASSWORD_DEFAULT); // Securely hash the password
                mysqli_stmt_bind_param($userStmt, "siss", $idNumber, $idfk1, $role, $password);
                
                mysqli_stmt_execute($userStmt);
                mysqli_stmt_close($userStmt);
                
                $_SESSION['message'][] = "Student data and user account created for '$studentNumber'.";
            } else {
                $_SESSION['message'][] = "Error inserting student data: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_close($conn);

        $_SESSION['message'][] = "Data processed successfully.";

    } catch (Exception $e) {
        $_SESSION['message'][] = "Error processing the spreadsheet: " . $e->getMessage();
    }

    header('Location: ../admin/add.php');
    exit();
}

if (isset($_POST['save_manual_data'])) {
    $student_number = $_POST['student_number'];

    $checkQuery = "SELECT COUNT(*) as count FROM student_details WHERE student_number = ?";
    $stmt = mysqli_prepare($conn, $checkQuery);
    mysqli_stmt_bind_param($stmt, "s", $student_number);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt); 

    if ($count > 0) {
        $_SESSION['errors'][] = "Student number '$student_number' already exists.";
        $_SESSION['old'] = $_POST;
        header("Location: ../admin/add.php");
        exit();
    }

    $insertQuery = "INSERT INTO student_details (student_number, fname, lname, mname, course, department, year, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, "ssssssss", $_POST['student_number'], $_POST['fname'], $_POST['lname'], $_POST['mname'], $_POST['course'], $_POST['department'], $_POST['year'], $_POST['section']);

    if (mysqli_stmt_execute($stmt)) {
        // Insert user account for the student
        $studentId = mysqli_insert_id($conn);
        $userQuery = "INSERT INTO user_details (id_number, idfk1, role, password) VALUES (?, ?, ?, ?)";
        $userStmt = mysqli_prepare($conn, $userQuery);
        $idNumber = $_POST['student_number']; // Using student_number as id_number
        $idfk1 = $studentId; // Using the generated student_id
        $role = "student";
        $password = "password12345";
        // $password = password_hash("password12345", PASSWORD_DEFAULT); // Securely hash the password
        mysqli_stmt_bind_param($userStmt, "siss", $idNumber, $idfk1, $role, $password);
        
        mysqli_stmt_execute($userStmt);
        mysqli_stmt_close($userStmt);

        $_SESSION['notifications'][] = "Student data and user account created successfully.";
        unset($_SESSION['old']);
    } else {
        $_SESSION['errors'][] = "Error while adding student data: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    header("Location: ../admin/add.php");
    exit();
}

?>
