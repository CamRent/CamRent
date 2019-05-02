<?php
require_once "PHPToJSON.php";
require_once "config.php";
require_once "usefulFunctions.php";
sendOverwiewOfAllItems(getAllAvailableItems($pdo));
