<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<?php 
ob_start();
session_start();
$pageTitle = 'Manage Items';
include 'init.php'; 


if(isset($_SESSION['user'])) {
    $getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
    $getUser->execute(array($_SESSION['user']));
    $info = $getUser->fetch();
    $userid = $info['UserID'];
?>

<h1 class="text-center">Manage Items</h1>

<div class="container">
    <h2 class="text-center category-title">User: <?php echo $_SESSION['user'] ?></h2>

    <?php
    $myItems = getAllFrom( "*","items","Where Member_ID = $userid ", "and approve = 1" , "Item_ID" ) ;
    if (!empty($myItems)) { ?>
        <div class="row">
        <?php
        foreach ($myItems as $item) { ?>
            <div class="col-sm-6 col-md-3">
                <div class="thumbnail item-box">
                    <span class="price-tag">$<?php echo $item['Price']; ?></span>

                    <!-- check if there is an image for this item -->
                    <?php if (!empty($item['ItemImage'])): ?>
                        <!-- if yes, show the user-uploaded image -->
                        <img class="img-responsive" src="admin/uploads/avatars/<?php echo $item['ItemImage']; ?>" alt="" />
                    <?php else: ?>
                        <!-- if not, show the default image -->
                        <img class="img-responsive" src="img.png" alt="" />
                    <?php endif; ?>

                    <div class="caption">
                        <h3><a href="items.php?itemid=<?php echo $item['Item_ID']; ?>"><?php echo $item['Item_Name']; ?></a></h3>
                        <p><?php echo $item['Description']; ?></p>
                        <div class="date"><?php echo $item['Add_Date']; ?></div>
                    </div>
                    <button class="btn btn-danger" onclick="deleteItem(<?php echo $item['Item_ID']; ?>)">Delete</button>
                </div>
            </div>
        <?php   
        }
        ?>
        </div>
        <?php
    } else {
        echo '<div class="alert alert-danger mt-5 text-center" role="alert" style="font-size: 18px;">
        Sorry, There\'s No Items To Show. 
        <a class="btn btn-primary ml-3" href="newad.php">Add New Item</a>
      </div>';
    }
    ?>
</div>

<?php
    // Delete Item
    if (isset($_GET['deleteItem'])) {
        $itemId = intval($_GET['deleteItem']);
        $stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid AND Member_ID = :zmember");
        $stmt->bindParam(":zid", $itemId);
        $stmt->bindParam(":zmember", $userid);
        $stmt->execute();

        header("Location: Manage.php"); // Redirect to Manage.php after deletion
    }

} else {
    header('Location: login.php');
    exit();
}

include $tpl.'footer.php' ;
ob_end_flush();
?>

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

<script>
    function deleteItem(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ajax request to delete the item
                $.ajax({
                    url: 'Manage.php',
                    type: 'GET',
                    data: { deleteItem: itemId },
                    success: function(data) {
                        Swal.fire(
                            'Deleted!',
                            'Your item has been deleted.',
                            'success'
                        )
                        // Refresh the page to see the changes
                        location.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                    }
                });
            }
        })
    }
</script>
