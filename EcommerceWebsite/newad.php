<?php 

session_start();

$pageTitle= 'Create New Item';

 include 'init.php' ; 
 
 if(isset($_SESSION['user'])) {

    //print_r($_SESSION);
    
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $formErrors = array();

        $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
        $desc = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
        $category = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
        $tags = filter_var($_POST['tags'], FILTER_SANITIZE_SPECIAL_CHARS);

        // handling image upload
    $image = $_FILES['itemImage'];
    $imageName = $image['name'];
    $imageType = $image['type'];
    $imageSize = $image['size'];
    $imageTmpName = $image['tmp_name'];
    $imageAllowedExtension = array("jpeg", "jpg", "png", "gif", "jfif");

   $imageParts = explode('.', $imageName);
$imageExtension = strtolower(end($imageParts));

        if (strlen($name) < 3) {

            $formErrors[] = 'Item Title Must Be At Least 3 Characters' ;
        }

        if (strlen($desc) < 10) {

            $formErrors[] = 'Item Description Must Be At Least 10 Characters' ;
        }

        if (strlen($country) < 3) {

            $formErrors[] = 'Item Country Must Be At Least 3 Characters' ;
        }

        if (empty($price)) {

            $formErrors[] = 'Item Price Must Be Not Empty' ;
        }

        if (empty($status)) {

            $formErrors[] = 'Item Status Must Be Not Empty' ;
        }

        if (empty($category)) {

            $formErrors[] = 'Item Category Must Be Not Empty' ;
        }

        if (! empty($imageName) && ! in_array($imageExtension, $imageAllowedExtension)) {
          $formErrors[] = 'This Extension is not Allowed';
      }
  
      if (empty($imageName)) {
          $formErrors[] = 'Image is Required';
      }
  
      if ($imageSize > 4194304) {
          $formErrors[] = 'Image size Can Not be Larger Than 4MB';
      }



        foreach ($formErrors as $error) {
            echo '<div class="alert alert-danger">' . $error. '<br/>' . '</div>'  ;
       }

        // hayde l bracket ymkn mahala ghalat.

      
       //if no error do Update

         if (empty($formErrors)){
$uploadDirectory = "admin/uploads/avatars/";

// Generate a unique filename for the uploaded image
$imageName = uniqid() . '_' . $imageName;

// Path to store the new image
$imagePath = $uploadDirectory . $imageName;

// Move the uploaded file to the destination directory
if (move_uploaded_file($imageTmpName, $imagePath)) {
    $stmt = $con->prepare("INSERT INTO items(Item_Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID, tags, ItemImage)
                           VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember, :ztags, :zimage)");

    $stmt->execute(array(
        'zname' => $name,
        'zdesc' => $desc,
        'zprice' => $price,
        'zcountry' => $country,
        'zstatus' => $status,
        'zmember' => $_SESSION['uid'],
        'zcat' => $category,
        'ztags' => $tags,
        'zimage' => $imageName
    ));

    //Echo Success Message
    if ($stmt) {
        $successMsg = 'Item Has Been Added';
    }
} else {
    $formErrors[] = 'Error uploading the image. Please try again.';
}

  

} 

}


 ?>

 <h1 class="text-center"><?php echo $pageTitle ?></h1>

<div class="create-ad block">
   <div class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"><?php echo $pageTitle ?></div>
           <div class="panel-body">

           <div class="row">
              <div class="col-md-8">
              <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
          
          <!-- Start Name Field -->
<div class="form-group form-group-lg">
  <label class="col-sm-2 control-label">Name</label>
  <div class ="col-sm-10 col-md-9">
    <input pattern=".{3,}" title="This field require at least 3 characters" type="text" name="name" class="form-control live live-name" required="required" placeholder="Item Name" required/>
  </div>
</div>
<!-- End Name Field -->

<!-- Start Description Field -->
<div class="form-group form-group-lg">
  <label class="col-sm-2 control-label">Description</label>
  <div class ="col-sm-10 col-md-9">
    <input pattern=".{10,}" title="This field require at least 10 characters" type="text" name="description" class="form-control live live-description" required="required" placeholder="Item Description" required/>
  </div>
