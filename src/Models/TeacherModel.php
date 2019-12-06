<?php
include 'Utils/Random.php';

/**
 * Class Teacher
 * Wrapper for Teacher data.
 */
class Teacher
{
    public $ID;
    public $NAME;
    public $SURNAME;
    public $USERNAME;
    public $PASSWORD;
    public $EMAIL;

    /**
     * Pack Teacher data in array for easier displaying in a form.
     * @return array of Teacher data.
     */
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

/**
 * Class TeacherModel
 * Wrapper for all interactions with database table Teacher.
 */
class TeacherModel
{
    protected $db;

    /**
     * TeacherModel constructor.
     * @param PDO $db PDO database connection.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Fetch a Teacher form database by username.
     * @param string $username of Teacher to retrieve.
     * @return Teacher|null Teacher class with data or null if query failed.
     */
    public function getTeacherByUsername($username)
    {
        $stmt = $this->db->prepare('SELECT * FROM Teachers WHERE USERNAME = :username LIMIT 1');
//      Fetch mode that automatically packs data in class.
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

    /**
     * Fetch a Teacher form database by email.
     * @param string $email of Teacher to retrieve.
     * @return Teacher|null Teacher class with data of fetched teacher. Null if the query failed.
     */
    public function getTeacherByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM Teachers WHERE EMAIL = :email LIMIT 1');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
//      Fetch mode that automatically packs data in class.
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

    /**
     * Create a new Teacher entry in database.
     * @param string $name of new Teacher.
     * @param string $surname of new Teacher.
     * @param string $username of new Teacher.
     * @param string $password of new Teacher.
     * @param string $email of new Teacher.
     * @return bool true if query was successful, false otherwise.
     */
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

    /**
     * Generate a new unique Teacher ID.
     * @return string unique new Teacher ID.
     */
    private function getNewTeacherID()
    {
//      Generate a random string and check if it exists un the database.
//      If it exists try a new one until you get a unique ID.
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