<?php 
session_start();

$pageTitle= 'User Profile';

include 'init.php' ; 

if (isset($_GET['user'])) {
    $getUser = $con->prepare("SELECT * FROM users WHERE UserID = ?");
    $getUser->execute(array($_GET['user']));
    $info = $getUser->fetch();
    $avatar = '';
    if (array_key_exists('avatar', $info) && $info['avatar']) {
        $avatar = 'admin/uploads/avatars/' . $info['avatar']; 
    }
?>
<h1 class="text-center"><?php echo $info['Username']; ?>'s Profile</h1>

<?php if ($avatar): ?>
<img src="<?php echo $avatar ?>" alt="Profile Picture" style="width:100px;height:100px;display:block;margin:auto;">
<?php else: ?>
<img src="img.png" alt="No Profile Picture Added" style="width:100px;height:100px;display:block;margin:auto;">
<?php endif; ?>

<div class="information block">
   <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><?php echo $info['Username']; ?>'s Information </div>
           <div class="panel-body">
            <ul class="list-unstyled">
            <li> 
               <i class="fa fa-user fa-fw"></i>
               <span>Username</span> : <?php echo $info['Username'] ?> 
            </li>
            <li> 
               <i class="fa fa-user-circle fa-fw"></i>
               <span>Full Name</span> : <?php echo (!empty($info['FullName']) ? $info['FullName'] : 'Not added yet') ?> 
            </li>
              <li> 
              <i class="fa fa-envelope-o fa-fw"></i>
               <span>Email</span> : <?php echo $info['Email'] ?> 
            </li>
            <li> 
               <i class="fa fa-phone fa-fw"></i>
               <span>Phone Number</span> : <?php echo (!empty($info['PhoneNumber']) ? $info['PhoneNumber'] : 'Not added yet') ?> 
            </li>
              <li> 
              <i class="fa fa-calendar fa-fw"></i>
               <span>Registered Date</span>: <?php echo $info['Date'] ?> 
            </li>
               </ul>
            </div>
    </div>
   </div>
</div>

<?php
} else {
    header('Location: login.php');
    exit();
}

include $tpl.'footer.php' ;
?>


