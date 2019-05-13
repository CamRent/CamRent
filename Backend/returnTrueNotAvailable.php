<?php
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";
require_once "PHPToJSON.php";


$temp = returnTrueNotAvailableReceive();
$itemId = $temp["itemId"];

/*
 *user can rent/lend items, which changes their availability status
 *@param PDO $pdo
 *@param $itemId
 */
function returnTrueNotAvailable(PDO $pdo,$itemId){
    if (doesItemExist($pdo, $itemId)) {
        $user_check_query = 'SELECT available FROM items WHERE PK_ItemId = :itemId';
        $stmt1 = $pdo->prepare(($user_check_query));
        $stmt1->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        if ($stmt1->execute()) {
            $row = $stmt1->fetch();
            if ($row['available'] === 1) {
                sendReturnTrueNotAvailable(true);
            } else {
                sendReturnTrueNotAvailable(false);
            }
        }
    } else {
        sendError('Incorrect input');
    }
}

returnTrueNotAvailable($pdo,$itemId);