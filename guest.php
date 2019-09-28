<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");

$title = "Дела в порядке";
$required_fields = ["email", "password"];
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    foreach ($_POST as $key => $value) {
        if ($key == "email") {
            if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$key] = "Email должен быть корректным";
            } else if (!isEmailExist($value, $connection)) {
                $errors[$key] = "Нет пользователя с таким email";
            }
        }
    }

    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = "Поле не заполнено";
        }
    }

    if (count($errors) === 0) {
        $user_email = $_POST["email"];
        $arr_password = getInfoFromDatabase($connection, 'SELECT password FROM user WHERE email = "' . $user_email . '"');

        if (password_verify($_POST["password"], $arr_password[0]["password"])) {
            $_SESSION['user_id'] = getInfoFromDatabase($connection, 'SELECT id FROM user WHERE email = "' . $user_email . '"')[0]["id"];
            header("Location: /");
            exit();
        } else {
            $errors["password"] = "Пароль неверный";
        }
    }
}

$guest_content = include_template("guest.php", [
    "errors" => $errors
]);
$layout_content = include_template("layout.php", ["content" => $guest_content, "page_title" => $title]);

print($layout_content);
