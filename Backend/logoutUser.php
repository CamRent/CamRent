<?php
require_once "PHPToJSON.php";
logoutUser();

/**
 * a simple script to log the user out
 */
function logoutUser(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION);
    session_destroy();
    session_write_close();
    sendSuccess("You have been logged out");
    exit();
}




