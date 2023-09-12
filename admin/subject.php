<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php');
    exit();
}
include('sidebar.php');
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="table.css">
    <title>Subject Details</title>
</head>

<body>
    <div class="main">
        <h1>Subject Details with Course Codes and Instructors</h1>
        <div class=button>
            <a href="add_subject.php">Add new subject</a>
        </div>
        <table>
            <tr>
                <th>Subject Code</th>
                <th>Subject Name</th>
                <th>Course Code</th>
                <th>Year</th>
                <th>Section</th>
                <th>Department</th>
                <th>Instructor Name</th>
                <th>Actions</th>
            </tr>
            <?php
            include('../function/conn.php'); // Include your database connection here

            $query = "SELECT sd.*, cd.course_code, id.fname, id.lname, id.mname 
                      FROM subject_details sd
                      JOIN instructor_details id ON sd.instructor_idfk = id.instructor_id
                      JOIN course_details cd ON sd.course_idfk = cd.course_id";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['subject_code'] . "</td>";
                echo "<td>" . $row['subject_name'] . "</td>";
                echo "<td>" . $row['course_code'] . "</td>";
                echo "<td>" . $row['year'] . "</td>";
                echo "<td>" . $row['section'] . "</td>";
                echo "<td>" . $row['department'] . "</td>";
                echo "<td>" . $row['lname'] . " " . $row['fname'] . " " . $row['mname'] . "</td>";
                echo '<td><div class=action><a href="subject_classList.php?subject_id=' . $row['subject_id'] . '">View Class List</a></div></td>';
                echo "</tr>";
            }

            mysqli_close($conn);
            ?>
        </table>
    </div>
</body>

</html>