<?php
session_start();

// Check if the user is logged in and has student access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'student') {
    header('Location: ../../not_allowed.php');
    exit();
}

// Check if the student ID is set in the session
if (!isset($_SESSION['id_number'])) {
    // Redirect or handle the case where the student ID is not set
    // You can redirect the user to an error page or perform some other action
    // For example, you can redirect them to the login page if they are not properly authenticated
    header('Location: ../../index.php');
    exit();
}

// Get the student ID from the session
$studentId = $_SESSION['id_number'];

// Include your database connection code or configuration here
// For example, you might have something like:
// include('db_connection.php');

// Assuming you have a function to fetch student details from the database
// Replace this with your actual database query logic
function fetchStudentDetails($studentId)
{
    // Connect to your database and perform the query
    // Replace the following with your database query code
    require_once('../../function/conn.php');

    $studentId = mysqli_real_escape_string($conn, $studentId); // Ensure safe query

    $sql = "SELECT student_id, lname, fname, mname, student_number FROM student_details WHERE student_number = '$studentId'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        mysqli_close($conn); // Close the database connection

        if ($row) {
            return $row;
        }
    }

    // Debugging output
    echo 'Student ID: ' . $studentId . '<br>';
    echo 'SQL Query: ' . $sql . '<br>';
    die('Error fetching student details');
}

// Get student details from the database
$studentDetails = fetchStudentDetails($studentId);

// Initialize variables with default values
$id = '';
$lastName = '';
$firstName = '';
$middleName = '';
$studentNumber = '';

// Check if student details were found
if ($studentDetails) {
    $id = $studentDetails['student_id'];
    $lastName = $studentDetails['lname'];
    $firstName = $studentDetails['fname'];
    $middleName = $studentDetails['mname'];
    $studentNumber = $studentDetails['student_number'];
}

// Rest of your HTML and PHP code here
?>
<!DOCTYPE html>
<html>

<head>
    <title>Student Dashboard</title>
    <!-- Your CSS and other HTML code -->
</head>

<body>
    <div class="header">
        <h1>Student Dashboard</h1>
    </div>

    <div class="container">
        <div class="section">
            <div class="sidebar">
                <!-- Navigation links -->
            </div>
            <div class="content">
                <h2>Welcome, Student (ID: <?php echo $studentId; ?>)!</h2>
                <p>Your Student Number: <?php echo $studentNumber; ?></p>
                <p>Name: <?php echo "$lastName, $firstName $middleName"; ?></p>
                <p>This is your student dashboard. You can view your courses, assignments, grades, and update your profile.</p>
                <form action="../../function/generate.php" method="POST">
                <input id="student_id" name="student_id" value="<?php echo $id; ?>"hidden>
                <button type="submit" name="save_subject" class="btn btn-primary">qr code</button>
                </form>
            </div>
        </div>

        <!-- Additional sections for course listing, assignment details, grade information, etc. -->
    </div>
</body>

</html>