<?php
require_once "PHPToJSON.php";
session_start();

if(isset($_SESSION['email'])){
    isLoggedIn(true);
}
else{
    isLoggedIn(false);
}
