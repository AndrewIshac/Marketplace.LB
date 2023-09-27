<?php

//this page to edit/delete/approve comments.

ob_start();

session_start() ;

$pageTitle = 'Comments';

if (isset($_SESSION['Username'])) {
   
     
  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'  ;

 //start Manage Page

  if ($do == 'Manage') { //Manage Member Page 


  include $tpl.'footer.php' ;   
  
 // Select all users except Admin

  $stmt = $con->prepare("SELECT comments.*, items.Item_Name AS Item_Name, users.Username AS Member FROM comments INNER JOIN items ON items.Item_ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC");
  $stmt->execute();

  $comments = $stmt->fetchAll();

  if(! empty($comments)) {

  
  
  ?>

<h1 style = "position:relative; left:270px;">Manage Comments</h1>

<div class="container">
<div class="table-responsive">
     <table class="main-table text-center table table-bordered">
  <tr>
     <td>ID</td>
     <td>Comment</td>
     <td>Item Name</td>
     <td>User Name</td>
     <td>Added Date</td>
     <td>Control</td>
 </tr>



<?php

foreach($comments as $comment) {
     echo "<tr>";
        echo "<td>" .  $comment['c_id'] . "</td>" ;
        echo "<td>" .  $comment['comment'] . "</td>" ;
        echo "<td>" .  $comment['Item_Name'] . "</td>" ;
        echo "<td>" .  $comment['Member'] . "</td>" ;
        echo "<td>" .  $comment['comment_date'] . "</td>" ;
        echo "<td>
        <a href='comments.php?do=Edit&comid=" .$comment['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
        <a href='comments.php?do=Delete&comid=" .$comment['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete </a>";
        
        if ($comment['status'] == 0) {
          echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id'] . "' class='btn btn-info activate><i class='fa fa-check'></i>Approve </a>";
        }
        
        
        echo "</td>" ;
        echo "</tr>";

}
?>

 <tr>
    
</table>
  </div>

  </div>

  <?php } else {
     echo '<div class= "container">';
         echo '<div class="nice-message">There is no comments to show</div>' ;
        
                echo '</div>';
}  ?>
 
 
 <?php } 

  
  elseif ($do == 'Edit'){  //Edit page

    //echo intval($_GET['userid']);
    
    $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0;
    
    $statement = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
        
        $statement->execute(array($comid));
        $row = $statement->fetch();
        $count = $statement->rowCount();

        if($statement->rowCount() > 0 ) {    ?>
<h1 style = "position:relative; left:270px;">Edit Comment</h1>

<div class="container">
     <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="comid" value="<?php echo $comid ?>" />
      <!-- Start Comment Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Comment</label>
               <div class ="col-sm-10 col-md-6">
                <textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
               </div>
          </div>
          <!-- End Comment Field -->

          <!-- Start Submit Field -->
          <div class="form-group form-group-lg">
               
               <div class ="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save" class="btn btn-primary btn-lg" />
               </div>
          </div>
          <!-- End Submit Field -->
     </form>
  </div>

<?php 
        }
        else{

          echo "<div class='container'>";
     $theMsg= '<div class="alert alert-danger">There is no such ID</div>';

        redirectHome($theMsg);

        echo "</div>";


        }

        include $tpl.'footer.php' ;

  } elseif($do == 'Update') {  //Update Page

     
     echo "<h1 class='text-center'>Update Comment</h1>" ;
     echo "<div class='container'>";

     if($_SERVER['REQUEST_METHOD'] == 'POST') {

          //get variables from the form

          $comid      = $_POST['comid'];
          $comment     = $_POST['comment'];

         
          //if no error do Update



            //Update the database with thus info

          $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
          $stmt->execute(array($comment, $comid));

          //Echo Success Message

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
              
          //$errorMsg= 'Sorry you cant browse this page directly' ;

          redirectHome($theMsg, 'back', 4);

     

 } else {

          $theMsg ='<div class="alert alert-danger">Sorry you cant browse this page directly</div>' ;
          redirectHome($theMsg);
     }
 
     echo "</div>" ;
  

  
  include $tpl.'footer.php' ;

  

}
elseif ($do == 'Delete') {
//Delete Page

include $tpl.'footer.php' ;

echo "<h1 class='text-center'>Delete Comment</h1>" ;
     echo "<div class='container'>";

     $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('c_id', 'comments', $comid);
     

         
         //$statement->execute(array($userid));
         //$row = $statement->fetch();
         //$count = $statement->rowCount();
 
         if($check > 0 ) {
              $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

              $stmt->bindParam(":zid", $comid);

              $stmt->execute();

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted';

              redirectHome($theMsg, 'back');         
          } 


         

         else {

          
          $theMsg= '<div class="alert alert-danger">this id does not exist</div>';
          redirectHome($theMsg);  
          

         }
     }

   elseif ($do == 'Approve') {
         
     include $tpl.'footer.php' ;

          echo "<h1 class='text-center'>Approve Comment</h1>" ;
     echo "<div class='container'>";

     $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval ($_GET['comid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('c_id', 'comments', $comid);
     

         
         //$statement->execute(array($userid));
         //$row = $statement->fetch();
         //$count = $statement->rowCount();
 
         if($check > 0 ) {
              $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

              $stmt->execute(array($comid));

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Approved';

              redirectHome($theMsg, 'back');         
          } 


         

         else {

          
          $theMsg= '<div class="alert alert-danger">this id does not exist</div>';
          redirectHome($theMsg);  
          

         }

         }


          echo '</div>' ;


          include $tpl.'footer.php' ;

}



 else {

   

  header('Location: index.php'); // hayde aam teete INTERNAL SERVER ERROR #13 7:49
  
  exit();
}

