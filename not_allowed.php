<!DOCTYPE html>
<html>
<head>
    <title>You're Not Allowed</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #2e3b4e;
            color: #f7f7f7;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        h1 {
            color: #ffa07a; /* Light Salmon color */
            font-size: 2.5em;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.2em;
            text-align: center;
            max-width: 70%;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        a {
            background: transparent;
            border: 2px solid #ffa07a;
            color: #ffa07a;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            font-size: 1em;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #ffa07a; /* Light Salmon color */
            color: #2e3b4e;
        }

        /* Adding a subtle animation to the body for a soft intro */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        body {
            animation: fadeIn 1s ease-in-out;
        }

    </style>
</head>
<body>
    <div>
        <h1>You're Not Allowed</h1>
        <p>Sorry, but you don't have permission to access this page.</p>
        <a href="javascript:history.back()">Go Back</a>
    </div>
</body>
</html>
