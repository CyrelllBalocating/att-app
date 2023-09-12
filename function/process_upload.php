<?php

require_once '../vendor/autoload.php'; // Path to your Composer autoload file

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_POST['submit'])) {
    if (isset($_FILES['import_file'])) {
        $file = $_FILES['import_file'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($_FILES['import_file']['error'] === UPLOAD_ERR_OK) {
            // Check if the file extension is in the list of allowed extensions
            $allowedExtensions = ['xls', 'csv', 'xlsx'];

            if (in_array($fileExt, $allowedExtensions)) {
                if (isset($_GET['subject_id'])) {
                    $subjectId = $_GET['subject_id'];

                    // Load the Excel file
                    $spreadsheet = IOFactory::load($file['tmp_name']);
                    $worksheet = $spreadsheet->getActiveSheet();
                    $data = $worksheet->toArray();

                    include 'conn.php';

                    foreach ($data as $rowIndex => $rowData) {
                        if ($rowIndex === 0) {
                            continue; // Skip the header row
                        }

                        $studentNumber = $rowData[0];
                        $studentName = $rowData[1];


                        $query = "SELECT student_id FROM student_details WHERE student_number = ?";
                        $stmt = mysqli_prepare($conn, $query);

                        if ($stmt) {
                            mysqli_stmt_bind_param($stmt, "s", $studentNumber);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) > 0) {
                                // Student already exists, fetch their student_id
                                mysqli_stmt_bind_result($stmt, $studentId);
                                mysqli_stmt_fetch($stmt);

                                // Check if the enrollment record already exists
                                $enrollCheckQuery = "SELECT * FROM enrolled_sub WHERE student_idfk = ? AND subject_idfk = ?";
                                $enrollCheckStmt = mysqli_prepare($conn, $enrollCheckQuery);

                                if ($enrollCheckStmt) {
                                    mysqli_stmt_bind_param($enrollCheckStmt, "ii", $studentId, $subjectId);
                                    mysqli_stmt_execute($enrollCheckStmt);
                                    mysqli_stmt_store_result($enrollCheckStmt);

                                    if (mysqli_stmt_num_rows($enrollCheckStmt) === 0) {
                                        // Enrollment record doesn't exist, insert it
                                        $enrollQuery = "INSERT INTO enrolled_sub (student_idfk, subject_idfk) VALUES (?, ?)";
                                        $enrollStmt = mysqli_prepare($conn, $enrollQuery);

                                        if ($enrollStmt) {
                                            mysqli_stmt_bind_param($enrollStmt, "ii", $studentId, $subjectId);
                                            mysqli_stmt_execute($enrollStmt);
                                            echo "Enrollment saved successfully<br>";
                                        } else {
                                            echo "Error preparing enrollment statement: " . mysqli_error($conn);
                                        }
                                    } else {
                                        echo "Enrollment record already exists, skipping<br>";
                                    }
                                } else {
                                    echo "Error preparing enrollment check statement: " . mysqli_error($conn);
                                }
                            } else {
                                echo "Student is not in the database<br>";
                            }
                        } else {
                            echo "Error preparing query: " . mysqli_error($conn);
                        }
                    }

                    // Redirect or display a success message
                    echo "Saved successfully";

                } else {
                    echo "Subject ID not found in the form.";
                }
            } else {
                echo "Invalid file format. Allowed formats: " . implode(", ", $allowedExtensions);
            }
        } else {
            // Handle file upload error
            echo "File upload error: " . $_FILES['import_file']['error'];
        }
    } else {
        echo "No file uploaded.";
    }
} else {
    echo "Submit button not clicked.";
}
?>
