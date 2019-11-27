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

$templates = new League\Plates\Engine('Templates');
$templateManager = TemplateManager::getInstance($templates);

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $templateManager->renderIndexLogin();
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST["action"])) {
        $templateManager->renderIndexLogin(null, "No action specified");
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
        $templateManager->renderIndexLogin(null, "Unrecognised action");
    }
} else {
    $templateManager->renderIndexLogin(null, "Unsuported requst method");
}

function login()
{
    global $templateManager;
    if (empty($_POST["username"])) {
        $templateManager->renderIndexLogin(null, "Field username is required");
    } else {
        $username = test_input($_POST["username"]);
        if (strlen($username) > 20) {
            $templateManager->renderIndexLogin("Username too long.");
        }
    }

    if (empty($_POST["password"])) {
        $templateManager->renderIndexLogin(null, "Field passowrd is required");
    } else {
        $password = test_input($_POST["password"]);
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        $templateManager->renderIndexLogin(null, $e->getMessage());
    }

    if ($pdo === null) {
        exit();
    }

    $teacherModel = new TeacherModel($pdo);
    $teacher = $teacherModel->getTeacherByUsername($username);
    // TODO: check if this needs to change from empty to isset
    if (!empty($teacher)) {
        if (password_verify($password, $teacher->password)) {
            global $session;
            $session->logedin = true;
            $session->username = $username;
            header("Location: Teacher.php");
            exit();
        } else {
            $templateManager->renderIndexLogin("Username or password could not be matched.");
        }
    } else {
        $templateManager->renderIndexLogin("Username or password could not be matched.");
    }
}

function signup()
{
    global $templateManager;
    if (empty($_POST["name"])) {
        $templateManager->renderIndexSignup(null, "Field name is required");
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["surname"])) {
        $templateManager->renderIndexSignup(null, "Field surname is required");
    } else {
        $surname = test_input($_POST["surname"]);
    }

    if (empty($_POST["email"])) {
        $templateManager->renderIndexSignup(null, "Field email is required");
    } else {
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $templateManager->renderIndexSignup("Invalid email address.");
        }

        if (strlen($email) > 320) {
            $templateManager->renderIndexSignup("Email address too long.");
        }
    }

    if (empty($_POST["username"])) {
        $templateManager->renderIndexSignup(null, "Field username is required");
    } else {
        $username = test_input($_POST["username"]);
        if (strlen($username) > 20) {
            $templateManager->renderIndexSignup("Username too long.");
        }
    }

    if (empty($_POST["password"])) {
        $templateManager->renderIndexSignup(null, "Field passowrd is required");
    } else {
        $password = test_input($_POST["password"]);
    }

    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=' . $_ENV["MYSQL_HOST"] . ';dbname=' . $_ENV["MYSQL_DATABASE"], $_ENV["MYSQL_USER"], $_ENV["MYSQL_PASSWORD"], array(
            PDO::ATTR_PERSISTENT => true
        ));
    } catch (PDOException $e) {
        $templateManager->renderIndexSignup(null, $e->getMessage());
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
                $templateManager->renderIndexSignup(null, "Error occurred during signup.");
            }
        } else {
            $templateManager->renderIndexSignup("Email address already in use.");
        }
    } else {
        $templateManager->renderIndexSignup("Username has already been taken.");
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