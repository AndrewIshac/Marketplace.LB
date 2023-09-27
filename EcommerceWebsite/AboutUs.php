<?php
  ob_start();
  session_start();
  $pageTitle = 'About Us';
  include 'init.php';  
?>

<style>
    html, body {
        overflow: hidden;
        background-color: #111;
        color: #f8f9fa;
    }

    .fixed-width-container {
        width: 1200px;
        margin: auto;
    }
</style>

<div class="container about-us fixed-width-container">
    <div class="row">
        <div class="col-lg-12 text-center">
        <img src="admin/uploads/avatars/best-about-us-pages.jpg" class="img-fluid rounded-circle mx-auto d-block my-3" style="width: 300px;" alt="Responsive image">
        </div>
    </div>
</div>
    
    <div class="row text-center align-items-center my-5 py-5">
        <div class="col-lg-6">
        <img src="admin/uploads/avatars/who-we-are.jfif" class="img-fluid rounded-circle w-50 my-3" style="width: 200px;" alt="Responsive image">
           
            <p>We are an innovative e-commerce platform, offering high-quality products across various categories. We take pride in our commitment to excellent customer service, high-quality products and diversity in our offerings.</p>
        </div>

        <div class="col-lg-6">
        <img src="admin/uploads/avatars/our-mission.jfif" class="img-fluid rounded-circle w-50 my-3" style="width: 200px;" alt="Responsive image">
            
            <p>Our mission is to provide a diverse range of high-quality products and an easy and enjoyable shopping experience to all of our customers. We constantly strive to expand our product range and improve our services.</p>
        </div>
    </div>
    
    <div class="row text-center align-items-center my-5 py-5">
        <div class="col-lg-6">
            <img src="admin/uploads/avatars/our-values.jfif" class="img-fluid rounded-circle w-50 my-3" style="width: 200px;" alt="Responsive image">
            
            <p>We believe in transparency, trust and loyalty. Our customers are at the heart of everything we do. We are committed to providing you with the best service and high-quality products at affordable prices.</p>
        </div>

        <div class="col-lg-6">
        <img src="admin/uploads/avatars/why-choose-us.jfif" class="img-fluid rounded-circle w-50 my-3" style="width: 200px;" alt="Responsive image">
            
            <p>We offer an easy-to-use platform, excellent customer service, and a wide array of products to suit all of your needs. We are committed to providing our customers with the best online shopping experience.</p>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
  $(document).ready(function(){
      $('.about-us h2').hide().each(function(i) {
          $(this).delay(i * 500).fadeIn(1000);
      });
  });
</script>

<?php
  include $tpl.'footer.php';
  ob_end_flush();
?>
