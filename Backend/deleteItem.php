<?php

require_once "usefulFunctions.php";
require_once "JSONToPHP.php";
require_once "PHPToJSON.php";

$cache = deleteItems();
deleteItem($pdo, $cache['itemId']);

/**
 * checks if an Item exists in the db
 * delete Item from the database
 * @param PDO $pdo
 * @param $itemId integer id of the item we want to delete
 */
function deleteItem(PDO $pdo, $itemId)
{
    if (doesItemExist($pdo, $itemId)) {
        $user_check_query = "DELETE FROM items WHERE PK_ItemId = :itemId";
        if ($stmt = $pdo->prepare($user_check_query)) {
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_INT);
            if ($stmt->execute()) {
                sendSuccess("Item has been deleted successfully");
            }
        }
    }
    else{
        sendError("Item doesnt exist!");
    }
}