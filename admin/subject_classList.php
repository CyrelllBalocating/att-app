<?php
session_start();

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php'); 
    exit();
}
include('sidebar.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrolled Subject Information</title>
</head>

<body>
    <div class="main">
        <h1>Enrolled Subject Information</h1>
        
        <?php
        if (isset($_GET['subject_id'])) {
            $subjectId = $_GET['subject_id'];

            include('../function/conn.php'); 
            $query1 = "SELECT sd.subject_code, sd.subject_name, id.fname, id.lname, id.mname
               FROM enrolled_sub es
               JOIN subject_details sd ON es.subject_idfk = sd.subject_id
               JOIN instructor_details id ON sd.instructor_idfk = id.instructor_id
               WHERE es.subject_idfk = ?";

            $stmt = mysqli_prepare($conn, $query1);
            mysqli_stmt_bind_param($stmt, "i", $subjectId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                echo "<h3>" . "Subject Information" . "</h3>";
                echo "<p>" . "Subject Name: " . $row['subject_name'] . "</p>";
                echo "<p>" . "Instructor: " . $row['lname'] . " " . $row['fname'] . " " . $row['mname'] . "</p>";
            }

            mysqli_stmt_close($stmt);

            $query2 = "SELECT std.student_number, std.fname, std.lname, std.mname
               FROM enrolled_sub es
               JOIN student_details std ON es.student_idfk = std.student_id
               WHERE es.subject_idfk = ?";

            $stmt2 = mysqli_prepare($conn, $query2);
            mysqli_stmt_bind_param($stmt2, "i", $subjectId);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);

            echo "<h1>" . "Student Class List" . "</h1>";
            echo '<td><button><a href="att_log.php?subject_id=' . $subjectId . '">Show Attendance</a></button></td>';
            echo '<td><a href="add_enstudent.php?subject_id=' . $subjectId . '">Add new Student </a></td>';
            echo '<td><a href="../public/instructor/scanner/index.php?subject_id=' . $subjectId . '">Scan</a></td>';

            if (mysqli_num_rows($result2) > 0) {
                echo "<table>";
                echo "<tr>
                <th>Student Number</th>
                <th>Student Name</th>
              </tr>";

                while ($row2 = mysqli_fetch_assoc($result2)) {
                    echo "<tr>";
                    echo "<td>" . $row2['student_number'] . "</td>";
                    echo "<td>" . $row2['lname'] . " " . $row2['fname'] . " " . $row2['mname'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                echo "<BR>No data to show.";
            }

            mysqli_stmt_close($stmt2);
            mysqli_close($conn);
        }
        ?>
    </div>
</body>

</html>