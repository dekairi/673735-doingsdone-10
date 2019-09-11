<?php

require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");


$title = "Дела в порядке";

$page_content = include_template("main.php", [
    "arr_tasks" => $arr_tasks,
    "arr_projects" => $arr_projects,
    "arr_all_tasks" => $arr_all_tasks,
    "show_complete_tasks" => $show_complete_tasks,
    "user" => $user
]);
$layout_content = include_template("layout.php", ["content" => $page_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
