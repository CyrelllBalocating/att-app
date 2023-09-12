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
    <title>Device Information</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div class="main">
        <h1>Device Information</h1>
        <?php
        // Include your database connection code
        require_once('../function/conn.php');

        // SQL query to select instructor details with device name and permission
        $sql = "SELECT 
            i.instructor_id,
            CONCAT(i.fname, ' ', i.lname, ' ', i.mname) AS instructor_name,
            i.employee_number,
            d.device_name,
            d.permission
        FROM instructor_details i
        INNER JOIN device_details d ON i.device_idfk = d.device_id";


        // Execute the query
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            echo '<table>';
            echo '  
            <th>Device Name</th>
            <th>Employee Number</th>
            <th>Assigned Instructor Name</th>
            <th>Permission</th>
            <th>Action</th></tr>';

            // Fetch and display each row of instructor details
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                // echo '<td>' . $row['instructor_id'] . '</td>';
                echo '<td>' . ($row['device_name'] ? $row['device_name'] : 'No device') . '</td>';
                echo '<td>' . $row['employee_number'] . '</td>';
                echo '<td>' . $row['instructor_name'] . '</td>';
                $permission = $row['permission'];
                echo '<td>' . ($permission == 1 ? 'Allowed' : 'Not Allowed') . '</td>';
                echo '<td><a href="edit_permission.php?device_id=' . $row['instructor_id'] . '">Edit permission</a></td>';
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
