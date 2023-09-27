<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';

if (isset($_SESSION['Username'])) {
    // header('Location: dashboard.php'); //Take me to the dashboard page automatically.
}

include 'init.php';

// Check if the user is coming from an HTTP POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $HashedPass = sha1($password);

    // Check if the user is in the database
    // GroupID = 1 means Admin. If GroupID = 0 means user.
    $statement = $con->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");

    $statement->execute(array($username, $HashedPass));
    $row = $statement->fetch();
    $count = $statement->rowCount();

    // Check if count > 0 means the database contains a record about this username => Admin.
    if ($count > 0) {
        $_SESSION['Username'] = $username; // Register the name of the session.
        $_SESSION['ID'] = $row['UserID']; // Register the session ID
        header('Location: dashboard.php'); // Take me to the dashboard page
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css"> <!-- Include your custom CSS file here -->
    <style>
        body {
            background: #333;
        }
        .login {
            max-width: 400px;
            margin: 0 auto;
            padding: 40px;
            background: #fff;
            border-radius: 8px;
            margin-top: 100px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }
        .login h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }
        .login input[type="text"],
        .login input[type="password"] {
            width: 100%;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #f5f5f5;
            font-size: 16px;
            color: #333;
        }
        .login input[type="text"]:focus,
        .login input[type="password"]:focus {
            outline: none;
            background-color: #eaeaea;
        }
        .login .btn-block {
            width: 100%;
            padding: 12px;
            background: #3498db;
            border: none;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            text-transform: uppercase;
        }
        .login .btn-block:hover {
            background: #2980b9;
        }
        .login .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <h2>Admin Login</h2>
        <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && $count === 0) {
                echo '<p class="error-message">Username or password is incorrect.</p>';
            }
        ?>
        <input type="text" name="user" placeholder="Username" autocomplete="off" required />
        <input type="password" name="pass" placeholder="Password" autocomplete="new-password" required />
        <input class="btn-block" type="submit" value="Login" />
    </form>
</body>
</html>

