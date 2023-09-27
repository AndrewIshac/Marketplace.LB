<?php 

include 'connect.php' ;


// Routes

$tpl = 'includes/templates/' ; // Template Directory
$lang='includes/languages/' ; //language directory
$func = 'includes/functions/'; // Functions Directory
$css = 'layout/css/' ; // Css directory
$js = 'layout/js/' ; // Js Directory


//Important includes files/libraries
include $func . 'functions.php';
include $lang . 'english.php' ;
include $tpl . 'header.php' ; 

//include navbar on all pages expect the one with NoNavbar variable.
if (!isset($noNavbar)){
include $tpl . 'navbar.php' ; 
}
