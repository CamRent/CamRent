<?php

require_once "JSONToPHP.php";
require_once "PHPToJSON.php";
require_once "usefulFunctions.php";
require_once "sendEmail.php";

require_once "emailConfig.php";

firstRegister($pdo, $password);
function firstRegister(PDO $pdo, $password)
{
    $userdata = getEmail();
    $email = $userdata['email'];
    $code = generateActivationcode();
    writeIntoUnverifiedEmail($pdo,$email, $code);
    sendEmail($pdo, $email, $code, $password);
}
