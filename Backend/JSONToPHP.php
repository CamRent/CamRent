<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once "config.php";
require_once "usefulFunctions.php";

/**
 * reads necessary user data if the user wants to register themselves
 * returns an array with useful user-data (firstname, surname, password)
 */

function registerJSONToPHP()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array(
        "firstname" => $obj['firstname'],
        "surname" => $obj['surname'],
        "password" => $obj['password'],
        "email" => $obj['email']);
    return $userdata;
}

/**
 * reads necessary user data if the user wants to login
 * returns email and password in array
 */
function loginJSONToPHP()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("email" => $obj['email'],
        "password" => $obj['password']);
    return $userdata;
}


/**
 * reads necessary user data if the user wants to change their surname
 * returns (new) surname in array
 */
function changeSurnameInput()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("surname" => $obj['surname']);
    return $userdata;
}

/**
 * reads necessary user data if the user wants to change their firstname
 * returns (new) firstname in array
 */
function changeFirstnameInput()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("firstname" => $obj['firstname']);
    return $userdata;
}

/**
 * gets Input for changePassword
 * @return array
 */
function changePasswordInput()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("oldPassword" => $obj['oldPassword'],
        "newPassword" => $obj['newPassword']);
    return $userdata;
}

/**
 * gets Input for changeEmail
 * @return array
 */
function changeEmail()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("oldEmail" => $obj['oldEmail'],
        "newEmail" => $obj['newEmail']);
    return $userdata;
}

/**
 * gets Input for an email
 * @return array
 */
function getEmail()
{
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("email" => $obj['email']);
    return $userdata;
}

/**
 * *gets Input for Item
 * @return array
 */
function createItem(){
    $json = file_get_contents('php://input');
    $obj = json_decode($json, true);
    $userdata = array("name" => $obj['name'],
        "description" => $obj['description']);
    return $userdata;
}

/**
 * @return array|int
 */
function deleteItems(){
    $json = file_get_contents('php://input');
    $obj = json_decode($json,true);
    $userdata = array("itemId" => $obj['itemId']);
    return $userdata;
}