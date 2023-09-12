<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'instructor') {
    header('Location: ../../not_allowed.php');
    exit();
}
// include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Instructor Dashboard</title>
    <style>
        /* Basic styling for the dashboard */
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #333;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .container {
            margin: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        /* Styling for the sidebar */
        .sidebar {
            float: left;
            width: 20%;
            background-color: #f2f2f2;
            padding: 20px;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
        }

        /* Styling for the main content */
        .content {
            float: left;
            width: 80%;
            padding: 20px;
            background-color: #fff;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Instructor Dashboard</h1>
    </div>

    <div class="container">
        <div class="section">
            <div class="sidebar">
                <h2>Navigation</h2>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Students</a></li>
                    <li><a href="scanner/index.html">Scanner</a></li>
                    <li><a href="#">Profile</a></li>
                </ul>
            </div>
            <div class="content">
                <h2>Welcome, Instructor!</h2>
                <p>This is your instructor dashboard. You can manage courses, view student information, record grades, and update your profile.</p>
            </div>
        </div>
    </div>
</body>
</html>
