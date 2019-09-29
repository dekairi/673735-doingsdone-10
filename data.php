<?php
require_once("functions.php");
require_once("init.php");

$user = intval($_SESSION['user_id']);
$user_name = getInfoFromDatabase($connection, 'SELECT name FROM user WHERE id = ' . $user)[0]["name"];
