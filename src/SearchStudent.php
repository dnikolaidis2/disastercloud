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
        $templateManager->renderSearchStudent();
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
            $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], array(
                PDO::ATTR_PERSISTENT => true
            ));
        } catch (PDOException $e) {
            //    TODO: Error
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
        $templateManager->renderSearchStudent($student_array);
    }
}
else {
    exit();
}

?>