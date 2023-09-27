<?php


ob_start();

session_start() ;

$pageTitle = 'Members';

if (isset($_SESSION['Username'])) {
   
     
  include 'init.php';

  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage'  ;


  if ($do == 'Manage') { //Manage Member Page 

     
  include $tpl.'footer.php' ;   
  
  $stmt = $con->prepare("SELECT items.*, categories.Name AS category_name, users.Username FROM items
                         INNER JOIN categories ON categories.ID = items.Cat_ID
                         INNER JOIN users ON users.UserID = items.Member_ID ORDER BY Item_ID DESC");
  $stmt->execute();

  $items = $stmt->fetchAll();

  if(! empty($items)) {

  
  
  ?>

<h1 style = "position:relative; left:270px;">Manage Items</h1>

<div class="container">
<div class="table-responsive">
     <table class="main-table text-center table table-bordered">
  <tr>
     <td>#ID</td>
     <td>Name</td>
     <td>Description</td>
     <td>Price</td>
     <td>Adding Date</td>
     <td>Category</td>
     <td>Username</td>
     <td>Control</td>
 </tr>

<?php

foreach($items as $item) {
     echo "<tr>";
        echo "<td>" .  $item['Item_ID'] . "</td>" ;
        echo "<td>" .  $item['Item_Name'] . "</td>" ;
        echo "<td>" .  $item['Description'] . "</td>" ;
        echo "<td>" .  $item['Price'] . "</td>" ;
        echo "<td>" .  $item['Add_Date'] . "</td>" ;
        echo "<td>" .  $item['category_name'] . "</td>" ;
        echo "<td>" .  $item['Username'] . "</td>" ;
        echo "<td>
        <a href='items.php?do=Edit&itemid=" .$item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
        <a href='items.php?do=Delete&itemid=" .$item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete </a>";
        
        if ($item['Approve'] == 0) {
          echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . "' class='btn btn-info activate><i class='fa fa-check'></i> Approve </a>";
        }
        
        
        echo "</td>" ;
        echo "</tr>";

}
?>

 <tr>
    
</table>
  </div>

<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>
  </div>
 

    
  <?php } else {
     echo '<div class= "container">';
         echo '<div class="nice-message">There is no items to show</div>' ;
        echo '<a href="items.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i>New Item</a>' ;
                echo '</div>';
}  
  ?>  

 
 
 <?php


   } elseif ($do == 'Add') { ?>

    <h1 style = "position:relative; left:270px;">Add New Item</h1>

<div class="container">
     <form class="form-horizontal" action="?do=Insert" method="POST">
          
      <!-- Start name Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Item Name" />
               </div>
          </div>
          <!-- End Name Field -->

           <!-- Start Description Field -->
           <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Description</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required" placeholder="Item Description" />
               </div>
          </div>
          <!-- End Description Field -->

          <!-- Start Price Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Price</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="price" class="form-control" required="required" placeholder="Item Price" />
               </div>
          </div>
          <!-- End Price Field -->

          <!-- Start Country Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Country</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="country" class="form-control" required="required" placeholder="Item Country" />
               </div>
          </div>
          <!-- End Country Field -->

          <!-- Start Status Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Status</label>
               <div class ="col-sm-10 col-md-6">
                <select name="status"> 
                    <option value="1">New</option>
                    <option value="2">Like New</option>
                    <option value="3">Used</option>
                    <option value="4">Very Old</option>
                </select>
               </div>
          </div>
          <!-- End Status Field -->

          <!-- Start Member Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Member</label>
               <div class ="col-sm-10 col-md-6">
                <select name="member"> 
                    
                    <?php
                    $AllMembers = getAllFrom("*", "users", "", "", "UserID");
                     
                     foreach ($AllMembers as $user) {
                         
                              echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
                         
                     }
                    ?>
                    
                </select>
               </div>
          </div>
          <!-- End Member Field -->

          <!-- Start Categories Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Category</label>
               <div class ="col-sm-10 col-md-6">
                <select name="category"> 
                     <option value="0">...</option>

                    <?php
                    $AllCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
                     
                     foreach ($AllCats as $cat) {
                         
                              echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                              $childCats= getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
                              foreach ($childCats as $child) {
                                   echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
                              }
                     }
                    ?>
                    
                </select>
               </div>
          </div>
          <!-- End Categories Field -->

<!-- Start Tags Field -->
<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Tags</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="tags" class="form-control" required="required" placeholder="Separate tags with comma (,)" />
               </div>
          </div>
          <!-- End Tags Field -->

          <!-- Start Rating Field -->
         <!-- <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Rating</label>
               <div class ="col-sm-10 col-md-6">
                <select class="form-control" name="rating"> 
                    <option value="0">...</option>
                    <option value="1">*</option>
                    <option value="2">**</option>
                    <option value="3">***</option>
                    <option value="4">****</option>
                    <option value="4">*****</option>
                </select>
               </div>
          </div> -->

          <!-- End Rating Field -->

          
          <!-- Start Submit Field -->
          <div class="form-group form-group-lg">
               
               <div class ="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
               </div>
          </div>
          <!-- End Submit Field -->
     </form>
  </div>


<?php
   


   } elseif ($do == 'Insert') {  

     //echo $_POST['username'] . $_POST['password'] . $_POST['email'] . $_POST['full'] ;
   include $tpl.'footer.php' ;

   if($_SERVER['REQUEST_METHOD'] == 'POST') {

     echo "<h1 class='text-center'>Insert Item</h1>" ;
     echo "<div class='container'>";

        //get variables from the form

        $name     = $_POST['name'];
        $desc     = $_POST['description'];
        $price    = $_POST['price'];
        $country     = $_POST['country'];
        $status     = $_POST['status'];
        $member     = $_POST['member'];
        $cat     = $_POST['category'];
        $tags     = $_POST['tags'];

        

  

        //Validate the form

        $formErrors = array();
        
        if (empty($name)){

             $formErrors[] = '<div class="alert alert-danger">Name cant be <strong>empty</strong> </div>' ;
        }
        if (empty($desc)){

             $formErrors[] = '<div class="alert alert-danger">Description cant be <strong>empty</strong> </div>' ;
        }

        if (empty($price)) {

             $formErrors[] = '<div class="alert alert-danger">Price cant be <strong>empty</strong> </div>' ;
        }

        if (empty($country)) {

          $formErrors[] = '<div class="alert alert-danger">Country cant be <strong>empty</strong> </div>' ;
     }

        if ($status === 0) {

             $formErrors[] = '<div class="alert alert-danger">Status cant be <strong>empty</strong> </div>' ;
        }

        if ($member === 0) {

          $formErrors[] = '<div class="alert alert-danger">Member cant be <strong>empty</strong> </div>' ;
     }

     if ($cat === 0) {

          $formErrors[] = '<div class="alert alert-danger">Category cant be <strong>empty</strong> </div>' ;
     }
     

        foreach ($formErrors as $error) {
             echo '<div class="alert alert-danger">' . $error. '<br/>' . '</div>'  ;
        }

         // hayde l bracket ymkn mahala ghalat.

       
        //if no error do Update

          if (empty($formErrors)){


        $stmt = $con->prepare("INSERT INTO items(Item_Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags)
                                           VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags)");
        
        $stmt->execute(array(

          'zname' => $name,
          'zdesc' => $desc,
          'zprice' => $price,
          'zcountry' => $country,
          'zstatus' => $status,
          'zmember' => $member,
          'zcat' => $cat,
          'ztags' => $tags

        ));
        
        //Echo Success Message

        $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Inserted';

        redirectHome($theMsg, 'back');


   

} else {


     echo "<div class='container'>";
     $theMsg= '<div class="alert alert-danger">Sorry you cant browse this page directly</div>';

        redirectHome($theMsg);

        echo "</div>";
   }

   echo "</div>" ;
   

  }

   } elseif ($do == 'Edit') { 

     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0;
    
    $statement = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");
        
        $statement->execute(array($itemid));
        $item = $statement->fetch();
        $count = $statement->rowCount();

        if($statement->rowCount() > 0 ) {    ?>

<h1 style = "position:relative; left:270px;">Edit Item</h1>

<div class="container">
     <form class="form-horizontal" action="?do=Update" method="POST">
     <input type="hidden" name="itemid" value="<?php echo $itemid ?>" />
          
      <!-- Start name Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Name</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="name" class="form-control" required="required" placeholder="Item Name" value="<?php echo $item['Item_Name'] ?>"/>
               </div>
          </div>
          <!-- End Name Field -->

           <!-- Start Description Field -->
           <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Descripition</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="description" class="form-control" required="required" placeholder="Item Description" value="<?php echo $item['Description'] ?>" />
               </div>
          </div>
          <!-- End Description Field -->

          <!-- Start Price Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Price</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="price" class="form-control" required="required" placeholder="Item Price" value="<?php echo $item['Price'] ?>"/>
               </div>
          </div>
          <!-- End Price Field -->

          <!-- Start Country Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Country</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="country" class="form-control" required="required" placeholder="Item Country" value="<?php echo $item['Country_Made'] ?>"/>
               </div>
          </div>
          <!-- End Country Field -->

          <!-- Start Status Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Status</label>
               <div class ="col-sm-10 col-md-6">
                <select name="status"> 
                    
                    <option value="1" <?php if ($item['Status'] == 1) { echo 'selected' ;} ?>>New</option>
                    <option value="2" <?php if ($item['Status'] == 2) { echo 'selected' ;} ?>>Like New</option>
                    <option value="3" <?php if ($item['Status'] == 3) { echo 'selected' ;} ?>>Used</option>
                    <option value="4" <?php if ($item['Status'] == 4) { echo 'selected' ;} ?>>Very Old</option>
                </select>
               </div>
          </div>
          <!-- End Status Field -->

          <!-- Start Member Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Member</label>
               <div class ="col-sm-10 col-md-6">
                <select name="member"> 
                    
                    <?php
                     $stmt = $con->prepare("SELECT * FROM users");
                     $stmt->execute();
                     $users = $stmt->fetchAll();
                     foreach ($users as $user) {
                         
                              echo "<option value='" . $user['UserID'] . "'"; if ($item['Member_ID'] == $user['UserID']) { echo 'selected' ; } echo ">" . $user['Username'] . "</option>";
                         
                     }
                    ?>
                    
                </select>
               </div>
          </div>
          <!-- End Member Field -->

          <!-- Start Categories Field -->
          <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Category</label>
               <div class ="col-sm-10 col-md-6">
                <select name="category"> 
                    <!-- <option value="0">...</option> -->
                    <?php
                     $stmt2 = $con->prepare("SELECT * FROM categories");
                     $stmt2->execute();
                     $cats = $stmt2->fetchAll();
                     foreach ($cats as $cat) {
                         
                              echo "<option value='" . $cat['ID'] . "'"; if ($item['Cat_ID'] == $cat['ID']) { echo 'selected' ; } echo ">" . $cat['Name'] . "</option>";
                         
                     }
                    ?>
                    
                </select>
               </div>
          </div>
          <!-- End Categories Field -->

          <!-- Start Tags Field -->
<div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Tags</label>
               <div class ="col-sm-10 col-md-6">
                <input type="text" name="tags" class="form-control" required="required" placeholder="Separate tags with comma (,)" />
               </div>
          </div>
          <!-- End Tags Field -->

          <!-- Start Rating Field -->
         <!-- <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Rating</label>
               <div class ="col-sm-10 col-md-6">
                <select class="form-control" name="rating"> 
                    <option value="0">...</option>
                    <option value="1">*</option>
                    <option value="2">**</option>
                    <option value="3">***</option>
                    <option value="4">****</option>
                    <option value="4">*****</option>
                </select>
               </div>
          </div> -->

          <!-- End Rating Field -->

          
          <!-- Start Submit Field -->
          <div class="form-group form-group-lg">
               
               <div class ="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Save Item" class="btn btn-primary btn-lg" />
               </div>
          </div>
          <!-- End Submit Field -->
     </form>

     <?php

     // Select all users except Admin

$stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ?");
$stmt->execute(array($itemid));

$rows = $stmt->fetchAll();

if (! empty($rows)) {

?>

<h1 style = "position:relative; left:270px;">Manage [ <?php echo $item['Item_Name'] ?> ] Comments</h1>


<div class="table-responsive">
   <table class="main-table text-center table table-bordered">
<tr>
   
   <td>Comment</td>
   
   <td>User Name</td>
   <td>Added Date</td>
   <td>Control</td>
</tr>

<?php

foreach($rows as $row) {
   echo "<tr>";
      
      echo "<td>" .  $row['comment'] . "</td>" ;
      
      echo "<td>" .  $row['Member'] . "</td>" ;
      echo "<td>" .  $row['comment_date'] . "</td>" ;
      echo "<td>
      <a href='comments.php?do=Edit&comid=" .$row['c_id'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit </a>
      <a href='comments.php?do=Delete&comid=" .$row['c_id'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete </a>";
      
      if ($row['status'] == 0) {
        echo "<a href='comments.php?do=Approve&comid=" . $row['c_id'] . "' class='btn btn-info activate><i class='fa fa-check'></i>Approve </a>";
      }
      
      
      echo "</td>" ;
      echo "</tr>";

}
?>

<tr>
  
</table>
</div>

<?php } ?>

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

   } elseif ($do == 'Update') {  

     echo "<h1 class='text-center'>Update Item</h1>" ;
     echo "<div class='container'>";

     if($_SERVER['REQUEST_METHOD'] == 'POST') {

          //get variables from the form

          $id       = $_POST['itemid'];
          $name     = $_POST['name'];
          $desc    = $_POST['description'];
          $price     = $_POST['price'];
          $country     = $_POST['country']; 
          $status     = $_POST['status'];  
          $member     = $_POST['member']; 
          $cat     = $_POST['category']; 
          $tags     = $_POST['tags'];

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
        
        foreach ($formErrors as $error) {
             echo '<div class="alert alert-danger">' . $error. '<br/>' . '</div>'  ;
        }

           // hayde l bracket ymkn mahala ghalat.

         
          //if no error do Update

            if (empty($formErrors)){

            //Update the database with thus info

          $stmt = $con->prepare("UPDATE items SET Item_Name = ?, Description= ?, Price= ?, Country_Made= ?, Status = ?, Cat_ID = ?, Member_ID = ?, tags = ? WHERE Item_ID = ?");
          $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

          //Echo Success Message

          $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated</div>';
              
          //$errorMsg= 'Sorry you cant browse this page directly' ;

          redirectHome($theMsg, 'back', 4);

     }

 } else {

          $theMsg ='<div class="alert alert-danger">Sorry you cant browse this page directly</div>' ;
          redirectHome($theMsg);
     }
 
     echo "</div>" ;
  

  
  include $tpl.'footer.php' ;



   } elseif ($do == 'Delete') { 

     include $tpl.'footer.php' ;

echo "<h1 class='text-center'>Delete Item</h1>" ;
     echo "<div class='container'>";

     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('Item_ID', 'items', $itemid);
     

         
         //$statement->execute(array($userid));
         //$row = $statement->fetch();
         //$count = $statement->rowCount();
 
         if($check > 0 ) {
              $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

              $stmt->bindParam(":zid", $itemid);

              $stmt->execute();

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Deleted';

              redirectHome($theMsg, 'back');         
          } 


         

         else {

          
          $theMsg= '<div class="alert alert-danger">this id does not exist</div>';
          redirectHome($theMsg);  
          

         }


   } elseif ($do == 'Approve') { 

     include $tpl.'footer.php' ;

          echo "<h1 class='text-center'>Approve Items</h1>" ;
     echo "<div class='container'>";

     $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval ($_GET['itemid']) : 0;
    
     //$statement = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

     $check = checkItem('Item_ID', 'items', $itemid);
 
         if($check > 0 ) {
              $stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

              $stmt->execute(array($itemid));

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . ' Record Updated';

              redirectHome($theMsg, 'back');         
          } 
         
         else {
          
          $theMsg= '<div class="alert alert-danger">this id does not exist</div>';
          redirectHome($theMsg);  
          

         }

   }

}

  ?>