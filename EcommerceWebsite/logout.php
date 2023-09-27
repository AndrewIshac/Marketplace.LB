<?php
        session_start();

        

        session_unset(); //to unset the data

        

        session_destroy();

        unset($_SESSION['avatar']);

        

        header('Location: index.php');

        exit();


