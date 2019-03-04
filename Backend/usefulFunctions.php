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
 * takes the first email input and sends an email to the given address
 */
function firstRegister(){
    $email = getEmail();
    $activationCode = generateActivationcode();
    sendEmail($email, $activationCode);
}

/**
 * generates an activationcode and saves it into the db
 */
function generateActivationcode(){
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
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
function addItem(PDO $pdo, $item){
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
function getAllAvailableItems(PDO $pdo){
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
function getAllItems(PDO $pdo){
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
