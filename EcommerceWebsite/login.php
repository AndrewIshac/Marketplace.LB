<?php 
ob_start();
session_start() ;

$pageTitle = 'Login' ;

if (isset($_SESSION['user'])) {
    header('Location: index.php'); //Redirect to dasdhboard page
}

include 'init.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $defaultAvatar='img.png';

    $HashedPass = sha1($pass);

    //Check if the user is in the database 
    //GroupID = 1 means Admin. If GroupID = 0 means user.
    $statement = $con->prepare("SELECT UserID, Username, Password, avatar FROM users WHERE Username = ? AND Password = ?");
    
    $statement->execute(array($user, $HashedPass));

    $get = $statement->fetch();
    
    $count = $statement->rowCount();

    //Check if count > 0 means the database contains record about this username => Admin.

    if ($count > 0) {
      $_SESSION['user'] = $user; //Register name of the session.

      $_SESSION['uid'] = $get['UserID']; //Register User ID In Session

        $avatar = $get['avatar'];

        if ($avatar != '') {
                $_SESSION['avatar'] = $avatar; // Assign the avatar to the session variable
              } else {
                $_SESSION['avatar'] = $defaultAvatar; // Use the default avatar if the user doesn't have one
              }

      //print_r($_SESSION);
      header('Location: index.php'); //Take me to dashboard page
       exit();
    } 
    else {
        // password is incorrect
        $formErrors[] = 'The Username or password you have entered is incorrect.';
    }

} else {


$formErrors = array();

$username = $_POST['username'] ;
$password = $_POST['password'] ;
$password2 = $_POST['password2'] ;
$email = $_POST['email'] ;

if (isset($username)) {
   $filterdUser = filter_var($username, FILTER_SANITIZE_SPECIAL_CHARS);
   if (strlen($filterdUser) < 3 )  {
        $formErrors[] = 'Username Must Be Larger Than 3 Characters';
   }
}
if (isset($password) && isset($password2)) {

        if (empty($password)){
                $formErrors[]= 'Sorry Password Cant Be Empty';
                
                       }

        $pass1 = sha1($password);
        $pass2 = sha1($password2);
         
       if (sha1($password) !== sha1($password2)){
$formErrors[]= 'Sorry Password Does Not Match';

       }

       

     }

     if (isset($email)) {
        $filterdEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
        if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true )  {
             $formErrors[] = 'This Email Is Not Valid ';
        }
     }

      //if no error do Add

      if (empty($formErrors)){

        //Check if user exist alrdy in database

        $check = checkItem("Username", "users", $username);

        if ($check == 1){

                $formErrors[] = 'Sorry This User Already Exist ';
             
        } else {

        

   //Insert User Info To The Database
   // eza regstatus 1 yeene l admin zeydo lal user.

 $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, RegStatus, Date)
                                    VALUES(:zuser, :zpass, :zmail, 0, now())");
 
 $stmt->execute(array(

   'zuser' => $username,
   'zpass' => $pass1,
   'zmail' => $email


 ));
 
 //Echo Success Message

$succesMsg = 'Congrats You Are Now Registered User';


}
 
}
}

}

?>

   <div class="container login-page">

<h1 class="text-center">
<span class="selected" data-class="login">Login</span> | <span data-class="signup">Signup</span></h1>

<!-- Start Login -->

      <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="input-container">
 <input class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" required />  
</div>
        
 <div class="input-container">
    <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type your password" required /> 
</div>
        <input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
        
</form>

<!-- End Login Form -->

<!-- start sign up form -->

<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" >
<div class="input-container">
        <input pattern=".{3,}" title="Username must be at least 3 characters" class="form-control" type="text" name="username" autocomplete="off" placeholder="Type your username" required />
</div>
<div class="input-container">
        <input minlength="3" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Type A Complex Password"  required/>
</div>
<div class="input-container">
        <input minlength="3" class="form-control" type="password" name="password2" autocomplete="new-password" placeholder="Confirm Your Password" required />
</div>
<div class="input-container">
        <input class="form-control" type="email" name="email" placeholder="Type A Valid Email"  />
</div>
        <input class="btn btn-success btn-block" name="signup" type="submit" value="Signup" />
        
</form>

<!-- End Sign up Form -->
<div class="the-errors text-center">
<?php 
if (!empty($formErrors)){
   foreach ($formErrors as $error) {
    echo '<div class="msg error">' . $error . '</div>';
   }
        
}

if (isset($successMsg)) {

        echo '<div class="msg success">' . $successMsg . '</div>';
}




?>


</div>

</div>

<!DOCTYPE html>
<html>
<head>
  <!-- ... your other head tags ... -->
  <style>
    body {
        background : #333;
      /*background: url('admin/uploads/avatars/image500.jpg') no-repeat center center fixed;  */
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
    }
  </style>
</head>
<body>
  <!-- ... your PHP and HTML code ... -->
</body>
</html>




<?php
include $tpl . 'footer.php' ;
ob_end_flush();



?>