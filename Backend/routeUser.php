<?php

require_once "usefulFunctions.php";

$userdata = registerJSONToPHP();
$email = $_GET['email'];
if(checkActivationcode($pdo, getActiveUnverifiedIdFromEmail($pdo,$email), getActiveUnverifiedIdFromEmail($pdo,$email))) {
    Header("Location: ../Frontend/app/index_registerUser.html");
}
