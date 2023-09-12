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

    <title>Instructor's Information</title>
</head>

<body>
    <div class="main">
        <h1>Instructor Information</h1>
            <div class=button>
                <a href="add_instructors.php">Add new instructor</a>
            </div>
        <?php
        // Include your database connection code
        require_once('../function/conn.php');

        // SQL query to select instructor details with device name and permission
        $sql = "SELECT 
        i.instructor_id,
        CONCAT(i.fname, ' ', i.lname, ' ', i.mname) AS instructor_name,
        i.employee_number,
        i.dept
        FROM instructor_details i
        ";


        // Execute the query
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '  
            <th>Employee Number</th>
            <th>Instructor Name</th>
            <th>Department</th>
            <th>Action</th></tr>';

            // Fetch and display each row of instructor details
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                // echo '<td>' . $row['instructor_id'] . '</td>';
                echo '<td>' . $row['employee_number'] . '</td>';
                echo '<td>' . $row['instructor_name'] . '</td>';
                echo '<td>' . $row['dept'] . '</td>';
                echo '<td><div class=action><a href="edit_instructor.php?=' . $row['instructor_id'] . '">Edit Instructor</a></div></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
            echo 'No instructor details found.';
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>