</div>
<!-- End Description Field -->

    
              <!-- Start Price Field -->
<div class="form-group form-group-lg">
  <label class="col-sm-2 control-label">Price</label>
  <div class ="col-sm-10 col-md-9">
    <input type="text" name="price" class="form-control live live-price" required="required" placeholder="Item Price" required/>
  </div>
</div>
<!-- End Price Field -->

    
              <!-- Start Country Field -->
              <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Country</label>
                   <div class ="col-sm-10 col-md-9">
                    <input type="text" name="country" class="form-control" required="required" placeholder="Item Country" required/>
                   </div>
              </div>
              <!-- End Country Field -->

              <div class="form-group form-group-lg">
               <label class="col-sm-2 control-label">Tags</label>
               <div class ="col-sm-10 col-md-9">
                <input type="text" name="tags" class="form-control" required="required" placeholder="Separate tags with comma (,)" />
               </div>
          </div>
    
              <!-- Start Status Field -->
              <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Status</label>
                   <div class ="col-sm-10 col-md-9">
                    <select name="status" required> 
                        <option value="1">New</option>
                        <option value="2">Like New</option>
                        <option value="3">Used</option>
                        <option value="4">Very Old</option>
                    </select>
                   </div>
              </div>
              <!-- End Status Field -->

    
              <!-- Start Categories Field -->
              <div class="form-group form-group-lg">
                   <label class="col-sm-2 control-label">Category</label>
                   <div class ="col-sm-10 col-md-9">
                    <select name="category" required> 
                        <!-- <option value="0">...</option> -->
                        <?php
                        $cats = getAllFrom('*', 'categories', '', '', 'ID');
                         
                        
                         foreach ($cats as $cat) {
                             
                                  echo "<option value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
                             
                         }
                        ?>
                        
                    </select>
                   </div>
              </div>
              <!-- End Categories Field -->
    
              

          <!-- Start ItemImage Field -->
<div class="form-group form-group-lg">
   <label class="col-sm-2 control-label">Item Image</label>
   <div class ="col-sm-10 col-md-9">
    <input type="file" name="itemImage" id="itemImage" class="form-control" required="required"/>
   </div>
</div>
<!-- End ItemImage Field -->


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

           <div class="col-md-4">
           <div class="thumbnail item-box live-preview">

           <span class="price-tag">
            $<span class="live-price">0</span> 
           </span>
           <img class="img-responsive" id="live-img" src="img.png" alt="" />

             <div class="caption">
               <h3 class="live-title">Title</h3>
               <p class="live-desc">Description</p>
             </div>
            </div>
    </div>
   </div>
   <!-- Start Looping Through Errors -->
        <?php 
          if(! empty($formErrors)) {
            foreach ($formErrors as $error){
             echo '<div class="alert-alert-danger">' . $error . '</div>';
            }
          }
          if (isset($successMsg)){
            echo '<div class="alert alert-success">' . $successMsg . '</div>';
          }
        ?>

    <!-- End Looping Through Errors -->
</div>



<?php

 } else{

    header('Location: login.php');

    exit();
 }



include $tpl.'footer.php' ;




?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#live-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]); 
      }
    }

    $("#itemImage").change(function() {
      readURL(this);
    });
  });
</script>

<script>
$(document).ready(function() {
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#live-img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); 
    }
  }

  $("#itemImage").change(function() {
    readURL(this);
  });

  // Update title
  $('.live-name').on('input', function() {
    $('.live-title').text($(this).val());
  });

  // Update description
  $('.live-description').on('input', function() {
    $('.live-desc').text($(this).val());
  });

});
</script>

<script>
$(document).ready(function() {
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#live-img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]); 
    }
  }

  $("#itemImage").change(function() {
    readURL(this);
  });

  // Update title
  $('.live-name').on('input', function() {
    $('.live-title').text($(this).val());
  });

  // Update description
  $('.live-description').on('input', function() {
    $('.live-desc').text($(this).val());
  });

  // Update price
  $('.live-price').on('input', function() {
    $('.live-price').text($(this).val());
  });

});




</script>
