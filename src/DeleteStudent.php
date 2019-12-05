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



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['id'])) {
//        TODO:error
        exit();
    }
    else {
        $id = test_input($_POST['id']);
        if (strlen($id) != 10) {
//            TODO: error
//            exit();
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
    if ($studentModel->deleteStudent($id)) {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . end(explode("/", $_SERVER['HTTP_REFERER'])));
        }
        else {
            header("Location: Teacher.php");
        }
        exit();
    }
    else {
        var_dump($pdo->errorInfo());
//        TODO: error
    }
}
else {
//    TODO: error
    exit();
}
?>