<?php

class TemplateManager
{

    private $engine;
    private static $instance;

    private function __construct()
    {
    }

    /**
     * Returns THE instance of 'Session'.
     * The session is automatically initialized if it wasn't.
     * @param League\Plates\Engine templates engine to assign to TemplateManager
     * @return object
     **/
    public static function getInstance(League\Plates\Engine $templates = null)
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
            self::$instance->setEngine($templates);
        }

        return self::$instance;
    }

    /**
     * Set the egnine of the TemplateManager manually.
     * @param \League\Plates\Engine $engine
     */
    public function setEngine(League\Plates\Engine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * Render Index page with login selected.
     * @param null $previous_data to populate the form with.
     * @param null $username_error to display for username field.
     * @param null $password_error to display for password field.
     * @param null $alert_error to display in alert.
     * @param null $modal_error to display in modal.
     */
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

    /**
     * Render index page with signup selected.
     * @param null $previous_data to populate the form with.
     * @param null $name_error to display for name field.
     * @param null $surname_error to display for surname field.
     * @param null $email_error to display for email field.
     * @param null $username_error to display for username field.
     * @param null $password_error to display for password field.
     * @param null $alert_error to display in alert.
     * @param null $modal_error to display in modal.
     */
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

    /**
     * Render Teacher page.
     * @param $username
     * @param null $students array of student to display in table.
     * @param null $modal_error to display in a modal.
     */
    public function renderTeacher($username, $students = null, $modal_error = null)
    {
        $data['username'] = $username;
        $data['students'] = $students;
        $data['modal_error'] = $modal_error;

        echo $this->engine->render('Teacher', $data);
    }

    /**
     * Render Edit Student page.
     * @param $username
     * @param null $previous_data to fill form with.
     * @param null $referer from where did we access this page.
     * @param null $name_error to display for name field.
     * @param null $surname_error to display for surname field.
     * @param null $fathername_error to display for fathername field.
     * @param null $grade_error to display for grade name.
     * @param null $mobilenumber_error to display for mobilenumber field.
     * @param null $birthday_error to display for birthday field.
     * @param null $alert_error to display in alert.
     * @param null $modal_error to display in modal.
     */
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

    /**
     * Render Add Student page.
     * @param $username
     * @param null $previous_data to fill form with.
     * @param null $name_error to display for name field.
     * @param null $surname_error to display for surname field.
     * @param null $fathername_error to display for fathername field.
     * @param null $grade_error to display for grade field.
     * @param null $mobilenumber_error to display for moobilenumber field.
     * @param null $birthday_error to display for birthday field.
     * @param null $alert_error to display in alert.
     * @param null $modal_error to display in modal.
     */
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

    /**
     * @param $username
     * @param null $students array of students to display in table.
     * @param null $previous_form data to fill in form.
     * @param null $modal_error to display in modal.
     */
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