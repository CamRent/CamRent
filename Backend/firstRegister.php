<?php

require_once "JSONToPHP.php";
require_once "PHPToJSON.php";
require_once "usefulFunctions.php";

firstRegister();
function firstRegister()
{

    sendEmail($_POST('email'), generateActivationcode());

}
