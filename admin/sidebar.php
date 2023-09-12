<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equive="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../assets/images/PSU_logo.png">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <div class="container">
        <!------------------- TOPBAR ------------------------->
        <div class="topbar">
            <div class="PSUlogo">
                <a href="home.php" class="none">
                    <img src="../assets/images/PSU_logo.png" alt="">
                </a>
            </div>
            <div class="logo">
                <h2>PANGASINAN STATE UNIVERSITY</h2>
            </div>
            <div class="search">
                <input type="text" id="search" placeholder="Search here">
                <label for="search"> <i class="fas fa-search"></i></label>
            </div>
            <i class="fas fa-bell"></i>
            <div class="user">
                <a href="../function/logout.php">
                    <img src="../assets/images/user.png" alt="">
                    <!-- <i class="fas fa-th-large"></i> -->
                </a>
            </div>
        </div>

        <!---------------------- SIDEBAR ------------------------->
        <div class="sidebar">
            <!-- <div class="title">
                <h4>Attendance Monitoring System</h4>
            </div> -->
            <ul>
                <li>
                    <a href="home.php">
                        <i class="fas fa-th-large"></i>
                        <div>Dashboard</div>
                    </a>
                </li>
                <li>
                    <a href="instructor.php">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <div>Instructors</div>
                    </a>
                </li>
                <li>
                    <a href="student.php">
                        <i class="fas fa-user-graduate"></i>
                        <div>Students</div>
                    </a>
                </li>
                <li>
                    <a href="subject.php">
                        <i class="fas fa-book-open"></i>
                        <div>Subjects</div>
                    </a>
                </li>
                <li>
                    <a href="user.php">
                        <i class="fas fa-user-friends"></i>
                        <div>Users</div>
                    </a>
                </li>
                <li>
                    <a href="course.php">
                        <i class="fas fa-clipboard"></i>
                        <div>Courses</div>
                    </a>
                </li>
                <!-- <li>
                    <a href="device.php">
                        <i class="fas fa-mobile-alt"></i>
                        <div>Devices</div>
                    </a>
                </li> -->
                <li>
                    <a href="#">
                        <i class="fas fa-cog"></i>
                        <div>Settings</div>
                    </a>
                </li>
            </ul>
        </div>

        <!--------------------- MAIN ---------------------------->

        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
        <script src="chart1.js"></script>
        <script src="chart2.js"></script>
</body>

</html>