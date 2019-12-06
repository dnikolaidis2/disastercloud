<?php
require 'vendor/autoload.php';
include 'Utils/Session.php';
include 'Utils/TemplateManager.php';
include 'Models/StudentModel.php';

// Retrieve session if it exists. Start a new one otherwise.
$session = Session::getInstance();

// If we are NOT logged in redirect to index page.
if (!($session->logedin && isset($session->username))) {
    header("Location: index.php");
}

// Generate a new templateEngine and manager.
$templates = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templates);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//    Connect to database and retrieve all students.
//    Render student table with all actions.

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"]);
    } catch (PDOException $e) {
        $templateManager->renderTeacher($session->username,
            null,
            "Could not connect to database.");
        exit();
    }

    $studentModel = new StudentModel($pdo);
    $students = $studentModel->getAllStudents();
    if ($students === null or empty($students)){
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