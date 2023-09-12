<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">QR Code Scanner</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div id="qr-code-scanner"></div>
                <div id="result" class="mt-3"></div>
                <!-- <button id="stopButton" class="btn btn-danger mt-3">Stop Scanner</button> -->
            </div>
        </div>
    </div>

    <script src="../../../node_modules/html5-qrcode/html5-qrcode.min.js"></script>
    <script>
        <?php
        if (isset($_GET['subject_id'])) {
            $subject_id = $_GET['subject_id'];
            echo "window.subjectId = $subject_id;"; 
        } else {
            echo "window.subjectId = null;"; 
        }
        ?>
    </script>
    <script src="script.js"></script>


</body>

</html>