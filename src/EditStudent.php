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
    if (empty($_POST['id'])) {
//        TODO:error
    }
    else {
        $id = test_input($_POST['id']);
        if (strlen($id) != 10) {
//            TODO: error
        }
    }

    if (empty($_POST['name'])) {
//        TODO:error
    }
    else {
        $name = test_input($_POST['name']);
    }

    if (empty($_POST['surname'])) {
//        TODO:error
    }
    else {
        $surname = test_input($_POST['surname']);
    }

    if (empty($_POST['fathername'])) {
//        TODO:error
    }
    else {
        $fathername = test_input($_POST['fathername']);
    }

    if (!isset($_POST['grade'])) {
//        TODO:error
    }
    else {
        $grade = filter_var($_POST['grade'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $grade = filter_var($grade, FILTER_VALIDATE_FLOAT);
        if ($grade === false) {
//            TODO: error
        }
    }

    if (empty($_POST['mobilenumber'])) {
//        TODO:error
    }
    else {
        $mobilenumber = filter_var($_POST['mobilenumber'], FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($mobilenumber, FILTER_VALIDATE_INT) === false) {
//            TODO: error
        }
        else {
            if (strlen($mobilenumber) > 14) {
//                TODO: error
            }
        }
    }

    if (empty($_POST['birthday'])) {
//        TODO:error
    }
    else {
        $birthday = test_input($_POST['birthday']);
        DateTime::createFromFormat('Y-m-d', $birthday);
        $date_errors = DateTime::getLastErrors();
        if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
//            TODO:error
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
    $student = $studentModel->getStudentByMobilenumber($mobilenumber);
    if ($student !== null) {
        if (strcmp($student->ID, $id) !== 0) {
//        TODO: error
            exit();
        }
    }

    if ($studentModel->updateStudentById($id, $name, $surname, $fathername, $grade, $mobilenumber, $birthday)) {
        header("Location: Teacher.php");
        exit();
    }
    else {
        var_dump($pdo->errorInfo());
//        TODO: error
    }
}
else{
//    TODO: Error
}

?>