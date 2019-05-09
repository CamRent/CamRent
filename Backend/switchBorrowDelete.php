<?php
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";
require_once "PHPToJSON.php";

$temp = switchBorrowDeleteReceive();
$itemId = $temp['itemId'];
$userId = $temp['userId'];


function switchBorrowDelete(PDO $pdo, $userId, $itemId)
{
    if (doesItemExist($pdo, $itemId)) {
        $user_check_query = 'SELECT teacherId FROM items WHERE PK_ItemId = :itemId';
        $stmt1 = $pdo->prepare(($user_check_query));
        $stmt1->bindParam(':itemId', $itemId, PDO::PARAM_INT);
        if ($stmt1->execute()) {
            $row = $stmt1->fetch();
            if ($row['teacherId'] == $userId) {
                switchBorrowDeleteSend(true);
            } else {
                switchBorrowDeleteSend(false);
            }
        }
    } else {
        sendError('Incorrect input');
    }
}

switchBorrowDelete($pdo, $userId, $itemId);