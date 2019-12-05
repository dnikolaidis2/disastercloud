<?php

class TemplateManager
{

    private $engine;
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance(League\Plates\Engine $templates = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
            self::$instance->setEngine($templates);
        }

        return self::$instance;
    }

    public function setEngine(League\Plates\Engine $engine)
    {
        $this->engine = $engine;
    }

    public function renderIndexLogin($previous_data = null,
                                     $username_error = null,
                                     $password_error = null,
                                     $alert_error = null,
                                     $modal_error = null)
    {
        $data['login'] = true;
        $data['previous_data'] = $previous_data;
        $data['username_error'] = $username_error;
        $data['password_error'] = $password_error;
        $data['alert_error'] = $alert_error;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('index', $data);
    }

    public function renderIndexSignup($previous_data = null,
                                      $name_error = null,
                                      $surname_error = null,
                                      $email_error = null,
                                      $username_error = null,
                                      $password_error = null,
                                      $alert_error = null,
                                      $modal_error = null)
    {
        $data['signup'] = true;
        $data['previous_data'] = $previous_data;
        $data['name_error'] = $name_error;
        $data['surname_error'] = $surname_error;
        $data['email_error'] = $email_error;
        $data['username_error'] = $username_error;
        $data['password_error'] = $password_error;
        $data['alert_error'] = $alert_error;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('index', $data);
    }

    public function renderTeacher($username, $students = null, $modal_error = null)
    {
        $data['username'] = $username;
        $data['students'] = $students;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('Teacher', $data);
    }

    public function renderEditStudent($username,
                                      $previous_data = null,
                                      $referer = null,
                                      $name_error = null,
                                      $surname_error = null,
                                      $fathername_error = null,
                                      $grade_error = null,
                                      $mobilenumber_error = null,
                                      $birthday_error = null,
                                      $alert_error = null,
                                      $modal_error = null)
    {
        $data['student'] = $previous_data;
        $data['referer'] = $referer;
        $data['name_error'] = $name_error;
        $data['surname_error'] = $surname_error;
        $data['fathername_error'] = $fathername_error;
        $data['grade_error'] = $grade_error;
        $data['mobilenumber_error'] = $mobilenumber_error;
        $data['birthday_error'] = $birthday_error;
        $data['alert_error'] = $alert_error;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('EditStudent', $data);
    }

    public function renderAddStudent($username,
                                     $previous_data = null,
                                     $name_error = null,
                                     $surname_error = null,
                                     $fathername_error = null,
                                     $grade_error = null,
                                     $mobilenumber_error = null,
                                     $birthday_error = null,
                                     $alert_error = null,
                                     $modal_error = null)
    {
        $data['username'] = $username;
        $data['previous_data'] = $previous_data;
        $data['name_error'] = $name_error;
        $data['surname_error'] = $surname_error;
        $data['fathername_error'] = $fathername_error;
        $data['grade_error'] = $grade_error;
        $data['mobilenumber_error'] = $mobilenumber_error;
        $data['birthday_error'] = $birthday_error;
        $data['alert_error'] = $alert_error;
        $data['modal_error'] = $modal_error;
        echo $this->engine->render('AddStudent', $data);
    }

    public function renderSearchStudent($username, $students = null, $previous_form = null, $modal_error = null)
    {
        $data['username'] = $username;
        $data['previous_form'] = $previous_form;
        $data['students'] = $students;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('SearchStudent', $data);
    }

}

?>