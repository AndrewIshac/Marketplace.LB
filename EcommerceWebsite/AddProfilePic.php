<?php

session_start();

include 'init.php' ; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $image = $_FILES['avatar'];

    // Set upload directory
    $uploadDirectory = 'admin/uploads/avatars/';

    // Use time() to ensure unique filename
    $imageName = time() . '_' . $image['name'];

    $uploadPath = $uploadDirectory . basename($imageName); 

    if (move_uploaded_file($image['tmp_name'], $uploadPath)) {
        // Update the database
        $stmt = $con->prepare("UPDATE users SET avatar = ? WHERE Username = ?");
        $stmt->execute(array($imageName, $_SESSION['user']));

        $_SESSION['avatar'] = $imageName;

        // Redirect back to profile.php
        header('Location: profile.php');
        exit;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>

<!-- HTML Form -->

<h1 class="text-center">Update Your Profile Pic</h1>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Profile Picture</title>
    <style>
        .form-group {
            text-align: center;
        }
        input[type="submit"] {
            margin: auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            border: none;
            color: white;
            text-decoration: none;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="AddProfilePic.php" method="POST" enctype="multipart/form-data">
        <div class="form-group form-group-lg">
            <label class="col-sm-4 control-label"></label>
            <div class ="col-sm-10 col-md-4">
                <input type="file" name="avatar" class="form-control" required="required" />
                <input type="submit" value="Upload">
            </div>
        </div>
    </form>
</body>
</html>

