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

$pdo = null;
try {
    $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], array(
        PDO::ATTR_PERSISTENT => true
    ));
} catch (PDOException $e) {
//    TODO: Error
}

$studentModel = new StudentModel($pdo);
$students = $studentModel->getAllStudents();
if ($students === null){
//    TODO: Error
}

$student_array = [];
foreach ($students as $student) {
    array_push($student_array, $student->pack());
}

$templateManager->renderTeacher($student_array);

?>