<?php
        session_start();

        session_unset(); //to unset the data

        session_destroy();

        header('Location: index.php');

        exit();


