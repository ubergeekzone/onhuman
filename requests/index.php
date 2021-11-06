<?php
require '../vendor/autoload.php';

$service = "";
$service = $_GET['service'];

if(isset($service)) {
    include($service.".php");
} 