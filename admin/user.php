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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="table.css">

    <title>User Details</title>
</head>

<body>
    <div class="main">
        <h1>User Details</h1>
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "att_app";

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection is successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // SQL query to retrieve user details
        $sql = "SELECT `id`, `id_number`, `idfk`, `idfk2`, `password`, `role` FROM `user_details`";

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are rows in the result
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID Number</th><th>Role</th></tr>";

            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                // echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["id_number"] . "</td>";
                // echo "<td>" . $row["idfk"] . "</td>";
                // echo "<td>" . $row["idfk2"] . "</td>";
                // echo "<td>" . $row["password"] . "</td>";
                echo "<td>" . $row["role"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No user details found.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</body>

</html>