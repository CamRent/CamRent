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

function getAvailableItems(PDO $pdo){
    

}
