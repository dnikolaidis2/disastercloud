<?php
include 'Utils/Random.php';

class Teacher
{
    public $ID;
    public $NAME;
    public $SURNAME;
    public $USERNAME;
    public $PASSWORD;
    public $EMAIL;

    public function pack()
    {
        return ["id" => $this->ID,
            "name" => $this->NAME,
            "surname" => $this->SURNAME,
            "username" => $this->USERNAME,
            "password" => $this->PASSWORD,
            "email" => $this->EMAIL];
    }
}

class TeacherModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getTeacherByUsername($username)
    {
        $stmt = $this->db->prepare('SELECT * FROM Teachers WHERE USERNAME = :username LIMIT 1');
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Teacher');
        if (!$stmt->execute()) {
            return null;
        } else {
            $result = $stmt->fetch();
            if ($result === false) {
                return null;
            }
        }

        return $result;
    }

    public function getTeacherByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM Teachers WHERE EMAIL = :email LIMIT 1');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Teacher');
        if (!$stmt->execute()) {
            return null;
        } else {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                return null;
            }
        }
        return $result;
    }

    public function createTeacher($name, $surname, $username, $password, $email)
    {
        $stmt = $this->db->prepare('INSERT INTO Teachers VALUES (:id, :name, :surname, :username, :password, :email)');
        $stmt->bindParam(':id', $this->getNewTeacherID(), PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return false;
        }

        return true;
    }

    private function getNewTeacherID()
    {
        while (true) {
            $id = generateRandomString();

            $stmt = $this->db->prepare('SELECT * FROM Teachers WHERE ID = :id LIMIT 1');
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result === false) {
                return $id;
            }
        }
    }
}

?>