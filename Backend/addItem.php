<?php
/**
 * Created by PhpStorm.
 * User: Niklas Zijlstra
 * Date: 29.04.2019
 * Time: 16:28
 */

require_once "JSONToPHP.php";
require_once "PHPToJSON.php";
require_once "usefulFunctions.php";


addItem($pdo, createItem());
/**
 * add Item to the database
 * @param PDO $pdo
 * @param $item array with useful infos about the item
 */
function addItem(PDO $pdo, $item)
{
    $user_check_query = "INSERT INTO items(name, description) VALUES (:name,:description)";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':name', $item['name'], PDO::PARAM_STR);
        /* $stmt->bindParam(':available', $item['available'], PDO::PARAM_STR);*/
        $stmt->bindParam(':teacherId', $item['teacherId'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $item['description'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            sendSuccess("Item has been added successfully");
        }
    }
}
