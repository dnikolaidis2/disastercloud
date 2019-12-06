<?php
include 'Utils/Random.php';

/**
 * Class Student.
 * Wrapper for student data.
 */
class Student
{
    public $ID;
    public $NAME;
    public $SURNAME;
    public $FATHERNAME;
    public $GRADE;
    public $MOBILENUMBER;
    public $BIRTHDAY;

    /**
     * Pack student data to array for easier displaying to forms.
     * @return array of student data.
     */
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
}


/**
 * Class StudentModel
 * Wrapper for all interactions with database table Student.
 */
class StudentModel
{
    protected $db;

    /**
     * StudentModel constructor.
     * @param PDO $db PDO database connection.
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Get array of students in Student table.
     * @return array|null array of student classes if successful, null if not.
     */
    public function getAllStudents()
    {
        $stmt = $this->db->prepare('SELECT * FROM Students');

        if (!$stmt->execute()) {
            return null;
        } else {
//          Fetch data and pack into Student class
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Student');
            if ($result === false) {
                return null;
            }
        }

        return $result;
    }

    /**
     * Get a student using id.
     * @param string $id of student to fetch.
     * @return Student|null Student data represented by Student class if successful or null if not.
     */
    public function getStudentById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM Students WHERE ID = :id LIMIT 1');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
//      Fetch mode for automatic packing into student class
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

    /**
     * Get a student using phone number.
     * @param string $mobilenumber of student to fetch.
     * @return Student|null Student data if successful or null if not.
     */
    public function getStudentByMobilenumber($mobilenumber)
    {
        $stmt = $this->db->prepare('SELECT * FROM Students WHERE MOBILENUMBER = :mobilenumber LIMIT 1');
        $stmt->bindParam(':mobilenumber', $mobilenumber, PDO::PARAM_STR);
//      Fetch mode for automatic packing into student class
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

    /**
     * Search for a student by filed(s). Prepend and append '%' in fields for better search.
     * @param string $name of student. Will be ignored if null.
     * @param string $surname of student. Will be ignored if null.
     * @param string $fathername of student. Will be ignored if null.
     * @param string $grade of student. Will be ignored if null.
     * @param string $mobilenumber of student. Will be ignored if null.
     * @param string $birthday of student. Will be ignored if null.
     * @return array|null array of student's returned from search query packed in Student class.
     * null if an error occurred.
     */
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
//          Fetch data and pack into Student class
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, 'Student');
            if ($result === false) {
                return null;
            }
        }

        return $result;
    }

    /**
     * Update student with new data.
     * @param string $id of student to update.
     * @param string $name to update student with.
     * @param string $surname to update student with.
     * @param string $fathername to update student with.
     * @param string $grade to update student with.
     * @param string $mobilenumber to update student with.
     * @param string $birthday to update student with.
     * @return bool true if successful false if an error occurred.
     */
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

    /**
     * Create a new student in student table.
     * @param string $name of new student.
     * @param string $surname of new student.
     * @param string $fathername of new student.
     * @param string $grade of new student.
     * @param string $mobilenumber of new student.
     * @param string $birthday of new student.
     * @return bool true if successful false if an error occurred.
     */
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

    /**
     * Delete student from table.
     * @param string $id of student to delete.
     * @return bool true if successful false if an error occurred.
     */
    public function deleteStudent($id)
    {
        $stmt = $this->db->prepare(
            'DELETE FROM Students WHERE ID=:id');
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Generate a new unique ID for a new student.
     * @return string new unique ID.
     */
    private function getNewStudentID()
    {
//      Generate random ID and check if it exists already.
//      If it does try again.
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