<?php
require 'vendor/autoload.php';
include 'Utils/Session.php';
include 'Utils/TemplateManager.php';
include 'Models/StudentModel.php';

$session = Session::getInstance();

if (!($session->logedin && isset($session->username))) {
    header("Location: index.php");
}

$templates = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templates);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        $templateManager->renderTeacher($session->username,
            null,
            "Could not connect to database.");
        exit();
    }

    $studentModel = new StudentModel($pdo);
    $students = $studentModel->getAllStudents();
    if ($students === null){
        $templateManager->renderTeacher($session->username, null);
        exit();
    }

    $student_array = [];
    foreach ($students as $student) {
        array_push($student_array, $student->pack());
    }

    $templateManager->renderTeacher($session->username, $student_array);
}
else {
    $templateManager->renderTeacher($session->username,
        null,
        "Unsupported request method.");
}
?>