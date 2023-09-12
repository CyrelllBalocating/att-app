<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php'); // Redirect to the "not_allowed.php" page outside the "admin" folder
    exit();
}
include('sidebar.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">

    <title>Course Information</title>
</head>

<body>
    <div class="main">
        <h1>Course Information</h1>
        <div class=button>
            <a href="add_course.php">Add course</a>
        </div>
        <?php
        // Include your database connection code
        require_once('../function/conn.php');

        // SQL query to select course details
        $sql = "SELECT `course_id`, `course_code`, `course_name` FROM `course_details`";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '  
            
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Action</th></tr>';

            // Fetch and display each row of course details
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                // echo '<td>' . $row['course_id'] . '</td>';
                echo '<td>' . $row['course_code'] . '</td>';
                echo '<td>' . $row['course_name'] . '</td>';
                echo '<td><div class=action><a href="edit_course.php?=' . $row['course_id'] . '">Edit Course</a></div></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No course details found.';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>
