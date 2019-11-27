<?php
include 'Utils/Random.php';

class Student
{
    public $ID;
    public $NAME;
    public $SURNAME;
    public $FATHERNAME;
    public $GRADE;
    public $MOBILENUMBER;
    public $BIRTHDAY;

    public function pack()
    {
        return ["id" => $this->ID,
            "name" => $this->NAME,
            "surname" => $this->SURNAME,
            "fathername" => $this->FATHERNAME,
            "grade" => $this->GRADE,
            "mobilenumber" => $this->MOBILENUMBER,
            "birthday" => $this->BIRTHDAY];
    }

//    public function __construct($id = null,
//                                $name = null,
//                                $surname = null,
//                                $fathername = null,
//                                $grade = null,
//                                $mobilenumber = null,
//                                $birthday = null)
//    {
//        $this->id = $id;
//        $this->name = $name;
//        $this->surname = $surname;
//        $this->fathername = $fathername;
//        $this->grade = $grade;
//        $this->mobilenumber = $mobilenumber;
//        $this->birthday = $birthday;
//    }

//    public function __toString()
//    {
//        return "Student\n
//				ID: {$this->id}\n
//				NAME: {$this->name}\n
//				SURNAME: {$this->surname}\n
//				FATHERNAME: {$this->fathername}\n
//				GRADE: {$this->grade}\n
//				MOBILENUMBER: {$this->mobilenumber}\n
//				BIRTHDAY: {$this->birthday}\n";
//    }
//
//    public static function loadFromQuery($row)
//    {
//        $ret = new self($row["ID"],
//            $row["NAME"],
//            $row["SURNAME"],
//            $row["FATHERNAME"],
//            $row["GRADE"],
//            $row["MOBILENUMBER"],
//            $row["BIRTHDAY"]);
//        return $ret;
//    }
}


class StudentModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllStudents()
    {
        $stmt = $this->db->prepare('SELECT * FROM Students');

        if (!$stmt->execute()) {
            return null;
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Student');
            if ($result === false) {
                return null;
            }
        }

        return $result;
    }

    public function getStudentById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Students WHERE ID = :id LIMIT 1');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Student');
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

    public function getStudentByMobilenumber($mobilenumber)
    {
        $stmt = $this->db->prepare('SELECT * FROM Students WHERE MOBILENUMBER = :mobilenumber LIMIT 1');
        $stmt->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Student');
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

    public function searchForStudent($name = null,
                                     $surname = null,
                                     $fathername = null,
                                     $grade = null,
                                     $mobilenumber = null,
                                     $birthday = null)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM Students
                        WHERE NAME like :name 
                        AND SURNAME like :surname 
                        AND FATHERNAME like :fathername
                        AND GRADE like :grade
                        AND MOBILENUMBER like :mobilenumber
                        AND BIRTHDAY like :birthday");

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':fathername', $fathername, PDO::PARAM_STR);
        $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
        $stmt->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            return null;
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Student');
            if ($result === false) {
                return null;
            }
        }

        return $result;
    }

    public function updateStudentById($id, $name, $surname, $fathername, $grade, $mobilenumber, $birthday)
    {
        $stmt = $this->db->prepare(
            'UPDATE Students SET NAME=:name, 
                        SURNAME=:surname, 
                        FATHERNAME=:fathername,
                        GRADE=:grade,
                        MOBILENUMBER=:mobilenumber,
                        BIRTHDAY=:birthday
                        WHERE ID=:id');

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':fathername', $fathername, PDO::PARAM_STR);
        $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
        $stmt->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function createStudent($name, $surname, $fathername, $grade, $mobilenumber, $birthday)
    {
        $stmt = $this->db->prepare(
            'INSERT INTO Students 
                        VALUES (:id, :name, :surname, :fathername, :grade, :mobilenumber, :birthday)');
        $stmt->bindParam(':id', $this->getNewStudentID(), PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':surname', $surname, PDO::PARAM_STR);
        $stmt->bindParam(':fathername', $fathername, PDO::PARAM_STR);
        $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
        $stmt->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
        $stmt->bindParam(':birthday', $birthday, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function deleteStudent($id)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM Students WHERE ID=:id');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }

    private function getNewStudentID()
    {
        while (true) {
            $id = generateRandomString();

            $stmt = $this->db->prepare('SELECT * FROM Student WHERE ID = :id LIMIT 1');
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