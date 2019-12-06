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

// Display page.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $templateManager->renderAddStudent($session->username);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

// ---------------- Input validation and sanitization --------------

    $name = "";
    $name_error = null;
    if (empty($_POST['name'])) {
        $name_error = "name is required.";
    }
    else {
        $name = test_input($_POST['name']);
    }

    $surname = "";
    $surname_error = null;
    if (empty($_POST['surname'])) {
        $surname_error = "surnname is required.";
    }
    else {
        $surname = test_input($_POST['surname']);
    }

    $fathername = "";
    $fathername_error = null;
    if (empty($_POST['fathername'])) {
        $fathername_error = "fathername is required.";
    }
    else {
        $fathername = test_input($_POST['fathername']);
    }


    $grade = "";
    $grade_error = null;
    if (!isset($_POST['grade'])) {
        $grade_error = "grade is required.";
    }
    else {
        $grade = filter_var($_POST['grade'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $grade = filter_var($grade, FILTER_VALIDATE_FLOAT);
        if ($grade === false) {
            $grade_error = "Could not validate grade as number.";
        }
        else {
            if ($grade < 0 or $grade > 10) {
                $grade_error = "Grade must be between 0 and 10.";
            }
        }
    }

    $mobilenumber = "";
    $mobilenumber_error = null;
    if (empty($_POST['mobilenumber'])) {
        $mobilenumber_error = "mobilenumber is required.";
    }
    else {
        $mobilenumber = filter_var($_POST['mobilenumber'], FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($mobilenumber, FILTER_VALIDATE_INT) === false) {
            $mobilenumber_error = "Field could no be validated as a number.";
        }
        else {
            if (strlen($mobilenumber) !== 10 and strlen($mobilenumber) !== 14) {
                $mobilenumber_error = "Phone number must be either 10 or 14 characters.";
            }
        }
    }

    $birthday = "";
    $birthday_error = null;
    if (empty($_POST['birthday'])) {
        $birthday_error = "birthday is required.";
    }
    else {
        $birthday = test_input($_POST['birthday']);
        DateTime::createFromFormat('Y-m-d', $birthday);
        $date_errors = DateTime::getLastErrors();
        if ($date_errors['warning_count'] + $date_errors['error_count'] > 0) {
            $birthday_error = "Date of birth could be validated.";
        }
    }

    $previous_data = ["name" => $name,
        "surname" => $surname,
        "fathername" => $fathername,
        "grade" => $grade,
        "mobilenumber" => $mobilenumber,
        "birthday" => $birthday];

//  If there was an error during input validation. Output message and exit.
    if ($name_error !== null or
        $surname_error !== null or
        $fathername_error !== null or
        $grade_error !== null or
        $mobilenumber_error !== null or
        $birthday_error !== null) {
        $templateManager->renderAddStudent($session->username,
            $previous_data,
            $name_error,
            $surname_error,
            $fathername_error,
            $grade_error,
            $mobilenumber_error,
            $birthday_error);
        exit();
    }

// ---------------- Connect to database --------------

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"]
            . ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"]);
    } catch (PDOException $e) {
        $templateManager->renderAddStudent($session->username,
            $previous_data,
            null,
            null,
            null,
            null,
            null,
            null,
            "Could not connect to database.");
        exit();
    }

// ---------------- Add student logic --------------

    $studentModel = new StudentModel($pdo);
    $student = $studentModel->getStudentByMobilenumber($mobilenumber);
    if ($student !== null) {
        $templateManager->renderAddStudent($session->username,
            $previous_data,
            null,
            null,
            null,
            null,
            "Phone number is already registered to another student.");
        exit();
    }

    if ($studentModel->createStudent($name, $surname, $fathername, $grade, $mobilenumber, $birthday)) {
        header("Location: Teacher.php");
        exit();
    }
    else {
        $templateManager->renderAddStudent($session->username,
            $previous_data,
            null,
            null,
            null,
            null,
            null,
            null,
            "Could not creat student.");
        exit();
    }
}
else {
    $templateManager->renderAddStudent($session->username,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        "Unsupported request method.");
    exit();
}
?>