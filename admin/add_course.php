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
    <title>Add New Course</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-6 mt-4">

                <!-- Display notifications above the form -->
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

                <div class="card">
                    <div class="card-header">
                        <h4>Add Course</h4>
                    </div>
                    <div class="card-body">

                        <!-- Form for Course Entry -->
                        <form action="../function/process_course.php" method="POST">
                            <div class="mb-3">
                                <label for="course_code" class="form-label">Course Code:</label>
                                <input type="text" class="form-control" id="course_code" name="course_code" value="<?php echo isset($_SESSION['old']['course_code']) ? $_SESSION['old']['course_code'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="course_name" class="form-label">Course Name:</label>
                                <input type="text" class="form-control" id="course_name" name="course_name" value="<?php echo isset($_SESSION['old']['course_name']) ? $_SESSION['old']['course_name'] : ''; ?>" required>
                            </div>
                            <button type="submit" name="save_course" class="btn btn-primary">Add Course</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
