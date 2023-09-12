<?php
require_once '../assets/library/phpqrcode/qrlib.php'; // Include the qrlib.php file as explained in the previous answers.

// Step 1: Set up your database connection
$host = 'localhost';
$dbname = 'att_app';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Step 2: Fetch data from the database based on a dynamic student_id
$student_id = isset($_POST['student_id']) ? $_POST['student_id'] : 1; // Default to 1 if no student_id is provided

try {
    $stmt = $pdo->prepare("SELECT student_id, student_number, fname, mname, lname FROM student_details WHERE student_id = ?");
    $stmt->execute([$student_id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        die("Data not found!");
    }

    // Combine the fetched columns to form the $text variable
    $text = $data['student_number'];
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}

// Step 3: Generate the QR code and display it when the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    ob_start();
    QRcode::png($text, null, QR_ECLEVEL_L, 10, 4);
    $qrCodeImageData = ob_get_clean();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generated QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #101010;
            color: white;
        }

        .center-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .content-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .qr-code {
            width: 100%;
            max-width: 300px;
        }
    </style>
</head>

<body>
    <div class="center-content">
        <div class="content-box">
            <!-- <form method="post" action="">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id">
                <button type="submit" class="btn btn-primary">Generate QR Code</button>
            </form> -->
        </div>
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
            <div class="content-box">
                <img src="data:image/png;base64,<?php echo base64_encode($qrCodeImageData); ?>" class="qr-code" alt="QR Code">
            </div>
        <?php endif; ?>
        <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
    </div>
</body>

</html>
