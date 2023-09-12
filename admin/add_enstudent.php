<?php
session_start();

// Check if the user is logged in and has admin access
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../not_allowed.php');
    exit();
}
// include('sidebar.php');
?>
<!DOCTYPE html>
<html>

<head>
    <title>Class List Upload</title>
</head>

<body>
    <div style="margin-top: 50px; text-align: center;">
        <h1>Class List Data Upload</h1>
        <div style="width: 300px; margin: 0 auto; border: 1px solid #ccc; padding: 20px;">
        <?php
                if (isset($_GET['subject_id'])) {
                    $subjectId = $_GET['subject_id'];
                ?>
                    
            <form action="../function/process_upload.php?subject_id=<?php echo $subjectId; ?>" method="POST" enctype="multipart/form-data">
                <label for="fileToUpload">Select file to upload:</label>
                <input type="file" name="import_file" id="fileToUpload" required>
                <button type="submit" name="submit">Upload File</button>
            </form>
        <?php } ?> 
        </div>
    </div>
</body>

</html>
