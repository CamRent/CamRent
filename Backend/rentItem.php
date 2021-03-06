<?php
require_once "config.php";
require_once "usefulFunctions.php";
require_once "JSONToPHP.php";
require_once "PHPToJSON.php";

/**
 * user can rent/lend items, which changes their availability status
 * @param PDO $pdo
 * @param $itemId
 */

$temp = rentItemReceive();
$itemId = $temp["itemId"];
$userId = $temp['userId'];

rentItem($pdo,$itemId, $userId);

function rentItem(PDO $pdo, $itemId, $userId){
    if (doesItemExist($pdo, $itemId)) {
        //select Item to change
        $user_check_query = "SELECT PK_ItemId, teacherId FROM items WHERE PK_ItemId = :itemId";
        $stmt1 = $pdo->prepare(($user_check_query));
        $stmt1->bindParam(':itemId',$itemId,PDO::PARAM_INT);
        //changing available to unavailable
        $user_check_query2 = "UPDATE items SET available=1 WHERE PK_ItemId = :itemId";
        $sql1 = $pdo->prepare(($user_check_query2));
        $sql1->bindParam(':itemId', $itemId,PDO::PARAM_INT);
        //writing into borrow table
        $sql2 = "INSERT INTO borrow (begin_date, end_date, teacherId, PK_UserId, PK_ItemId) VALUES (:begin_date, :end_date, :teacherId, :PK_UserId, :PK_ItemId)";
        if ($stmt1->execute()) {
            $row = $stmt1->fetch();
            $teacherId = $row["teacherId"];
        }
        // $userId = $userdata['userId'];
        if ($stmt2 = $pdo->prepare($sql2)) {
            $begin_date = date("Y-m-d");
            $date_end = date('Y-m-d', strtotime($begin_date. ' + 14 days'));

            $stmt2->bindParam(':begin_date', $begin_date, PDO::PARAM_STR);
            $stmt2->bindParam(':end_date', $date_end, PDO::PARAM_STR);
            $stmt2->bindParam(':teacherId', $teacherId, PDO::PARAM_STR);
            $stmt2->bindParam(':PK_UserId', $userId, PDO::PARAM_INT);
            $stmt2->bindParam(':PK_ItemId',$itemId,PDO::PARAM_INT);
            $stmt2->execute();
        }
        if     ($stmt1->execute()){
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                if ($row['teacherId'] !== null) {
                    $sql1->execute();
                    sendSuccess("Wurde Ausgeborgt");
                }
            }
        }
    }
}

