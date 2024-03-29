<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");

$title = "Добавить проект";
$required_fields = ["name"];
$errors = [];

if (!$_SESSION['user_id']) {
    header("Location: guest.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    foreach ($_POST as $key => $value) {
        if ($key === "name") {
            if (isProjectExistByName($_POST[$key], $connection, $user)) {
                $errors[$key] = "Проект с таким именем уже существует";
            } else if (strlen($_POST[$key]) >= 255) {
                $errors[$key] = "Слишком длинное название (должно быть не более 255 символов)";
            }
        }
    }

    if (count($errors) === 0) {
        $project_name = $_POST["name"];

        $query_add_project = "INSERT INTO projects (title, user) VALUES (?, ?)";
        $stmt = db_get_prepare_stmt($connection, $query_add_project, [$project_name, $user]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: /");
            exit();
        } else {
            print(mysqli_error($connection));
        }
    }

}

$form_content = include_template("add-project.php", [
    "arr_projects" => $arr_projects,
    "arr_all_tasks" => $arr_all_tasks,
    "user" => $user,
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $form_content, "page_title" => $title, "user_name" => $user_name, "guest_page" => false]);

print($layout_content);
