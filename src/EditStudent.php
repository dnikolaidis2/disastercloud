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
        header("Location: Teacher.php");
        exit();
    }
    else
    {
        $id = test_input($_GET['id']);
        if (strlen($id) != 10) {
            $templateManager->renderEditStudent($session->username,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                "Invalid id.");
            exit();
        }
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        $templateManager->renderEditStudent($session->username,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            "Could not connect to database.");
    }

    if (isset($_SERVER["HTTP_REFERER"])) {
        $referer = end(explode("/", $_SERVER['HTTP_REFERER']));
    }

    $studentModel = new StudentModel($pdo);
    $student = $studentModel->getStudentById($id);
    if ($student === null) {
        $templateManager->renderEditStudent($session->username,
            null,
            $referer,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            "Invalid student id.");
    }

    $templateManager->renderEditStudent($student->pack(), $student->pack(), $referer);
}
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = "";
    $id_error = null;
    if (empty($_POST['id'])) {
        $id_error = "id field is required.";
    }
    else {
        $id = test_input($_POST['id']);
        if (strlen($id) != 10) {
            $id_error = "Invalid id provided.";
        }
    }

    $name = "";
    $name_error = null;
    if (empty($_POST['name'])) {
        $name_error = "Name is required";
    }
    else {
        $name = test_input($_POST['name']);
    }

    $surname = "";
    $surname_error = null;
    if (empty($_POST['surname'])) {
        $surname_error = "Surname is required.";
    }
    else {
        $surname = test_input($_POST['surname']);
    }

    $fathername = "";
    $fathername_error = null;
    if (empty($_POST['fathername'])) {
        $fathername_error = "Fathername is required.";
    }
    else {
        $fathername = test_input($_POST['fathername']);
    }

    $grade = "";
    $grade_error = null;
    if (!isset($_POST['grade'])) {
        $grade_error = "Grade is required.";
    }
    else {
        $grade = filter_var($_POST['grade'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $grade = filter_var($grade, FILTER_VALIDATE_FLOAT);
        if ($grade === false) {
            $grade_error = "Could validate grade as number.";
        }
        else {
            if ($grade < 0 or $grade > 10) {
                $grade_error = "Grade must be between 0.0 and 10.0.";
            }
        }
    }

    $mobilenumber = "";
    $mobilenumber_error = null;
    if (empty($_POST['mobilenumber'])) {
        $mobilenumber_error = "Mobilenumber is required.";
    }
    else {
        $mobilenumber = filter_var($_POST['mobilenumber'], FILTER_SANITIZE_NUMBER_INT);
        if (filter_var($mobilenumber, FILTER_VALIDATE_INT) === false) {
            $mobilenumber_error = "Could not validate mobilenumber.";
        }
        else {
            if (strlen($mobilenumber) !== 10 and strlen($mobilenumber) !== 14) {
                $mobilenumber_error = "Number is not the length of a valid phone number.";
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
            $birthday_error = "Date of birth is not correctly formatted.";
        }
    }

    $referer = null;
    if (isset($_POST['referer'])) {
        $referer = $_POST['referer'];
    }

    $previous_data = ["id" => $id,
        "name" => $name,
        "surname" => $surname,
        "fathername" => $fathername,
        "grade" => $grade,
        "mobilenumber" => $mobilenumber,
        "birthday" => $birthday];

    if ($id_error === null or
        $name_error === null or
        $surname_error === null or
        $fathername_error === null or
        $grade_error === null or
        $mobilenumber_error === null or
        $birthday_error === null) {
        $templateManager->renderEditStudent($session->username,
            $previous_data,
            $referer,
            $name_error,
            $surname_error,
            $fathername_error,
            $grade_error,
            $mobilenumber_error,
            $birthday_error,
            null,
            $id_error);
        exit();
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        $templateManager->renderEditStudent($session->username,
            $previous_data,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            "Could not connect to database.");
        exit();
    }

    $studentModel = new StudentModel($pdo);
    $student = $studentModel->getStudentByMobilenumber($mobilenumber);
    if ($student !== null) {
        if (strcmp($student->ID, $id) !== 0) {
            $templateManager->renderEditStudent($session->username,
                $previous_data,
                $referer,
                null,
                null,
                null,
                null,
                "Student already exists with this phone number.");
            exit();
        }
    }

    if ($studentModel->updateStudentById($id, $name, $surname, $fathername, $grade, $mobilenumber, $birthday)) {
        if ($referer !== null) {
            header("Location: " . $_POST['referer']);
        }
        else {
            header("Location: Teacher.php");
        }
        exit();
    }
    else {
        $templateManager->renderEditStudent($session->username,
            $previous_data,
            $referer,
            null,
            null,
            null,
            null,
            null,
            null,
            "Error occurred during updating of student.");
        exit();
    }
}
else{
    $templateManager->renderEditStudent($session->username,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        null,
        "Invalid request method.");
}

?>