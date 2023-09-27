<?php include 'init.php'; ?>

<div class="container">
    <h1 class="text-center">Show Tag Items</h1>
    <?php
    if (isset($_GET['name'])) {
        $tag = $_GET['name'];
        echo "<h2 class='text-center tag-title'>Tag: {$tag}</h2>";
        $allItems = getAllFrom("*", "items", "WHERE tags LIKE '%{$tag}%'", "AND Approve = 1", "Item_ID", "ASC");
    ?>
    <div class="row">
    <?php
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
    } else {
        echo 'You Must Add Tag Name';
    }
?>

</div>
</div>

<?php include $tpl . 'footer.php'; ?>

<style>
    .item-box {
        height: 400px; /* Set a fixed height for the item box */
    }

    .item-box .item-image {
        width: 100%;
        height: 250px; /* Set a fixed height for the image */
        object-fit: cover;
    }

    .tag-title {
        font-size: 24px;
        padding: 10px;
        border: 1px solid #333;
        color: white;
        background-color: #333;
        width: fit-content;
        margin: auto;
        border-radius: 5px;
        margin-bottom: 20px;
    }
</style>





