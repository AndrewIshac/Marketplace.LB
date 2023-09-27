<?php 

session_start();

$pageTitle= 'Profile';

 include 'init.php' ; 
 
 if(isset($_SESSION['user'])) {

 $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");

 $getUser->execute(array($sessionUser));

 $info = $getUser->fetch();
$userid = $info['UserID'];
$avatar = '';
if (array_key_exists('avatar', $info) && $info['avatar']) {
    $avatar = 'admin/uploads/avatars/' . $info['avatar']; 
}
?>
<h1 class="text-center">My Profile</h1>

<?php if ($avatar): ?>
<img src="<?php echo $avatar ?>" alt="Profile Picture" style="width:100px;height:100px;display:block;margin:auto;">
<?php else: ?>
<img src="img.png" alt="No Profile Picture Added" style="width:100px;height:100px;display:block;margin:auto;">
<?php endif; ?>

<div class="information block">
   <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">My Information </div>
           <div class="panel-body">
            <ul class="list-unstyled">
               
            <li> 
               <i class="fa fa-unlock-alt fa-fw"></i>
               <span>Login Name</span> : <?php echo $info['Username'] ?> 
            </li>
              <li> 
              <i class="fa fa-envelope-o fa-fw"></i>
               <span>Email</span> : <?php echo $info['Email'] ?> 
            </li>
              <li> 
              <i class="fa fa-users fa-fw"></i>
              <span>Full Name</span> : <?php echo (!empty($info['FullName']) ? $info['FullName'] : 'Not added yet') ?>
            </li>
              <li> 
              <i class="fa fa-calendar fa-fw"></i>
               <span>Register Date</span>: <?php echo $info['Date'] ?> 
            </li>
              <li> 
              <i class="fa fa-tags fa-fw"></i>
               <span>User ID</span>: <?php echo $info['UserID'] ?> 
            </li>
            <?php if (!empty($info['PhoneNumber'])): ?>
                        <li>
                            <i class="fa fa-phone fa-fw"></i>
                            <span>Phone Number</span>: <?php echo $info['PhoneNumber'] ?>
                        </li>
                    <?php endif; ?>
               </ul>
               <a href="EditInfo.php" class="btn btn-default my-button" style="margin-left: 50px;"><strong>Edit Profile Info</strong></a>
               <a href="AddProfilePic.php" class="btn btn-default my-button" style="margin-left: 130px;"><strong>Update Your Profile Picture<strong></a>
               <a href="AddPhoneNumber.php" class="btn btn-default my-button" style="margin-left: 70px;"><strong> Add Phone Number?<strong></a>
               <a href="Manage.php" class="btn btn-default my-button" style="margin-left: 130px;"><strong> Manage My Items <strong></a>
            </div>
    </div>
   </div>
</div>


<div id ="my-ads" class="my-ads block">
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">My Ads</div>
            <div class="panel-body">
                <?php
                $myItems = getAllFrom( "*","items","Where Member_ID = $userid ", "and approve = 1" , "Item_ID" ) ;
                if (!empty($myItems)) {
                    echo '<div class="row">';
                    foreach ($myItems as $item) { ?>
                        
                        <div class="col-sm-6 col-md-3">
    <div class="thumbnail item-box">
        <?php if($item['Approve'] == 0) { echo '<span class="approve-status">Waiting Approval</span>'; } ?>
        <span class="price-tag">$<?php echo $item['Price']; ?></span>

       <!-- check if there is an image for this item -->
<?php if (!empty($item['ItemImage'])): ?>
    <!-- if yes, show the user-uploaded image -->
    <img class="img-responsive" src="admin/uploads/avatars/<?php echo $item['ItemImage']; ?>" alt="" />
<?php else: ?>
    <!-- if not, show the default image -->
    <img class="img-responsive" src="img.png" alt="" />
<?php endif; ?>


        <div class="caption">
            <h3><a href="items.php?itemid=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h3>
            <p><?php echo $item['Description']; ?></p>
            <div class="date"><?php echo $item['Add_Date']; ?></div>
        </div>
    </div>
</div>
                   <?php   }
                    echo '</div>';
                } else {
                    echo 'Sorry There\'s No Ads To Show, Or Items Are Waiting Approval. Create <a href="newad.php">New Ad</a>';
                }
                ?>

    </div>
            </div>
    </div>
   </div>
</div>


<div class="my-comments block">
   <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading">Latest Comments </div>
           <div class="panel-body">
           
<?php 
$myComments =  getAllFrom( "comment","comments"," where user_id = $userid ", "" , " c_id") ;
if(! empty($comments)) {

    foreach ($comments as $comment){
        echo '<p>' . $comment['comment'] . '</p>' ;
    }

} else {
    echo 'There is no comments to show';
}

?>
            </div>
    </div>
   </div>
</div>

<?php

 } else{

    header('Location: login.php');

    exit();
 }



include $tpl.'footer.php' ;

?>


<style>
    .item-box {
    height: 400px; /* Set a fixed height for the item box */
}

.item-box .item-image {
    width: 100%;
    height: 250px; /* Set a fixed height for the image */
    object-fit: cover;
}
</style>


