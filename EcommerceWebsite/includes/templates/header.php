<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title><?php getTitle() ?></title>
  <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css" />
  <link rel="stylesheet" href="<?php echo $css; ?>front.css" />
</head>

<body>
  <div class="upper-bar">
    <div class="container">
      <?php
      if (isset($_SESSION['user'])) { ?>
        <img class="my-image img-thumbnail img-circle" src="<?php echo (isset($_SESSION['avatar']) ? 'admin/uploads/avatars/' . $_SESSION['avatar'] : '../../img.png'); ?>" alt="" />

        <div class="btn-group my-info">
          <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
            <?php echo $sessionUser ?>
            <span class="caret"></span>
          </span>
          <ul class="dropdown-menu">
            <li><a href="profile.php">My Profile</a></li>
            <li><a href="newad.php">New Item</a></li>
            <li><a href="profile.php#my-ads">My Items</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      <?php } else { ?>
        <a href="login.php">
          <span class="pull-right">Login/Signup</span>
        </a>
      <?php } ?>
    </div>
  </div>
  
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php" style="margin-right: 20px;">Homepage</a>
        <a class="navbar-brand" href="AboutUs.php" style="margin-right: 20px;">About Us</a>
        <a class="navbar-brand" href="ContactUs.php" style="margin-right: 20px;">Contact Us</a>
      </div>
      <a class="navbar-brand" href="history.php" style="margin-right: 20px;">Your History</a>

      <div class="collapse navbar-collapse" id="app-nav">
        
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Categories <span class="caret"></span></a>
            <ul class="dropdown-menu" style="background-color: rgb(164,100,255);">
              <?php
              $allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
              foreach ($allCats as $cat) {
                echo '<li><a href="categories.php?pageid=' . $cat['ID'] . '"> ' . $cat['Name'] . ' </a></li>';
              }
              ?>
            </ul>
          </li>
          <li>
            <form class="navbar-form" method="GET" action="index.php">
              <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Search items..">
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</body>
</html>
