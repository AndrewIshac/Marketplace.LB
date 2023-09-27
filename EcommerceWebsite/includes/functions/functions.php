<?php



//function to get Categories from database

function getCat() {

    global $con;
    $getCat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");

    $getCat->execute();
    $cats = $getCat->fetchAll();

    return $cats;
}

function getAllFrom($field, $table, $where = NULL, $and = NULL) {

    global $con;


    $getAll = $con->prepare("SELECT $field FROM $table $where $and");

    $getAll->execute();
    $all = $getAll->fetchAll();

    return $all;
}



//function to get items from database

   function getItems($where, $value, $approve = NULL) {

    global $con;

    $sql = $approve == NULL ? 'AND Approve = 1' : '';

    if ($approve == NULL){

        $sql='AND Approve = 1';
    } else {
        $sql = NULL;
    }

    $getItems = $con->prepare("SELECT * FROM items WHERE $where = ? $sql ORDER BY Item_ID DESC");

    $getItems->execute(array($value));

    $items = $getItems->fetchAll();

    return $items;
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


//to check if user is activated
//function to check the RegStatus of the user

function checkUserStatus($user) {

    global $con;

    $statementx = $con->prepare("SELECT Username, RegStatus FROM users WHERE Username = ? AND RegStatus = 0 ");
    
    $statementx->execute(array($user));
    
    $status = $statementx->rowCount();

    return $status;

}








