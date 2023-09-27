<?php
session_start();
include 'init.php';

if (isset($_SESSION['user'])) {
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($_SESSION['user']));
    $info = $getUser->fetch();
    $userid = $info['UserID'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['userid'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $oldpassword = $_POST['oldpassword'];
    $newpassword = $_POST['newpassword'];
    $phone = $_POST['phone'];

    // Get the old password from the database
    $stmt = $con->prepare("SELECT Password FROM users WHERE UserID = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $hashedPassword = $row['Password'];

    // Check if the old password matches the one in the database
    if (password_verify($oldpassword, $hashedPassword)) {
        // Update the password and phone number
        $newHashedPassword = password_hash($newpassword, PASSWORD_DEFAULT);
        $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ?, PhoneNumber = ? WHERE UserID = ?");
        $stmt->execute(array($username, $email, $fullname, $newHashedPassword, $phone, $id));

        // Update session data
        $_SESSION['user'] = $username;
        $_SESSION['uid'] = $id;

        echo "Profile updated successfully!";
    } else {
        echo "Old password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User Information</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: lightgray;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }

        .form-container input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post" action="updateProfile.php">
                <label for="username">Username:</label><br>
                <input type="text" id="username" name="username" value="<?php echo $info['Username']; ?>"><br>
                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email" value="<?php echo $info['Email']; ?>"><br>
                <label for="fullname">Full Name:</label><br>
                <input type="text" id="fullname" name="fullname" value="<?php echo $info['FullName']; ?>"><br>
               
                <label for="password">Current Password:</label><br>
                <input type="password" name="oldpassword" required="required" placeholder="Current password"/><br>
                <label for="password">New Password:</label><br>
                <input type="password" id="password" name="password" placeholder="Enter your new password"><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>


    
    <?php
    include $tpl . 'footer.php';
    ?>
</body>
</html>
