<?php

require_once("helpers.php");

$title = "Дела в порядке";
$user_name = "Константин";
$show_complete_tasks = rand(0, 1);
$arr_projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$arr_tasks = [
    [
        "task_description" => "Собеседование в IT компании",
        "date_todo" => "01.12.2019",
        "category" => $arr_projects[2],
        "is_done" => false
    ],
    [
        "task_description" => "Выполнить тестовое задание",
        "date_todo" => "17.08.2019",
        "category" => $arr_projects[2],
        "is_done" => false
    ],
    [
        "task_description" => "Сделать задание первого раздела",
        "date_todo" => "16.12.2019",
        "category" => $arr_projects[1],
        "is_done" => true
    ],
    [
        "task_description" => "Встреча с другом",
        "date_todo" => "22.12.2019",
        "category" => $arr_projects[0],
        "is_done" => false
    ],
    [
        "task_description" => "Купить корм для кота",
        "date_todo" => "",
        "category" => $arr_projects[3],
        "is_done" => false
    ],
    [
        "task_description" => "Заказать пиццу",
        "date_todo" => "",
        "category" => $arr_projects[3],
        "is_done" => false
    ]
];

function isTaskImportant($date_todo) {
    $date = strtotime($date_todo);
    $now = strtotime("now");
    $diff = floor(($date - $now) / 3600);

    return($diff <= 24 && $diff > 0 ? true : false);
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
