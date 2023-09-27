<?php
  ob_start();
  session_start();
  $pageTitle = 'Contact Us';
  include 'init.php';  
?>

<style>
    body {
        background-color: #111;
    }
    .contact-card {
        max-width: 800px;
        margin: auto;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0px 0px 20px 0px rgba(0, 0, 0, 0.1);
    }
    .contact-card h2 {
        color: #6c757d;
    }
    .contact-card a {
        color: #007bff;
    }
    .contact-card i {
        margin-right: 10px;
    }
    .contact-card ul {
        list-style-type: none;
    }
    .contact-card ul li {
        display: inline;
        margin: 0 10px;
    }
</style>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<div class="container my-5">
<h1 class="text-center mb-5" style="color: white;">Contact Us</h1>

    <div class="contact-card p-5">
        <h2><i class="far fa-envelope"></i>Email Us</h2>
        <p>Have questions or concerns? We're always ready to help. Please contact us at <a href="mailto:androwishak79@gmail.com">androwishak79@gmail.com</a></p>

        
        

        <h2><i class="far fa-clock"></i>Working Hours</h2>
        <p>We're available from 9:00am to 5:00pm, Monday through Friday. Please allow us up to 48 hours to respond to your inquiries.</p>

        <h2><i class="fas fa-globe"></i>Stay Connected</h2>
        <p>Stay up-to-date on our latest products and special promotions by following us on our social media platforms:</p>
        <ul>
            <li><a href="https://www.facebook.com"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="https://www.twitter.com"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.instagram.com"><i class="fab fa-instagram"></i></a></li>
        </ul>
        <h2><i class="far fa-envelope"></i>Our Location</h2>
        <p>We are based in Chekka, Lebanon. While we operate primarily online, we love meeting our customers. If you're in the area, don't hesitate to visit us!</p>
    
        <div class="mt-5">
    
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5377.165049932373!2d35.64845240592436!3d34.324417999178526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151f16c8aa56e85d%3A0x8e3d8dc2ce982e43!2sChekka%2C%20Lebanon!5e0!3m2!1sen!2s!4v1621266316076!5m2!1sen!2s" width="400" height="400" style="border:0; display: block; margin: auto;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    
    </div>

    
</div>

<br>
<br>

<div class="container my-5">
    <p class="text-center" style="color: white; font-size: 30px;">We value your satisfaction and are committed to providing exceptional customer service. If you have any questions or concerns, please don't hesitate to reach out to us. Our dedicated team is here to assist you.</p>
    <div class="text-center">
        <i class="fas fa-thumbs-up fa-6x thumbs-up-white"></i>
    </div>
</div>


<style>
    .thumbs-up-white {
        color: white;
    }
</style>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<?php
  include $tpl.'footer.php';
  ob_end_flush();
?>
