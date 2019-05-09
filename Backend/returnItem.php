<?php
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";


/**
 * user can return items
 * @param PDO $pdo
 * @param $itemId
 */

$temp = returnItemReceive();
$itemId = $temp["itemId"];

function renturnItem(PDO $pdo, $itemId){
    if (doesItemExist($pdo, $itemId)) {
        //select Item to change
        $user_check_query = "SELECT PK_ItemId, teacherId FROM items WHERE PK_ItemId = :itemId";
        $stmt1 = $pdo->prepare(($user_check_query));
        $stmt1->bindParam(':itemId',$itemId,PDO::PARAM_INT);
        //changing available to unavailable
        $user_check_query2 = "UPDATE items SET available=0 WHERE PK_ItemId = :itemId";
        $sql1 = $pdo->prepare(($user_check_query2));
        $sql1->bindParam(':itemId', $itemId,PDO::PARAM_INT);
        //select from borrow
        $user_check_query3 = "SELECT * FROM borrow WHERE PK_ItemId = :itemId";
        $stmt3 = $pdo->prepare(($user_check_query3));
        $stmt3->bindParam(':itemId',$itemId,PDO::PARAM_INT);
        //writing into borrow_history table
        $sql2 = "INSERT INTO borrow_history (begin_date, end_date, teacherId,PK_borrowId, PK_UserId, PK_ItemId) VALUES (:begin_date, :end_date, :teacherId,:PK_borrowId, :PK_UserId, :PK_ItemId)";
        if ($stmt3->execute()) {
            $row = $stmt3->fetch();
            $teacherId = $row["teacherId"];
        }
        // $userId = $userdata['userId'];
        if ($stmt2 = $pdo->prepare($sql2)) {
            $begin_date = $row['begin_date'];
            $date_end = date("Y-m-d");
            $itemId = $row["itemId"];
            $userId = $row["userId"];
            $borrowId = $row["borrowId"];

            $stmt2->bindParam(':begin_date', $begin_date, PDO::PARAM_STR);
            $stmt2->bindParam(':end_date', $date_end, PDO::PARAM_STR);
            $stmt2->bindParam(':teacherId', $teacherId, PDO::PARAM_STR);
            $stmt2->bindParam(':PK_UserId', $userId, PDO::PARAM_STR);
            $stmt2->bindParam(':PK_ItemId',$itemId,PDO::PARAM_INT);
            $stmt2->bindParam(':PK_borrowId',$borrowId,PDO::PARAM_INT);
            $stmt2->execute();
        }
        if     ($stmt1->execute()){
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                if ($row['teacherId'] !== null) {
                    $sql1->execute();
                }
            }
        }
        //delete row from borrow
        $user_check_query4 = "DELETE FROM borrow WHERE PK_ItemId = :itemId";
        $stmt4 = $pdo->prepare(($user_check_query4));
        $stmt4->bindParam(':itemId',$itemId,PDO::PARAM_INT);
        $stmt4->execute();
    }
}

renturnItem($pdo,$itemId);