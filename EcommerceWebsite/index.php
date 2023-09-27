<?php 

ob_start();

session_start();

$pageTitle = 'HomePage';


 include 'init.php' ;  

 ?>




<div class="container">
    <div class="row">
        
<h1 style="text-align: center;">Recently Added Items</h1>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
            $searchTerm = $_GET['search'];

            $allItems = getAllFrom('*', 'items', "WHERE Approve = 1 AND Item_Name LIKE '%$searchTerm%'", '', 'Item_ID');
        } else {
            $allItems = getAllFrom('*', 'items', 'WHERE Approve = 1', '', 'Item_ID');
        } 
       foreach ($allItems as $item) { ?>

        <div class="col-sm-6 col-md-4">
        <div class="thumbnail item-box">
            <span class="price-tag"><?php echo $item['Price']; ?>$</span>
    
            <?php if (!empty($item['ItemImage'])): ?>
                <img class="img-responsive item-image" src="admin/uploads/avatars/<?php echo $item['ItemImage']; ?>" alt="" />
            <?php else: ?>
                <img class="img-responsive item-image" src="img.png" alt="" />
            <?php endif; ?>
               
            <div class="caption">
                <h3><a href="items.php?itemid=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h3>
                <p><?php echo $item['Description']; ?></p>
                <div class="date"><?php echo $item['Add_Date']; ?></div>
            </div>
        </div>
    </div>
<?php
       }

    ?>
    </div>
</div>

<?php
include $tpl.'footer.php' ;
ob_end_flush();

?>

<style>

body {
       /* background : #333; 
      background: url('admin/uploads/avatars/image788.jfif') no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover; */
    }

    .item-box {
    height: 400px; /* Set a fixed height for the item box */
}

.item-box .item-image {
    width: 100%;
    height: 250px; /* Set a fixed height for the image */
    object-fit: cover;
}
</style>
