<?php
require_once "PHPToJSON.php";
require_once "config.php";

sendOverwiewOfAllItems(getAllItems($pdo));

function getAllItems(PDO $pdo)
{
    $items = array();
    $count = 0;
    $sql = "SELECT * FROM items";
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            if ($row = $stmt->fetch()) {
                $items[$count]['ID'] = $row['PK_ItemId'];
                $items[$count]['name'] = $row['name'];
                $items[$count]['available'] = $row['available'];
                $items[$count]['teacherId'] = $row['teacherId'];
                $items[$count]['description'] = $row['description'];
            }
        }
    }
    return $items;
}