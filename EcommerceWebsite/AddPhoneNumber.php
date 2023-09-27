<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $phone = $_POST['phone'];
    $userid = $_SESSION['uid'];

    $stmt = $con->prepare("UPDATE users SET PhoneNumber = ? WHERE UserID = ?");
    $stmt->execute(array($phone, $userid));

     // Redirect to profile.php
     header('Location: profile.php');
     exit;
}
?>







<!DOCTYPE html>
<html>
<head>
    <title>Add Your Number</title>
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
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
        
        .form-container input[type="text"] {
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
            <h1 class="text-center">Add Your Phone Number</h1>
            <form action="AddPhoneNumber.php" method="POST">
                <label for="phone">Phone Number:</label><br>
                <input type="text" id="phone" name="phone" class="form-control" required="required"><br>
                <input type="submit" value="Add Number">
            </form>
        </div>
    </div>
</body>
</html>
