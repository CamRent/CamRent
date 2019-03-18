<?php

require_once "config.php";
require_once "usefulFunctions.php";
/**
 * Gives back JSON, has an "infotext"
 * @param $errorText
 */
function sendError($errorText){
    echo json_encode(array(
        'status' => '50x',
        'infotext' => $errorText
    ));
}
/**
 * Gives back regular JSON if a success occurs, has an "infotext"
 * @param $successText
 */
function sendSuccess($successText){
    echo json_encode(array(
        'status' => '201',
        'infotext' => $successText
    ));
}
/**
 * returns to frontend if user is logged in or not
 * @param $loginBoolean
 */
function isLoggedIn($loginBoolean){
    echo json_encode((array(
        'isLoggedIn' => $loginBoolean
    )));
}