<?php
require 'vendor/autoload.php';
include 'Utils/Session.php';
include 'Utils/TemplateManager.php';
include 'Models/StudentModel.php';
include 'Utils/Sanitizer.php';

$session = Session::getInstance();

if (!($session->logedin && isset($session->username))) {
    header("Location: index.php");
}

$templates = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templates);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_GET)) {
        $templateManager->renderSearchStudent($session->username);
        exit();
    }
    else {
        $name = test_input($_GET['name']);
        $surname = test_input($_GET['surname']);
        $fathername = test_input($_GET['fathername']);
        $grade = test_input($_GET['grade']);
        $mobilenumber = test_input($_GET['mobilenumber']);
        $birthday = test_input($_GET['birthday']);

        $pdo = null;
        try {
            $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
                ';dbname=' . $_ENV["MYSQL_DATABASE"],
                $_ENV["MYSQL_USER"],
                $_ENV["MYSQL_PASSWORD"]);
        } catch (PDOException $e) {
            $templateManager->renderSearchStudent($session->username,
                null,
                null,
                "Could not establish connection to database.");
        }

        $studentModel = new StudentModel($pdo);
        $students = $studentModel->searchForStudent('%' . $name . '%',
            '%' . $surname . '%',
            '%' . $fathername . '%',
            '%' . $grade . '%',
            '%' . $mobilenumber . '%',
            '%' . $birthday . '%');

        $student_array = [];
        foreach ($students as $student) {
            array_push($student_array, $student->pack());
        }

        $previous_data = ["name" => $name,
            "surname" => $surname,
            "fathername" => $fathername,
            "grade" => $grade,
            "mobilenumber" => $mobilenumber,
            "birthday" => $birthday];
        $templateManager->renderSearchStudent($session->username, $student_array, $previous_data);
    }
}
else {
    $templateManager->renderSearchStudent($session->username,
        null,
        null,
        "Unsupported request method.");
    exit();
}

?>