<?php


function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC") {

    global $con;


    $getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

    $getAll->execute();
    $all = $getAll->fetchAll();

    return $all;
}



function getTitle(){

    global $pageTitle;
    if (isset($pageTitle)) {

        echo $pageTitle;

    } else {
        echo 'Default';
        
    }
}

/* Redirect function  */

function redirectHome($theMsg, $url = null, $seconds = 3){

    if($url === null ) {
        $url = 'dashboard.php';

        $link = 'Homepage' ;

    }else {

          if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {
            
            $url = $_SERVER['HTTP_REFERER'];

            $link= 'Previous Page';
          

    } else {

        $url = 'dashboard.php' ;

        $link = 'Homepage' ;

       }
        

        
    }

    echo $theMsg ;

    echo "<div class='alert alert-info'>You will be redirected to Previous Page after $seconds Seconds. </div>" ;

    header("refresh:$seconds;url=$url");

    exit();

}


function checkItem($select, $from, $value) {

    global $con;
    $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
    $statement->execute(array($value));
    $count = $statement->rowCount();

    return $count;

}

//check number of items

function countItems($item, $table) {
    global $con ;

    $stmt2 = $con->prepare("SELECT COUNT(UserID) FROM users");
    $stmt2->execute();
    return $stmt2->fetchColumn();

}

function countItem($item, $table) {
    global $con ;

    $stmt4 = $con->prepare("SELECT COUNT(Item_ID) FROM items");
    $stmt4->execute();
    return $stmt4->fetchColumn();

}

function countComments($item, $table) {
    global $con ;

    $stmt3 = $con->prepare("SELECT COUNT(c_id) FROM comments");
    $stmt3->execute();
    return $stmt3->fetchColumn();

}

//function to get latest items from database

function getLatest($select, $table, $order, $limit = 5) {

    global $con;
    $getStmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getStmt->execute();
    $rows = $getStmt->fetchAll();

    return $rows;
}






