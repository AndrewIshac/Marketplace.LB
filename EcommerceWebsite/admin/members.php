<?php

//this page to edit/delete/add members.

ob_start();

session_start() ;

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
   
     
  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'  ;

 //start Manage Page

  if ($do == 'Manage') { //Manage Member Page 

    $query='';

    if(isset($_GET['page']) && $_GET['page'] == 'Pending') {

        $query = 'AND RegStatus = 0' ;
    }




  include $tpl.'footer.php' ;   
  
 // Select all users except Admin

  $stmt = $con->prepare("SELECT * FROM users WHERE GroupID !=1 $query ORDER BY UserID DESC");
  $stmt->execute();

  $rows = $stmt->fetchAll();

  if(! empty($rows)) {
  
  ?>

<h1 style = "position:relative; left:270px;">Manage Members</h1>

<div class="container">
<div class="table-responsive">
     <table class="main-table manage-members text-center table table-bordered">
  <tr>
     <td>#ID</td>
     <td>Avatar</td>
     <td>Username</td>
     <td>Email</td>
     <td>Full Name</td>
     <td>Registered Date</td>
     <td>Control</td>
 </tr>

<?php

foreach($rows as $row) {
     echo "<tr>";
        echo "<td>" .  $row['UserID'] . "</td>" ;

        echo "<td>";
        if (empty($row['avatar'])){
          echo 'No Image' ;
        } else {
        echo "<img src='uploads/avatars/" .  $row['avatar'] . "' alt='' />";
        }
        echo "</td>" ;

        echo "<td>" .  $row['Username'] . "</td>" ;
        echo "<td>" .  $row['Email'] . "</td>" ;
        echo "<td>" .  $row['FullName'] . "</td>" ;
        echo "<td>" .  $row['Date'] . "</td>" ;
        echo "<td>
        <a href='members.php?do=Edit&userid=" .$row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
        <a href='members.php?do=Delete&userid=" .$row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete </a>";
        
        if ($row['RegStatus'] == 0) {
          echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' class='btn btn-info activate><i class='fa fa-check'></i>Activate </a>";
        }
        
        
        echo "</td>" ;
        echo "</tr>";

}
?>

 <tr>
    
</table>
  </div>

<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>
  </div>
 

  <?php } else {
     echo '<div class= "container">';
         echo '<div class="nice-message">There is no members to show</div>' ;
        echo '<a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Member</a>' ;
                echo '</div>';
}  
  ?>  
     

 
 
 <?php } 

  //start Add Page

  elseif ($do == 'Add'){ 
     
     include $tpl.'footer.php' ;
  
  ?>

<h1 style = "position:relative; left:270px;">Add New Member</h1>

<div class="container">
     <form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
          
      <!-- Start Username Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Username</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login To Shop" />
               </div>
          </div>
          <!-- End Username Field -->

          <!-- Start Password Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Password</label>
               <div class ="col-sm-10 col-md-6">
                <input type="password" name="password" class="password form-control" autocomplete="new-password" required="required" placeholder="Password Must Be Complex" />
                <i class="show-pass fa fa-eye fa-2x"></i>
               </div>
          </div>
          <!-- End Password Field -->

          <!-- Start Email Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Email</label>
               <div class ="col-sm-10 col-md-6">
                <input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />
               </div>
          </div>
          <!-- End Email Field -->

          <!-- Start Full Name Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Full Name</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appears In Your Profile Page " />
               </div>
          </div>
          <!-- End Full Name Field -->

          <!-- Start Avatar Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">User Avatar</label>
               <div class ="col-sm-10 col-md-6">
                <input type="file" name="avatar" class="form-control" required="required" />
               </div>
          </div>
          <!-- End Avatar Field -->

          <!-- Start Submit Field -->
          <div class="form-group form-group-lg">
               
               <div class ="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
               </div>
          </div>
          <!-- End Submit Field -->
     </form>
  </div>

  <?php  }

  elseif ($do == 'Insert'){

   //echo $_POST['username'] . $_POST['password'] . $_POST['email'] . $_POST['full'] ;
   include $tpl.'footer.php' ;

   if($_SERVER['REQUEST_METHOD'] == 'POST') {

     echo "<h1 class='text-center'>Insert Member</h1>" ;
     echo "<div class='container'>";

     //Upload variables



     $avatarName = $_FILES['avatar']['name'];
     $avatarSize = $_FILES['avatar']['size'];
     $avatarTmp  = $_FILES['avatar']['tmp_name'];
     $avatarType = $_FILES['avatar']['type'];

     //List of Allowed type files to upload

     $avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

     // Get Avatar Extension

     

      $avatarExtension = strtolower(end(explode('.', $avatarName)));

      


        //get variables from the form

        $user     = $_POST['username'];
        $pass     = $_POST['password'];
        $email    = $_POST['email'];
        $name     = $_POST['full'];

        $hashPass = sha1($_POST['password']);

  

        //Validate the form

        $formErrors = array();
        
        if (strlen($user) < 4){

             $formErrors[] = '<div class="alert alert-danger">Username cant be smaller than <strong>4 characters</strong> </div>' ;
        }
        if (strlen($user) > 20){

             $formErrors[] = 'Username cant be longer than <strong>20 characters</strong>' ;
        }

        if (empty($user)) {

             $formErrors[] = 'Username cant be <strong>empty</strong> ' ;
        }

        if (empty($pass)) {

          $formErrors[] = 'Password cant be <strong>empty</strong> ' ;
     }

        if (empty($name)) {

             $formErrors[] = 'FullName cant be <strong>empty</strong> ' ;
        }
        if (empty($email)) {

             $formErrors[] = 'Email cant be <strong>empty</strong> ' ;
        }

        if (!empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)){
          $formErrors[] = 'This Extension Is Not <strong>Allowed</strong> ' ;
      }

        if (empty($avatarName)){
          $formErrors[] = 'Avatar Is <strong>Required</strong> ' ;
      }

      if ($avatarSize > 4194304){
          $formErrors[] = 'Avatar Cant Be Larger Than <strong>4MB</strong> ' ;
      }

        foreach ($formErrors as $error) {
             echo '<div class="alert alert-danger">' . $error. '<br/>' . '</div>'  ;
        }

         // hayde l bracket ymkn mahala ghalat.

       
        //if no error do Update

          if (empty($formErrors)){

               $avatar = rand(0, 10000000000) . '_' . $avatarName;

               move_uploaded_file($avatarTmp, "uploads\avatars\\" . $avatar);

               //Check if user exist alrdy in database

               $check = checkItem("Username", "users", $user);

               if ($check == 1){

                    $theMsg = '<div class="alert alert-danger">Sorry this user already exist</div>' ;
                    redirectHome($theMsg, 'back');
                    
               } else {

               

          //Insert User Info To The Database
          // eza regstatus 1 yeene l admin zeydo lal user.

        $stmt = $con->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus, Date, avatar)
                                           VALUES(:zuser, :zpass, :zmail, :zname, 1, now(), :zavatar) ");
        
        $stmt->execute(array(

          'zuser' => $user,
          'zpass' => $hashPass,
          'zmail' => $email,
          'zname' => $name,
          'zavatar' => $avatar

        ));
        
        //Echo Success Message

        $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted';

        redirectHome($theMsg, 'back');


   }

} else {


     echo "<div class='container'>";
     $theMsg= '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';

        redirectHome($theMsg, 'back');

        echo "</div>";
   }

   echo "</div>" ;
   

  }

}
  
  elseif ($do == 'Edit'){  //Edit page

    //echo intval($_GET['userid']);
    
    $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0;
    
    $statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");
        
        $statement->execute(array($userid));
        $row = $statement->fetch();
        $count = $statement->rowCount();

        if($statement->rowCount() > 0 ) {    ?>
<h1 style = "position:relative; left:270px;">Edit Member</h1>

<div class="container">
     <form class="form-horizontal" action="?do=Update" method="POST">
          <input type="hidden" name="userid" value="<?php echo $userid ?>" />
      <!-- Start Username Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Username</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required" />
               </div>
          </div>
          <!-- End Username Field -->

          <!-- Start Password Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Password</label>
               <div class ="col-sm-10 col-md-6">
                <input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>" />
                <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave blank if you dont want to change" />
               </div>
          </div>
          <!-- End Password Field -->

          <!-- Start Email Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Email</label>
               <div class ="col-sm-10 col-md-6">
                <input type="email" name="email" value="<?php echo $row['Email'] ?>" class="form-control" required="required" />
               </div>
          </div>
          <!-- End Email Field -->

          <!-- Start Full Name Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Full Name</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="full" value="<?php echo $row['FullName'] ?>" class="form-control" required="required" />
               </div>
          </div>
          <!-- End Full Name Field -->

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

     
     echo "<h1 class='text-center'>Update Member</h1>" ;
     echo "<div class='container'>";

     if($_SERVER['REQUEST_METHOD'] == 'POST') {

          //get variables from the form

          $id       = $_POST['userid'];
          $user     = $_POST['username'];
          $email    = $_POST['email'];
          $name     = $_POST['full'];

          //Password section
          
          $pass= empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']) ;  

          //Validate the form

          $formErrors = array();
        
        if (strlen($user) < 4){

             $formErrors[] = '<div class="alert alert-danger">Username cant be smaller than <strong>4 characters</strong> </div>' ;
        }
        if (strlen($user) > 20){

             $formErrors[] = 'Username cant be longer than <strong>20 characters</strong>' ;
        }

        if (empty($user)) {

             $formErrors[] = 'Username cant be <strong>empty</strong> ' ;
        }
        if (empty($name)) {

             $formErrors[] = 'FullName cant be <strong>empty</strong> ' ;
        }
        if (empty($email)) {

             $formErrors[] = 'Email cant be <strong>empty</strong> ' ;
        }

        foreach ($formErrors as $error) {
             echo '<div class="alert alert-danger">' . $error. '<br/>' . '</div>'  ;
        }

           // hayde l bracket ymkn mahala ghalat.

         
          //if no error do Update

            if (empty($formErrors)){

              $stmt2 = $con->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");

              $stmt2->execute(array($user, $id));

              $count= $stmt2->rowCount();

              if ($count == 1) {

               echo '<div class="alert alert-danger">Sorry this user already exist </div>' ;

               redirectHome($theMsg, 'back');

              } else {

               //Update the database with thus info

          $stmt = $con->prepare("UPDATE users SET Username = ?, Email= ?, FullName= ?, Password= ? WHERE UserID = ?");
          $stmt->execute(array($user, $email, $name, $pass, $id));

          //Echo Success Message

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
              
          //$errorMsg= 'Sorry you cant browse this page directly' ;

          redirectHome($theMsg, 'back', 4);
              }


     }

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

echo "<h1 class='text-center'>Delete Member</h1>" ;
     echo "<div class='container'>";

     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('userid', 'users', $userid);
     echo $check;

         
         //$statement->execute(array($userid));
         //$row = $statement->fetch();
         //$count = $statement->rowCount();
 
         if($check > 0 ) {
              $stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

              $stmt->bindParam(":zuser", $userid);

              $stmt->execute();

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted';

              redirectHome($theMsg);         
          } 


         

         else {

          
          $theMsg= '<div class="alert alert-danger">this id does not exist</div>';
          redirectHome($theMsg);  
          

         }
     }

   elseif ($do == 'Activate') {
         
     include $tpl.'footer.php' ;

          echo "<h1 class='text-center'>Activate Member</h1>" ;
     echo "<div class='container'>";

     $userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval ($_GET['userid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('userid', 'users', $userid);
     echo $check;

         
         //$statement->execute(array($userid));
         //$row = $statement->fetch();
         //$count = $statement->rowCount();
 
         if($check > 0 ) {
              $stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

              $stmt->execute(array($userid));

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated';

              redirectHome($theMsg);         
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



ob_end_flush();