<?php
include 'Utils/Random.php';

class Teacher
{
	public $id;
	public $name;
	public $surname;
	public $username;
	public $password;
	public $email;

	public function __construct($id, $name, $surname, $username, $password, $email)
	{
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->username = $username;
		$this->password = $password;
		$this->email = $email;
	}

	public function __toString()
	{
		return "Teacher\n
				ID: {$this->id}\n
				NAME: {$this->name}\n
				SURNAME: {$this->surname}\n
				USERNAME: {$this->username}\n
				PASSWORD: {$this->password}\n
				EMAIL: {$this->email}\n";
	}

	public static function loadFromQuery($row)
	{
		$ret = new self($row["ID"],
			$row["NAME"],
			$row["SURNAME"],
			$row["USERNAME"],
			$row["PASSWORD"],
			$row["EMAIL"]
		);
		return $ret;
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
    	if (!$stmt->bindParam(':username', $username, PDO::PARAM_STR))
    	{
    		return null;
    	}

        if (!$stmt->execute())
        {
        	return null;
        }
        else
        {
        	$result = $stmt->fetch(PDO::FETCH_ASSOC);
        	if ($result !== false) {
        		return Teacher::loadFromQuery($result);
        	}	
        }
    }

    public function getTeacherByEmail($email)
    {
    	$stmt = $this->db->prepare('SELECT * FROM Teachers WHERE EMAIL = :email LIMIT 1');
    	if (!$stmt->bindParam(':email', $email, PDO::PARAM_STR))
    	{
    		return null;
    	}

        if (!$stmt->execute())
        {
        	return null;
        }
        else
        {
        	$result = $stmt->fetch(PDO::FETCH_ASSOC);
        	if ($result !== false) {
        		return Teacher::loadFromQuery($result);
        	}	
        }
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
        if (!$stmt->execute())
        {
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