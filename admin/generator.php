<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="mb-4">Generate QR Code</h2>
        <form action="../function/generate.php" method="POST">
            <div class="form-group">
                <label for="student_id">Select a Student:</label>
                <select id="student_id" name="student_id" class="form-control">
                    <option value="" disabled selected>Select a student...</option>
                    <?php
                    require_once '../assets/library/phpqrcode/qrlib.php';

                    $host = 'localhost';
                    $dbname = 'att_app';
                    $username = 'root';
                    $password = '';

                    try {
                        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                        $stmt = $pdo->query("SELECT student_id, student_number, fname, mname, lname FROM student_details");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['student_id']}'>{$row['student_number']} - {$row['fname']} {$row['lname']}</option>";
                        }
                    } catch (PDOException $e) {
                        die("Database connection failed: " . $e->getMessage());
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generate QR Code</button>
        </form>

    </div>
</body>

</html>