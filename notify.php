<?php
require_once("init.php");
require_once("functions.php");
require_once("helpers.php");
require_once("data.php");
require_once("main-data.php");
require_once("vendor/autoload.php");

$transport = new Swift_SmtpTransport('phpdemo.ru', 25);
$transport->setUsername("keks@phpdemo.ru");
$transport->setPassword("htmlacademy");

$message = new Swift_Message();
$message->setSubject("Уведомление от сервиса 'Дела в порядке'");
$message->setFrom("keks@htmlacademy.ru", "keks@phpdemo.ru");

$users_query = 'SELECT id FROM user';
$arr_users_id = getInfoFromDatabase($connection, $users_query);

for ($i = 0; $i < count($arr_users_id); $i++) {
    $user_id = intval($arr_users_id[$i]['id']);
    $date = changeDateFormat("now", 'Y-m-d');
    $important_tasks_query = 'SELECT title FROM task WHERE user=' . $user_id . ' AND status=0 AND date(date_todo)="' . $date . '"';
    $arr_important_tasks = getInfoFromDatabase($connection, $important_tasks_query);

    $user_name_query = 'SELECT name FROM user WHERE id=' . $user_id;
    $user_name = getInfoFromDatabase($connection, $user_name_query);

    $full_message = 'Уважаемый, ' . $user_name[0]['name'];

    if (count($arr_important_tasks) > 1) {
        $task_titles = '"' . $arr_important_tasks[0]['title'] . '"';
        for ($i = 1; $i < count($arr_important_tasks); $i++) {
            $task_titles .= ', "' . $arr_important_tasks[$i]['title'] . '"';
        }

        $full_message .= '. У вас запланированы задачи: ' . $task_titles . ' на ';
    } else {
        $full_message .= '. У вас запланирована задача: "' . $arr_important_tasks[0]['title'] . '" на ';
    }

    if (count($arr_important_tasks) != 0) {
        $full_message .= $date . '.';

        $user_email_query = 'SELECT email FROM user WHERE id=' . $user_id;
        $user_email = getInfoFromDatabase($connection, $user_email_query);

        $message->setBody($full_message, 'text/html');
        $message->setTo($user_email[0]['email'], $user_name[0]['name']);

        $mailer = new Swift_Mailer($transport);
        $result = $mailer->send($message);

        if ($result) {
            print("Сообщение отправлено: " . $user_email[0]['email'] . " ");
        }
    }
}
