<?php

require_once("helpers.php");

$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connection = mysqli_connect("localhost:8889", "root", "root", "doingsdone");

$user_name = "Ирина";
$user = 0;

if($connection == false)
    print("Ошибка подключения: " . mysqli_connect_error());
else {
    mysqli_set_charset($connection, "utf8");

    $query_projects = 'SELECT title from projects WHERE user = ' . $user;
    $query_tasks = 'SELECT * FROM task WHERE user = ' . $user;

    $arr_projects = getInfoFromDatabase($connection, $query_projects);
    $arr_tasks = getInfoFromDatabase($connection, $query_tasks);
}

function getInfoFromDatabase($conn, $sql_query) {
    $query_task = $sql_query;
    $result = mysqli_query($conn, $query_task);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $result;
}

$title = "Дела в порядке";
$show_complete_tasks = rand(0, 1);

function isTaskImportant($date_todo) {
    $result = false;

    $date = strtotime($date_todo);
    $now = strtotime("now");
    $diff = floor(($date - $now) / 3600);

    if ($diff <= 24 && $diff > 0) {
        $result = true;
    }

    return $result;
}

function getQuantityOfProjectTasks($project_name, array $arr_tasks) {
    $tasks_number = 0;

    foreach ($arr_tasks as $task) {
        if ($task["category"] === $project_name)
            $tasks_number++;
        }

    return $tasks_number;
}

$page_content = include_template("main.php", ["arr_tasks" => $arr_tasks, "arr_projects" => $arr_projects, "show_complete_tasks" => $show_complete_tasks]);
$layout_content = include_template("layout.php", ["content" => $page_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
