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
    <meta http-equive="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Admin Dashboard</title>
</head>

<body>
        <!--------------------- MAIN ---------------------------->
        <?php
        function getCounts()
        {
            // Include the conn.php file to establish the database connection
            require_once('../function/conn.php');

            $counts = [];

            // Define an array of categories and their associated SQL queries
            $categories = [
                'Students' => "SELECT COUNT(*) as count FROM student_details",
                'Instructors' => "SELECT COUNT(*) as count FROM instructor_details",
                'Subjects' => "SELECT COUNT(*) as count FROM subject_details",
                'Users' => "SELECT COUNT(*) as count FROM user_details"
            ];

            foreach ($categories as $category => $sql) {
                // Execute the SQL query
                $result = $conn->query($sql);

                // Check if the query was successful
                if ($result === false) {
                    die("Query failed for category '$category': " . $conn->$connect_error);
                }
                $row = $result->fetch_assoc();
                $count = $row['count'];
                $counts[$category] = $count;
            }
            $conn->close();

            return $counts;
        }
        ?>

        <!-- CALL FX -->
        <div class="main">
            <div class="cards">
                <?php
                $categoryCounts = getCounts();

                foreach ($categoryCounts as $category => $count) {
                    echo '<div class="card">';
                    echo '<div class="card-content">';
                    echo '<div class="number">' . $count . '</div>';
                    echo '<div class="card-name">' . $category . '</div>';
                    echo '</div>';
                    echo '<div class="icon-box">';

                    // Assign the appropriate icon based on the category
                    switch ($category) {
                        case 'Students':
                            echo '<i class="fas fa-user-graduate"></i>';
                            break;
                        case 'Instructors':
                            echo '<i class="fas fa-chalkboard-teacher"></i>';
                            break;
                        case 'Subjects':
                            echo '<i class="fas fa-book-open"></i>';
                            break;
                        case 'Users':
                            echo '<i class="fas fa-users"></i>';
                            break;
                        default:
                            echo '<i class="fas fa-question"></i>'; // Default icon
                            break;
                    }

                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
            <!--------------------- CHART ---------------------------->
            <div class="charts">
                <div class="chart">
                    <h2>Attendance</h2>
                    <canvas id="barChart"></canvas>
                </div>
                <div class="chart" id="doughnut-chart">
                    <h2>Students</h2>
                    <canvas id="doughnut"></canvas>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        <script src="chart1.js"></script>
        <script src="chart2.js"></script>
</body>

</html>