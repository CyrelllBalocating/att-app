<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php');
    exit();
}
// include('sidebar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-4">

                <?php
                if (isset($_SESSION['notifications'])) {
                    foreach ($_SESSION['notifications'] as $notification) {
                        echo "<div class='alert alert-success'>" . $notification . "</div>";
                    }
                    unset($_SESSION['notifications']);
                }
                ?>

                <!-- Display errors above the form -->
                <?php
                if (isset($_SESSION['errors'])) {
                    foreach ($_SESSION['errors'] as $error) {
                        echo "<div class='alert alert-danger'>" . $error . "</div>";
                    }
                    unset($_SESSION['errors']);
                }
                ?>
                <?php

                // Check if the message is set in the session
                if (isset($_SESSION['message'])) {
                    foreach ($_SESSION['message'] as $message) {
                        echo "<div class='alert alert-success'>" . $message . "</div>";
                    }
                    unset($_SESSION['message']);
                }
                ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Import Excel Data</h4>
                    </div>
                    <div class="card-body">

                        <!-- Form for Excel Import -->
                        <form action="../function/import_student.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="import_file" class="form-control mb-2" required />
                            <button type="submit" name="save_excel_data" class="btn btn-primary">Import</button>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Manual Student Entry</h4>
                    </div>
                    <div class="card-body">

                        <!-- Form for Manual Student Entry -->
                        <form action="../function/import_student.php" method="POST">
                            <div class="mb-3">
                                <label for="student_number" class="form-label">Student Number:</label>
                                <input type="text" class="form-control" id="student_number" name="student_number" required value="<?php echo isset($_SESSION['old']['student_number']) ? $_SESSION['old']['student_number'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" class="form-control" id="lname" name="lname" required value="<?php echo isset($_SESSION['old']['lname']) ? $_SESSION['old']['lname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" class="form-control" id="fname" name="fname" required value="<?php echo isset($_SESSION['old']['fname']) ? $_SESSION['old']['fname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mname" class="form-label">Middle Name:</label>
                                <input type="text" class="form-control" id="mname" name="mname" value="<?php echo isset($_SESSION['old']['mname']) ? $_SESSION['old']['mname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="course" class="form-label">Course</label>
                                <input type="text" class="form-control" id="course" name="course" required value="<?php echo isset($_SESSION['old']['course']) ? $_SESSION['old']['course'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department:</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="CHMBAC" <?php echo isset($_SESSION['old']['department']) && $_SESSION['old']['department'] == 'CHMBAC' ? 'selected' : ''; ?>>CHMBAC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year:</label>
                                <select class="form-select" id="year" name="year" required>
                                    <option value="" disabled selected>Select Year</option>
                                    <option value="1" <?php echo isset($_SESSION['old']['year']) && $_SESSION['old']['year'] == '1' ? 'selected' : ''; ?>>1st year</option>
                                    <option value="2" <?php echo isset($_SESSION['old']['year']) && $_SESSION['old']['year'] == '2' ? 'selected' : ''; ?>>2nd year</option>
                                    <option value="3" <?php echo isset($_SESSION['old']['year']) && $_SESSION['old']['year'] == '3' ? 'selected' : ''; ?>>3rd year</option>
                                    <option value="4" <?php echo isset($_SESSION['old']['year']) && $_SESSION['old']['year'] == '4' ? 'selected' : ''; ?>>4th year</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="section" class="form-label">Section:</label>
                                <input type="text" class="form-control" id="section" name="section" required value="<?php echo isset($_SESSION['old']['section']) ? $_SESSION['old']['section'] : ''; ?>">
                            </div>
                            <button type="submit" name="save_manual_data" class="btn btn-primary">Save Manual Entry</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>