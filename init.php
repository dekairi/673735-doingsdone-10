<?php
session_start();

date_default_timezone_set("Europe/Moscow");
$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connection = mysqli_connect("localhost:8889", "root", "root", "doingsdone");


if($connection === false) {
    print("Ошибка подключения: " . mysqli_connect_error());
    die();
} else {
    mysqli_set_charset($connection, "utf8");
}

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
