<?php
require_once "PHPToJSON.php";
require_once "config.php";
require_once "usefulFunctions.php";



function profileList(PDO $pdo,$userId)
{
    $items = array();
    $count = 0;
    $sql = "SELECT * FROM items where teacherId = :userId";
    if ($stmt = $pdo->prepare($sql)) {
        if ($stmt->execute()) {
            $stmt->bindParam(':userId',$userId,PDO::PARAM_INT);
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