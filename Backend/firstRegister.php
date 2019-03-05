<?php

require_once "JSONToPHP.php";
require_once "PHPToJSON.php";
require_once "usefulFunctions.php";
require_once "sendEmail.php";

firstRegister($pdo);
function firstRegister(PDO $pdo)
{
    $email =$_POST['email'];
    $code = generateActivationcode();
    writeIntoUnverifiedEmail($pdo,$email, $code);
    sendEmail($email, $code);
    echo("Email has been sent");
}
