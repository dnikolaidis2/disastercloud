<?php
require 'vendor/autoload.php';
include 'Utils/Session.php';
include 'Models/TeacherModel.php';
include 'Utils/TemplateManager.php';
include 'Utils/Sanitizer.php';

$session = Session::getInstance();

if ($session->logedin && isset($session->username)) {
    header("Location: Teacher.php");
}

$templateEngine = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templateEngine);

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $templateManager->renderIndexLogin();
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["action"])) {
        $templateManager->renderIndexLogin(null,
            null,
            null,
            null,
            "No action specified");
        exit();
    } else {
        $action = test_input($_POST["action"]);
    }

    if ($action === "login") {
        login();
    } elseif ($action === "signup") {
        signup();
    } elseif ($action === "logout") {
        logout();
    } else {
        $templateManager->renderIndexLogin(null,
            null,
            null,
            null,
            "Unrecognised action");
        exit();
    }
} else {
    $templateManager->renderIndexLogin(null,
        null,
        null,
        null,
        "Unsuported requst method");
    exit();
}

function login()
{
    global $templateManager;

    $username_error = null;
    $username = "";
    if (empty($_POST["username"])) {
        $username_error = "Username is required.";
    } else {
        $username = test_input($_POST["username"]);
        if (strlen($username) > 20) {
            $username_error = "Username too long.";
        }
    }

    $password_error = null;
    $password = "";
    if (empty($_POST["password"])) {
        $password_error = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    $previous_data = ["username" => $username, "password" => $password];
    if ($username_error !== null or $password_error !== null) {
        $templateManager->renderIndexLogin($previous_data, $username_error, $password_error);
        exit();
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"]);
    } catch (PDOException $e) {
        $templateManager->renderIndexLogin($previous_data, null, null, $e->getMessage());
        exit();
    }

    if ($pdo === null) {
        exit();
    }

    $teacherModel = new TeacherModel($pdo);
    $teacher = $teacherModel->getTeacherByUsername($username);
    if (!empty($teacher)) {
        if (password_verify($password, $teacher->PASSWORD)) {
            global $session;
            $session->logedin = true;
            $session->username = $username;
            header("Location: Teacher.php");
            exit();
        } else {
            $templateManager->renderIndexLogin($previous_data,
                null,
                null,
                "Username or password could not be matched.");
            exit();
        }
    } else {
        $templateManager->renderIndexLogin($previous_data,
            null,
            null,
            "Username or password could not be matched.");
        exit();
    }
}

function signup()
{
    global $templateManager;

    $name = "";
    $name_error = null;
    if (empty($_POST["name"])) {
        $name_error = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    $surname = "";
    $surname_error = null;
    if (empty($_POST["surname"])) {
        $surname_error = "Surname is required";
    } else {
        $surname = test_input($_POST["surname"]);
    }

    $email = "";
    $email_error = null;
    if (empty($_POST["email"])) {
        $email_error = "Email is required.";
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = "Invalid email address.";
        }
        else {
            if (strlen($email) > 320) {
                $email_error = "Email address too long.";
            }
        }
    }

    $username = "";
    $username_error = null;
    if (empty($_POST["username"])) {
        $username_error = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
        if (strlen($username) > 20) {
            $username_error = "Username too long.";
        }
    }

    $password = "";
    $password_error = null;
    if (empty($_POST["password"])) {
        $password_error = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    $previous_data = ["name" => $name,
        "surname" => $surname,
        "email" => $email,
        "username" => $username,
        "password" => $password,
        ];

    if ($name_error !== null or
    $surname_error !== null or
    $email_error !== null or
    $username_error !== null or
    $password_error !== null) {
        $templateManager->renderIndexSignup($previous_data, $name_error, $surname_error,
            $email_error, $username_error, $password_error);
        exit();
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] .
            ';dbname=' . $_ENV["MYSQL_DATABASE"],
            $_ENV["MYSQL_USER"],
            $_ENV["MYSQL_PASSWORD"]);
    } catch (PDOException $e) {
        $templateManager->renderIndexSignup($previous_data, null, null, null,
            null, null, $e->getMessage());
        exit();
    }

    if ($pdo === null) {
        exit();
    }

    $teacherModel = new TeacherModel($pdo);
    $teacher = $teacherModel->getTeacherByUsername($username);
    if (empty($teacher)) {
        $teacher = $teacherModel->getTeacherByEmail($email);
        if (empty($teacher)) {
            if ($teacherModel->createTeacher($name, $surname, $username, $password, $email)) {
                global $session;
                $session->logedin = true;
                $session->username = $username;
                header("Location: Teacher.php");
                exit();
            } else {
                $templateManager->renderIndexSignup($previous_data,
                    null,
                    null,
                    null,
                    null,
                    null,
                    "Error occurred during signup.");
                exit();
            }
        } else {
            $templateManager->renderIndexSignup($previous_data,
                null,
                null,
                "Email address already in use.");
            exit();
        }
    } else {
        $templateManager->renderIndexSignup($previous_data,
            null,
            null,
            null,
            "Username has already been taken.");
        exit();
    }
}

function logout()
{
    global $session;
    $session->destroy();
    header("Location: index.php");
    exit();
}

?>