<?php

require_once("helpers.php");

$link = mysqli_init();
mysqli_options($link, MYSQLI_OPT_INT_AND_FLOAT_NATIVE, 1);
$connection = mysqli_connect("127.0.0.1:8889", "root", "root", "doingsdone");

$user_name = "Ирина";
$user = 0;

if($connection == false)
    print("Ошибка подключения: " . mysqli_connect_error());
else {
    mysqli_set_charset($connection, "utf8");

    $arr_projects = getProjects($connection, $user);

    $arr_tasks = getTasks($connection, $user);
}

function getTasks($conn, $user) {
    $query_task = 'SELECT * FROM task WHERE user = ' . $user;
    $result = mysqli_query($conn, $query_task);
    if ($result) {
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    return $result;
}

function getProjects($conn, $user) {
    $query_project = 'SELECT title from projects WHERE user = ' . $user;
    $result_project = mysqli_query($conn, $query_project);
    if ($result_project) {
        $result_project = mysqli_fetch_all($result_project, MYSQLI_ASSOC);
    }
    return $result_project;
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
