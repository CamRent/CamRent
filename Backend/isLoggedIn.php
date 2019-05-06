<?php
require_once "PHPToJSON.php";

if(isset($_SESSION['email'])){
    isLoggedIn(true);
}
else{
    isLoggedIn(false);
}
