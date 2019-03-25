<?php

require_once "usefulFunctions.php";
require_once "PHPToJSON.php";
require_once "JSONToPHP.php";

$userdata = registerJSONToPHP();
$email = $_GET['email'];
$activationcode = $_GET['activationcode'];
if(checkActivationcode($pdo, getUnverifiedIdFromEmail($pdo,$email), getActivationcode($pdo,getUnverifiedIdFromEmail($pdo,$email)))) {
    Header("Location: ../Frontend/app/index_registerUser.html?email=$email&activationcode=$activationcode");
}
