<?php 
include 'init.php'; 

function getCategoryNameFromId($id) {
    global $con; // Accessing the $con variable from the global scope, assuming it's your PDO instance

    // Preparing the query to avoid SQL Injection
    $stmt = $con->prepare("SELECT Name FROM categories WHERE ID = :id");
    $stmt->execute(array(':id' => $id));

    // Fetching the result. Assuming that ID is a unique identifier, we're only fetching one result
    $result = $stmt->fetch();

    return $result ? $result['Name'] : null; // Return the category name if found, else return null
}

?>

<div class="container">
    <h1 class="text-center">Show Category Items</h1>
    <?php
    if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
        $category = intval($_GET['pageid']);
        // assuming you have a function getCategoryNameFromId($id)
        $categoryName = getCategoryNameFromId($category);
        echo "<h2 class='text-center category-title'>Category: {$categoryName}</h2>";
        $allItems = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "Item_ID", "ASC");
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
        echo 'You Must Add Page ID';
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

    .category-title {
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
