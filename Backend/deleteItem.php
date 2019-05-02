<?php
/**
 * Created by IntelliJ IDEA.
 * User: felix
 * Date: 25.03.2019
 * Time: 14:55
 */

require_once "usefulFunctions.php";
require_once "JSONToPHP.php";
require_once "PHPToJSON.php";

deleteItem($pdo, deleteItems());

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
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                sendSuccess("Item has been deleted successfully");
            }
        }
    }
}