<?php 
session_start();
include 'init.php' ; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $password = $_POST['password']; // hash password for security
    $HashedPass = sha1($password);

    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($_SESSION['user']));
    $info = $getUser->fetch();
    $userid = $info['UserID'];

    $stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");
    $stmt->execute(array($username, $email, $fullname, $HashedPass, $userid));
    
    // Update session variable if username is changed
    if($username !== $_SESSION['user']) {
        $_SESSION['user'] = $username;
    }

    header('Location: Profile.php');
    exit();
} else {
    header('Location: EditInfo.php');
    exit();
}
?>