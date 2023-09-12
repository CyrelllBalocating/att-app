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
    <title>Add Instructor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">

                <div class="card">
                    <div class="card-header">
                        <h4>Add Instructor</h4>
                    </div>
                    <div class="card-body">

                        <!-- Display errors above the form -->
                        <?php
                        if (isset($_SESSION['errors'])) {
                            foreach ($_SESSION['errors'] as $error) {
                                echo "<div class='alert alert-danger'>" . $error . "</div>";
                            }
                            unset($_SESSION['errors']);
                        }

                        if (isset($_SESSION['notifications'])) {
                            foreach ($_SESSION['notifications'] as $notification) {
                                echo "<div class='alert alert-success'>" . $notification . "</div>";
                            }
                            unset($_SESSION['notifications']);
                        }
                        ?>

                        <!-- Manual Entry Form -->
                        <form action="../function/process_instructor.php" method="POST">
                            <div class="mb-3">
                                <label for="employee_number" class="form-label">Employee Number:</label>
                                <input type="text" name="employee_number" class="form-control" required value="<?php echo isset($_SESSION['old']['employee_number']) ? $_SESSION['old']['employee_number'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">First Name:</label>
                                <input type="text" name="fname" class="form-control" required value="<?php echo isset($_SESSION['old']['fname']) ? $_SESSION['old']['fname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">Last Name:</label>
                                <input type="text" name="lname" class="form-control" required value="<?php echo isset($_SESSION['old']['lname']) ? $_SESSION['old']['lname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="mname" class="form-label">Middle Name:</label>
                                <input type="text" name="mname" class="form-control" value="<?php echo isset($_SESSION['old']['mname']) ? $_SESSION['old']['mname'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                            <label for="department" class="form-label">Department:</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="CHMBAC" <?php echo isset($_SESSION['old']['department']) && $_SESSION['old']['department'] == 'CHMBAC' ? 'selected' : ''; ?>>CHMBAC</option>
                                </select>
                            </div>
                            <button type="submit" name="save_manual_data" class="btn btn-primary">Add Instructor</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
