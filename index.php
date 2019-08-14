<?php

require_once("helpers.php");

$title = "Дела в порядке";
$show_complete_tasks = rand(0, 1);
$arr_projects = ["Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];
$arr_tasks = [
    [
        "task_description" => "Собеседование в IT компании",
        "date_done" => "01.12.2018",
        "category" => $arr_projects[2],
        "is_done" => false
    ],
    [
        "task_description" => "Выполнить тестовое задание",
        "date_done" => "25.12.2018",
        "category" => $arr_projects[2],
        "is_done" => false
    ],
    [
        "task_description" => "Сделать задание первого раздела",
        "date_done" => "21.12.2018",
        "category" => $arr_projects[1],
        "is_done" => true
    ],
    [
        "task_description" => "Встреча с другом",
        "date_done" => "22.12.2018",
        "category" => $arr_projects[0],
        "is_done" => false
    ],
    [
        "task_description" => "Купить корм для кота",
        "date_done" => "",
        "category" => $arr_projects[3],
        "is_done" => false
    ],
    [
        "task_description" => "Заказать пиццу",
        "date_done" => "",
        "category" => $arr_projects[3],
        "is_done" => false
    ]
];

function getQuantityOfProjectTasks($project_name, array $arr_tasks) {
    $tasks_number = 0;

    foreach ($arr_tasks as $task) {
        if ($task["category"] === $project_name)
            $tasks_number++;
        }

    return $tasks_number;
}

$page_content = include_template("main.php", ["arr_tasks" => $arr_tasks, "arr_projects" => $arr_projects]);
$layout_content = include_template("layout.php", ["content" => $page_content, "page_title" => $title]);

print($layout_content);
