<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php'); 
    exit();
}
// include('sidebar.php'); //for configuration
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
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
                        <h4>Add Subject</h4>
                    </div>
                    <div class="card-body">

                        <!-- Form for Subject Entry -->
                        <form action="../function/process_subject.php" method="POST">
                            <div class="mb-3">
                                <label for="subject_code" class="form-label">Subject Code:</label>
                                <input type="text" class="form-control" id="subject_code" name="subject_code" value="<?php echo isset($_SESSION['old']['subject_code']) ? $_SESSION['old']['subject_code'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="subject_name" class="form-label">Subject Name:</label>
                                <input type="text" class="form-control" id="subject_name" name="subject_name" value="<?php echo isset($_SESSION['old']['subject_name']) ? $_SESSION['old']['subject_name'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                            <label for="course" class="form-label">Course:</label>
                                <select class="form-select" id="course" name="course" required>
                                    <option value="" disabled selected>Select Course</option>
                                    <?php
                                    include('../function/conn.php');
                                    $courseQuery = "SELECT course_id, course_code, course_name FROM course_details";
                                    $courseResult = mysqli_query($conn, $courseQuery);

                                    while ($row = mysqli_fetch_assoc($courseResult)) {
                                        $course_id = $row['course_id'];
                                        $course_code = $row['course_code'];
                                        $course_name = $row['course_name'];
                                        echo "<option value='$course_id'>$course_code - $course_name</option>";
                                    }

                                    mysqli_free_result($courseResult);
                                    mysqli_close($conn);
                                    ?>
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
                                <input type="text" class="form-control" id="section" name="section" value="<?php echo isset($_SESSION['old']['section']) ? $_SESSION['old']['section'] : ''; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="department" class="form-label">Department:</label>
                                <select class="form-select" id="department" name="department" required>
                                    <option value="" disabled selected>Select Department</option>
                                    <option value="CHMBAC" <?php echo isset($_SESSION['old']['department']) && $_SESSION['old']['department'] == 'CHMBAC' ? 'selected' : ''; ?>>CHMBAC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="instructor_idfk" class="form-label">Instructor:</label>
                                <select class="form-select" id="instructor_idfk" name="instructor_idfk" required>
                                    <option value="" disabled selected>Select an Instructor</option>
                                    <?php
                                    include('../function/conn.php');
                                    $instructorQuery = "SELECT instructor_id, lname, fname, mname FROM instructor_details";
                                    $instructorResult = mysqli_query($conn, $instructorQuery);

                                    while ($row = mysqli_fetch_assoc($instructorResult)) {
                                        $instructor_id = $row['instructor_id'];
                                        $lname = $row['lname'];
                                        $fname = $row['fname'];
                                        $mname = $row['mname'];
                                        echo "<option value='$instructor_id'>$lname, $fname $mname</option>";
                                    }

                                    mysqli_free_result($instructorResult);
                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="save_subject" class="btn btn-primary">Add Subject</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>