<?php
require_once "config.php";

/**
 * A simple script to write the current date into users table as lastLogin
 * @param $pdo
 */
function setLastLogin(PDO $pdo)
{
    $sql = "UPDATE users 
              SET lastLogin = now()
              WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':email', $_SESSION['email']);
    $stmt->execute();
    $_SESSION['date'] = date("Y-m-d");
}

/**
 * sets $_SESSION array with current relevant userdata
 * @param $row
 */
function saveIntoSession($row)
{
    $_SESSION['email'] = $row['email'];
    $_SESSION['firstname'] = $row['firstname'];
    $_SESSION['surname'] = $row['surname'];
    $_SESSION['userId'] = $row['pk_userId'];
    $_SESSION['priority'] = $row['priority'];
}


/**
 * generates an activationcode and saves it into the db
 */
function generateActivationcode()
{
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime() * 1000000);
    $i = 0;
    $pass = '';
    while ($i <= 20) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}

/**
 * add Item to the database
 * @param PDO $pdo
 * @param $item array with useful infos about the item
 */
function addItem(PDO $pdo, $item)
{
    $user_check_query = "INSERT INTO items(name,available,teacherId,description) VALUES (:name,:available,:teacherId,:description)";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':name', $item['name'], PDO::PARAM_STR);
        $stmt->bindParam(':available', $item['available'], PDO::PARAM_STR);
        $stmt->bindParam(':teacherId', $item['teacherId'], PDO::PARAM_STR);
        $stmt->bindParam(':description', $item['description'], PDO::PARAM_STR);
        if ($stmt->execute()) {
            sendSuccess("Item has been added successfully");
        }
    }

}

/**
 * returns an array with all available items
 * @param PDO $pdo
 * @return array 2d array with all available items
 */
function getAllAvailableItems(PDO $pdo)
{
    $count = 0;
    $items = array();
    $user_check_query = "SELECT * FROM items WHERE available = 1";
    if ($stmt = $pdo->prepare($user_check_query)) {
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[$count]['name'] = $row['name'];
                $items[$count]['available'] = $row['available'];
                $items[$count]['teacherId'] = $row['teacherId'];
                $items[$count]['description'] = $row['description'];
            }
        }
    }
    return $items;
}

/**
 * returns an array with all items
 * @param PDO $pdo
 * @return array $items 2d array with all items
 */
function getAllItems(PDO $pdo)
{
    $count = 0;
    $items = array();
    $user_check_query = "SELECT * FROM items";
    if ($stmt = $pdo->prepare($user_check_query)) {
        if ($stmt->execute()) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $items[$count]['name'] = $row['name'];
                $items[$count]['available'] = $row['available'];
                $items[$count]['teacherId'] = $row['teacherId'];
                $items[$count]['description'] = $row['description'];
            }
        }
    }
    return $items;
}

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


/**
 * return true if an item exists in db
 * @param PDO $pdo
 * @param $itemId
 * @return bool
 */
function doesItemExist(PDO $pdo, $itemId)
{
    $user_check_query = "SELECT PK_ItemId FROM items WHERE PK_ItemId = :itemId";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':itemId', $itemId, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            if ($row->count() == 1) {
                return true;
            }
        }
    }
    return false;
}

/**
 * user can rent/lend items, which changes their availability status
 * @param PDO $pdo
 * @param $itemdId
 */
function rentItem(PDO $pdo, $itemId)
{
    if (doesItemExist($pdo, $itemId)) {
        $user_check_query = "";
    }
}

/**
 * checks if a given item is available judging by their availability tinyint
 * @param PDO $pdo
 * @param $itemId
 * @return bool
 */
