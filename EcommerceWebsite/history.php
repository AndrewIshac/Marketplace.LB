<?php
ob_start();
session_start();

$pageTitle = 'History';

include 'init.php';

// Check if the user is already logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Get the user's history from the session
$history = isset($_SESSION['history']) ? $_SESSION['history'] : array();

?>

<div class="container">
    <h1 class="text-center">Your Recently Viewed Items</h1>
    <div class="row">
        <?php foreach ($history as $itemId): 
            // Get item data from database
            $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? AND Approve = 1");
            $stmt->execute(array($itemId));
            $item = $stmt->fetch();
            if ($stmt->rowCount() > 0): ?>
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
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
</div>

<?php include $tpl.'footer.php'; ?>

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

<?php ob_end_flush(); ?>
