<?php
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";


$temp = returnTrueNotAvailableReceive();
$itemId = $temp["itemId"];

/*
 *user can rent/lend items, which changes their availability status
 *@param PDO $pdo
 *@param $itemId
 */
function returnTrueNotAvailable(PDO $pdo,$itemId){

    if(doesItemExist($pdo,$itemId)){
        $check_user_query = "SELECT available FROM items WHERE PK_ItemId = :itemId";
        $stmt1 = $pdo->prepare(($check_user_query));
        $stmt1->bindParam('itemId',$itemId,PDO::PARAM_INT);
        $row = $stmt1->fetch();
        if($row['available'] == 1){
            sendReturnTrueNotAvailable(true);
        } else{
            sendReturnTrueNotAvailable(false);
        }
    } else{
        sendError('Item does not exist');
    }
    return false;
}