function isItemAvailable(PDO $pdo, $itemId)
{
    if (doesItemExist($pdo, $itemId)) {
        $user_check_query = "SELECT available from items WHERE PK_ItemId = :itemId";
        if ($stmt = $pdo->prepare($user_check_query)) {
            $stmt->bindParam(':itemId', $itemId, PDO::PARAM_STR);
            if ($stmt->execute()) {
                $row = $stmt->fetch();
                if ($row['available'] == 1) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    } else {
        sendError("This Item does not exist unfortunately");
    }
    return false;
}

/**
 * writes an email and a matching activationcode into the unverifiedEmail Table
 * @param PDO $pdo
 * @param $email
 * @param $activationcode
 */
function writeIntoUnverifiedEmail(PDO $pdo, $email, $activationcode)
{
    $user_check_query = "INSERT INTO unverifiedemail(email, activationCode, date) VALUES (:email, :activationcode, now())";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':activationcode', $activationcode, PDO::PARAM_STR);
        if ($stmt->execute()) {

            sendSuccess("Item has been added successfully");
        } else {
            sendError("Something went wrong");
        }
    }
}

/**
 * returns true if an activationcode matches the id
 * @param PDO $pdo
 * @param $id
 * @param $activationcode
 * @return bool
 */
function checkActivationcode(PDO $pdo, $id, $activationcode)
{
    if(getActivationcode($pdo,$id) == $activationcode){
        return true;
    }
    return false;
}

/**
 * returns the number of email adresses current in unverifiedEmail per email
 * @param PDO $pdo
 * @param $email
 * @return int
 */
function returnsAmountOfUnverifiedEmailPerEmail(PDO $pdo, $email)
{
    $user_check_query = "SELECT * FROM unverifiedemail WHERE email = :email";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row->count();
        }
    }
    sendError("A Problem occurred");
    return 0;
}

/**
 * returns an "available" boolean based on an ID
 * @param PDO $pdo
 * @param $unverifiedEmailId
 * @return int
 */
function returnActiveStateOfEmail(PDO $pdo, $unverifiedEmailId)
{
    $user_check_query = "SELECT * FROM unverifiedemail WHERE PK_unverifiedEmailId = :unverifiedEmailId";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':unverifiedEmailId', $unverifiedEmailId, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row = $stmt->fetch();
            return $row['active'];
        }
    }
    return 0;
}

/**
 * make an unverifieddEmail inactive based on ID
 * @param PDO $pdo
 * @param $unverifiedEmailId
 */
function makeUnverifiedEmalInactive(PDO $pdo, $unverifiedEmailId)
{
    $user_check_query = "UPDATE unverifiedemail SET active = 1 WHERE PK_unverifiedEmailId = :unverifiedEmailId";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':unverifiedEmailId', $unverifiedEmailId, PDO::PARAM_STR);
        if ($stmt->execute()) {
            sendSuccess("$unverifiedEmailId became inactive successfully");
        }
    }
    sendError("something went wrong");
}

/**
 * returns an activationcode for an unverifiedemailId
 * @param $pdo
 * @param $unverifiedEmailId
 * @return mixed
 */
function getActivationcode(PDO $pdo, $unverifiedEmailId)
{
    $user_check_query = "SELECT activationcode FROM unverifiedemail WHERE PK_unverifiedEmailId = :unverifiedEmailId";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':unverifiedEmailId', $unverifiedEmailId, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row[] = $stmt->fetch();
            //sendSuccess("$unverifiedEmailId became inactive successfully");
            return $row['activationcode'];
        }
    }
    sendError("something went wrong");
    return 0;
}

/**
 * returns an active id for an email
 * @param PDO $pdo
 * @param $email
 * @return mixed
 */
function getActiveUnverifiedIdFromEmail(PDO $pdo, $email)
{
    $user_check_query = "SELECT * FROM unverifiedemail WHERE email = :email AND active = 1";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row[] = $stmt->fetch();
            //sendSuccess("$unverifiedEmailId became inactive successfully");
            return $row['PK_unverifiedEmailId'];
        }
    }
    sendError("something went wrong");
    return 0;
}

/**
 * get email from unverifiedid
 * @param PDO $pdo
 * @param $id
 * @return int
 */
function getEmailFromUnverifiedId(PDO $pdo, $id)
{
    $user_check_query = "SELECT * FROM unverifiedemail WHERE PK_unverifiedEmailId = :id";
    if ($stmt = $pdo->prepare($user_check_query)) {
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        if ($stmt->execute()) {
            $row[] = $stmt->fetch();
            //sendSuccess("$unverifiedEmailId became inactive successfully");
            return $row['$email'];
        }
    }
    sendError("something went wrong");
    return 0;
}