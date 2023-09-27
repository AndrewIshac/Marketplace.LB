<?php

/*
Categories => [Manage | Edit | Update | Add | Insert | Delete | Stats ]
*/

$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'  ; //eza isset do true btsir $do=GET do. Eza False $do = Manage //


           /* if (isset($_GET['do'])){
              $do = $_GET['do'];

              }else {
              $do='Manage';
              } */


// if the page is main page //

if ($do == 'Manage'){
    echo 'Welcome You Are In Manage Category Page';
    echo '<a href="?do=Insert"> Add New Category +</a>' ;

}
else if($do == 'Add') {
  echo 'Welcome You Are In Add Category Page';

} 
else if($do == 'Insert') {
    echo 'Welcome You Are In Insert Category Page';
  }
  else if($do == 'Add') {
    echo 'Welcome You Are In Add Category Page';
  
  }

else {
    echo 'Error There\'s No Page With This Name' ;
}