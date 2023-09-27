<?php
    ob_start();
    session_start();
    $pageTitle = 'Show Items';
    include 'init.php';
    // Check If Get Request item Is Numeric & Get Its Integer Value
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
    // Select All Data Depend On This ID
$stmt = $con->prepare("SELECT items.*, categories.Name FROM items INNER JOIN categories ON categories.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID WHERE Item_ID = ? AND Approve = 1");
// Execute Query
$stmt->execute(array($itemid));

// Check if item exists
$count = $stmt->rowCount();

// The item exists, store its id in the session
if ($count > 0) {
    // Create 'history' array in the session if it doesn't already exist
    if (!isset($_SESSION['history'])) {
        $_SESSION['history'] = array();
    }
    
    // Store item id in the session if it's not already stored
    if (!in_array($itemid, $_SESSION['history'])) {
        // You could also limit the number of items stored in the session here
        array_push($_SESSION['history'], $itemid);
    }
}


// CSS added here
echo "
<style>
.tag-container {
    display: inline-block;
    background-color: #e2e2e2;
    padding: 2px 10px;
    border-radius: 5px;
    color: #666;
    margin-right: 5px;
}
    .tag-container a {
        color: #333;
        background-color: #fff;
        padding: .2rem .6rem;
        margin: .2rem;
        border-radius: 20px;
        border: 1px solid #ddd;
        transition: all .2s;
        text-decoration: none;
    }
    .tag-container a:hover {
        color: #fff;
        background-color: #007BFF;
        border-color: #007BFF;
    }
</style>
";


    if ($count > 0)  {

    
    // Fetch The Data
    $item = $stmt->fetch();
?>
<h1 class= "text-center"><?php echo $item['Item_Name'] ?></h1>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <!-- check if there is an image for this item -->
<?php if (!empty($item['ItemImage'])): ?>
    <!-- if yes, show the user-uploaded image -->
    <img class="img-responsive img-thumbnail center-block" src="admin/uploads/avatars/<?php echo $item['ItemImage']; ?>" alt="" />
<?php else: ?>
    <!-- if not, show the default image -->
    <img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
<?php endif; ?>

    </div>
    <div class="col-md-9">
        <h2><?php echo $item['Name'] ?></h2>
        <p><?php echo $item['Description'] ?></p>
        <ul class="list-unstyled">
            <li>
                <i class="fa fa-calendar fa-fw"></i>
        <span><?php echo $item['Add_Date'] ?></span>
    </i>
        <li> 
            <i class="fa fa-money fa-fw"></i>
            <span>Price</span> : <?php echo $item['Price'] ?>
    </li>
        <li>
        <i class="fa fa-building fa-fw"></i>
            <span>Made In</span> : <?php echo $item['Country_Made'] ?>
    </li>
        <li>
        <i class="fa fa-tags fa-fw"></i>
            <span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"> <?php echo $item['Name'] ?> </a>
    </li>
        <li>
        <i class="fa fa-user fa-fw"></i>
            <span>Added By Member With Id </span> : <a href="profile2.php?user=<?php echo $item['Member_ID']; ?>"> <?php echo $item['Member_ID'] ?> </a>
    </li>
    <div class="tag-container">
    <i class="fa fa-user fa-fw"></i>
            <span>Tags</span> : 
            <?php 
            $allTags = explode(",", $item['tags']);
            foreach($allTags as $tag) {
                $tag = str_replace( ' ','', $tag);
                $lowertag = strtolower($tag);
                if (! empty($tag)){
                echo "<a href = 'tags.php?name={$lowertag}'>"  .$tag . '</a>';
                }
            }  
            ?>
            </div>
    </li>
     <br>
     <br>
     <!-- <a href="delete_item.php?itemid=<?php echo $item['Item_ID']; ?>" class="btn btn-danger">Delete Item</a> -->
    </ul>
    
    </div>
    </div>

    <hr class="custom-hr">
  <?php  if(isset($_SESSION['user'])) { ?>
<div class="row">
<div class="col-md-offset-3">
 <div class = "add-comment">   
<h3> Add Your Comment </h3>
<form action = " <?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method = "POST"  >
<textarea name="comment" required></textarea>
<input class="btn btn-primary" type="submit" value="Add Comment" >
    </form>
<?php 
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $comment = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS );
    $userid = $_SESSION['uid'];
    $itemid = $item['Item_ID']; 

if (! empty($comment)){
$stmt = $con->prepare("INSERT INTO 
                              comments(comment, status, comment_date, item_id, user_id)
                              VALUES(:zcomment, 0, NOW(), :zitemid, :zuserid )");
                              
                              $stmt->execute(array(  
                               'zcomment'=> $comment,
                               'zitemid'=> $itemid,
                               'zuserid'=> $userid
                            ));
                               if ($stmt) {
                                echo '<div class = "alert alert-success"> Comment Added </div>';
                               }

}
 }

?>
    </div>
    </div>
    </div>
    <?php } else {
echo  'Login Or Register To Add Comment';
    }?>
 
    <hr class="custom-hr">

    <?php 
         $stmt = $con->prepare("SELECT comments.*, users.Username AS Member FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ? AND status = 1 ORDER BY c_id DESC");
         $stmt->execute(array($item['Item_ID']));
       
         $comments = $stmt->fetchAll();

        ?>

    
     <?php 

     foreach ($comments as $comment) {  ?>
     <div class="comment-box">
        <div class="row">
        <div class="col-sm-2 text-center">
            <img class="img-responsive img-thumbnail img-circle" src="img.png" alt="" />
            <?php echo $comment['Member'] ?>
        </div>
        <div class="col-sm-10">
            <p class="lead"><?php echo $comment['comment'] ?> </p>
     </div>
        
        </div>
     </div>

     <hr class="custom-hr">
    <?php } ?>
     

    </div>
     
<?php

    } else {
        echo 'There is no such ID or This Item is Waiting Approval';
    }

    include $tpl . 'footer.php';
    ob_end_flush();
?>
