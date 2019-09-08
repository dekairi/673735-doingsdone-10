<?php

require_once("helpers.php");
require_once("data.php");

function getPostValue($name) {
    return $_POST[$name] ?? "";
}

$required_fields = ["name", "project"];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key == "date") {
            if(!is_date_valid($value)) {
                $errors[$key] = "Введите дату в корректном формате";
            } else if (getDateDifference($value) < 0) {
                $errors[$key] = "Дата не должна быть позже сегодняшней";
            }
        }

        if ($key == "name") {
            if (strlen($_POST[$key]) == 0) {
                $errors[$key] = "Длинна поля не должна быть равна нулю";
            }
        }

        if ($key == "project") {
            if (!isProjectExist($_POST[$key], $connection)) {
                $errors[$key] = "Проект не существует";
            }
        }
    }

    $errors = array_filter($errors);

    if (count($errors)) {

    }
}

$form_content = include_template("form.php", [
    "arr_tasks" => $arr_tasks,
    "arr_projects" => $arr_projects,
    "arr_all_tasks" => $arr_all_tasks,
    "show_complete_tasks" => $show_complete_tasks,
    "user" => $user,
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $form_content, "page_title" => $title, "user_name" => $user_name]);

print($layout_content);
