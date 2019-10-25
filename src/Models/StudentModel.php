<?php

class Student
{
	public $id;
	public $name;
	public $surname;
	public $fathername;
	public $grade;
	public $mobilenumber;
	public $birthday;

	public function __construct($id, $name, $surname, $fathername, $grade, $mobilenumber, $birthday)
	{
		$this->id = $id;
		$this->name = $name;
		$this->surname = $surname;
		$this->fathername = $fathername;
		$this->grade = $grade;
		$this->mobilenumber = $mobilenumber;
		$this->birthday = $birthday;
	}

	public function __toString()
	{
		return "Student\n
				ID: {$this->id}\n
				NAME: {$this->name}\n
				SURNAME: {$this->surname}\n
				FATHERNAME: {$this->fathername}\n
				GRADE: {$this->grade}\n
				MOBILENUMBER: {$this->mobilenumber}\n
				BIRTHDAY: {$this->birthday}\n";
	}

	public static function loadFromQuery($row)
	{
		$ret = new self($row["ID"],
			$row["NAME"],
			$row["SURNAME"],
			$row["FATHERNAME"],
			$row["GRADE"],
			$row["MOBILENUMBER"]
			$row["BIRTHDAY"]
		);
		return $ret;
	}
}


class StudentModel
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}

?>