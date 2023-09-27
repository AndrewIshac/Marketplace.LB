<?php


ob_start();

session_start() ;

if (isset($_SESSION['Username'])) {
   $pageTitle='Dashboard' ;

  include 'init.php';

//start dashboard page

$numUsers = 3;  //nb of latest registered users

$latestUsers = getLatest("*", "users", "UserID", $numUsers);

$numItems = 3; //nb of latest registered items

$latestItems = getLatest("*", "items", "Item_ID", $numItems);

$numComments= 3;


?>

<div class="container home-stats text-center">
<h1>Dashboard</h1>
<div class="row">
  <div class="col-md-3">
<div class="stat st-members"><i class="fa fa-users"></i><div class="info">Total Member<span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span></div></div>
   </div>
   <div class="col-md-3">
<div class="stat st-pending"><i class="fa fa-user-plus"></i><div class="info">Pending Member<span><a href="members.php?do=Manage&page=Pending"><?php echo checkItem("RegStatus", "users", 0) ?></a></span></div></div>
   </div>
   <div class="col-md-3">
<div class="stat st-items"><i class="fa fa-tag"></i><div class="info">Total Item<span><a href="items.php"><?php echo countItem('Item_ID', 'items') ?></a></span></div></div></div>
   
   <div class="col-md-3">
<div class="stat st-comments"><i class="fa fa-comments"></i><div class="info">Total Comments<span><a href="comments.php"><?php echo countComments('c_id', 'comments') ?></a></span></div>
</div>
</div>
   </div>
</div>



</div>

<div class="latest">
<div class="container">
  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">

        <?php //$LatestUsers= 3; //nb of latest users ?> 

        <div class="panel-heading">
          <i class="fa fa-users"></i>Latest <?php echo $numUsers ?> Registered Users
          <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
</div>
         <div class="panel-body">

          <ul class="list-unstyled latest-users">
 <?php 
          //$theLatest = getLatest("*", "users", "UserID", 3);

          if(! empty($latestItems)) {

          foreach ($latestUsers as $user) {
          
            echo '<li>' ;
             echo $user['Username'];
             echo '<i class="fa fa-edit"></i> <a href="members.php?do=Edit&userid=' . $user['UserID'] . '">'; 
             echo '<span class="btn btn-success pull-right">' ;
             echo '<i class="fa fa-edit"></i> Edit' ;
             if ($user['RegStatus'] == 0) {
              echo "<a href='members.php?do=Activate&userid=" .$user['UserID'] . "' class='btn btn-info pull-right activate><i class='fa fa-check'></i>Activate </a>";
            }
             echo '</span>';
             echo '</a>';
             echo '</li>';
          }
          } else {
            echo 'There is no members to show' ;
          }  
  ?>

</ul>
          </div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="panel panel-default">
        <div class="panel-heading">
          <i class="fa fa-tag"></i>Latest <?php echo $numItems ?> Added Items
          <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
</div>
         <div class="panel-body">
         <ul class="list-unstyled latest-users">
 <?php 
          //$theLatest = getLatest("*", "users", "UserID", 3);

          if (! empty($latestItems)) {
          foreach ($latestItems as $item) {
          
            echo '<li>' ;
             echo $item['Item_Name'];
             echo '<i class="fa fa-edit"></i> <a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">'; 
             echo '<span class="btn btn-success pull-right">' ;
             echo '<i class="fa fa-edit"></i> Edit' ;
             if ($item['Approve'] == 0) {
              echo "<a href='items.php?do=Approve&itemid=" .$item['Item_ID'] . "' class='btn btn-info pull-right activate><i class='fa fa-check'></i>Approve </a>";
            }
             echo '</span>';
             echo '</a>';
             echo '</li>';
          }

        } else {
          echo 'There is no items to show' ;
        }
  ?>
</ul>
          </div>
      </div>
    </div>
  </div>

  <!-- start latest comment -->

  <div class="row">
    <div class="col-sm-6">
      <div class="panel panel-default">

        <?php //$LatestUsers= 3; //nb of latest users ?> 

        <div class="panel-heading">
          <i class="fa fa-comments-o"></i>Latest <?php echo $numComments ?> Comments
          <span class="toggle-info pull-right"><i class="fa fa-plus fa-lg"></i></span>
</div>
         <div class="panel-body">
          <?php  
          $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC LIMIT $numComments");
          $stmt->execute();
          
          $comments = $stmt->fetchAll();

          if(! empty($comments)) {

          foreach ($comments as $comment) {
               echo '<div class="comment-box">';
               echo '<span class="member-n">' . $comment['Member'] . '</span>';
               echo '<p class="member-c">' . $comment['comment'] . '</span>';

               echo '</div>' ;
          }

        }else {
          echo 'There is no comments to show' ;
        }
          ?>

          </div>
      </div>
    </div>
   
  </div>

  <!-- end latest comment -->

</div> 
</div>

<?php

//end dashboard page


 //print_r($_SESSION);
  include $tpl.'footer.php' ;
  
} else {

   //echo 'hi' ;

  header('Location: index.php'); // hayde aam teete INTERNAL SERVER ERROR #13 7:49
  
  exit();
}


ob_end_flush();

?>