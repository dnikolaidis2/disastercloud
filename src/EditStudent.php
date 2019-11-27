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

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (empty($_GET['id'])) {
        //    TODO: Error
        exit(1);
    }
    else
    {
        $id = test_input($_GET['id']);
        if (strlen($id) != 10) {
//            TODO: Error
        }
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        //    TODO: Error
    }

    $studentModel = new StudentModel($pdo);
    $student = $studentModel->getStudentById($id);

    $templateManager->renderEditStudent($student->pack());

}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

}
else{
//    TODO: Error
}

?>