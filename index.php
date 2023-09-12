<?php
session_start(); 
//for configuration

if (isset($_SESSION['id'])) {
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] == 'admin') {
        header("location: admin/home.php");
    } elseif (!isset($_SESSION['user_role']) || $_SESSION['user_role'] == 'instructor') {
        header("location: public/instructor/instructor_dashboard.php");
    } elseif (!isset($_SESSION['user_role']) || $_SESSION['user_role'] == 'student') {
        header("location: public/student/student_dashboard.php");
    } else {
        echo "Unknown role";
    }
} else {
    
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="assets/images/PSU_logo.png">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #4169E1;
            color: #fff;
            text-align: left;
            padding: 10px;
            display: flex;
            align-items: center;
        }

        .logo {
            width: 6vw;
            margin-right: 5px;
            filter: drop-shadow(2px 2px 4px white);
        }

        .header-text {
            font-family: 'Arial Black', sans-serif;
            font-size: 2.5vw;
            margin-top: 4px;
            line-height: 1;
            white-space: nowrap;
            align-self: center;
        }

        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 100px);
            padding: 20px;
        }

        .login-heading {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .card {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .footer {
            background-color: #4169E1;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 1.5vw;
        }
    </style>
</head>

<body>
    <div class="header">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <h1 class="header-text">Pangasinan State University</h1>
    </div>

    <div class="container">
        <h2 class="login-heading">LOGIN</h2>
        <?php if (isset($_SESSION['message'])) : ?>
            <div class="alert alert-danger mt-3">
                <?php echo $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message']);
              endif; ?>
        <div class="card">
            <form action="function/login.php" method="POST">
                <div class="form-group">
                    <label for="id_number">ID Number:</label>
                    <input type="text" id="id_number" name="id_number" class="form-control" value="<?php echo isset($_SESSION['old']['id_number']) ? $_SESSION['old']['id_number'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <button type="submit">Login</button>
                <button type="reset">Reset</button>
            </form>
        </div>
    </div>

    <div class="footer">
        <p>&copy; 2023 Pangasinan State University. All rights reserved.</p>
    </div>
</body>

</html>
