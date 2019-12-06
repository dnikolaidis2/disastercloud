<?php
require 'vendor/autoload.php';
include 'Utils/Session.php';
include 'Utils/TemplateManager.php';
include 'Models/StudentModel.php';
include 'Utils/Sanitizer.php';

// Retrieve session if it exists. Start a new one otherwise.
$session = Session::getInstance();

// If we are NOT logged in redirect to index page.
if (!($session->logedin && isset($session->username))) {
    header("Location: index.php");
}

// Generate a new templateEngine and manager.
$templates = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templates);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// ----------- Input validation ----------
    if (!isset($_POST['id'])) {
//        TODO:error
        exit();
    }
    else {
        $id = test_input($_POST['id']);
        if (strlen($id) != 10) {
//            TODO: error
            exit();
        }
    }

// ----------- Connect to database  ----------

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"]);
    } catch (PDOException $e) {
        //    TODO: Error
        exit();
    }

// ------------ Delete Student logic ---------

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
//        TODO: error
        exit();
    }
}
else {
    exit();
}
?>