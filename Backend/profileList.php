<?php
require_once "PHPToJSON.php";
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";

$temp = receiveProfileList();
$userId = $temp['userId'];

profileList($pdo, $userId);

function profileList(PDO $pdo, $userId)
{
    $items = array();
    $itemIds = itemsFromUser($pdo, $userId);
    for ($i = 0; $i < sizeOf($itemIds); $i++) {
        $sql = "SELECT * FROM items WHERE PK_ItemId = :itemId";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam('itemId', $itemIds[$i], PDO::PARAM_INT);
        $stmt->execute();
        if ($row2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $items[$i]['ID'] = $row2['PK_ItemId'];
            $items[$i]['name'] = $row2['name'];
            $items[$i]['available'] = $row2['available'];
            $items[$i]['teacherId'] = $row2['teacherId'];
            $items[$i]['description'] = $row2['description'];
        }
    }
    sendProfileList($items);
}


function itemsFromUser(PDO $pdo, $userId)
{
    $itemIds = array();
    $sql = "SELECT PK_ItemId FROM borrow where PK_UserId = :userId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($itemIds, $row['PK_ItemId']);
    }
    return $itemIds;
}

