<?php 

// only for the assignment User class objects 

class assignment_user 
{
	private $user_id ; 
	private $teacher_id; 
	private $file ;
	public $connect;


public function __construct()
	{
		require_once('Database_connection.php');

		$database_object = new Database_connection;

		$this->connect = $database_object->connect();
	}

	function setUserId($user_id)
	{
		$this->user_id = $user_id;
	}

	function getUserId()
	{
		return $this->user_id;
	}

	function setTeacherId($teacher_id)
	{
		$this->teacher_id = $teacher_id;
	}

	function getTeacherId()
	{
		return $this->teacher_id;
	}

	function setFile($file)
	{
		$this->file = $file;
	}

	function getFile()
	{
		return $this->file;
	}
	function save_file()
	{
		$query = "INSERT INTO assignment_db (user_id , teacher_id , file ) VALUES(:user_id , :teacher_id , :file)";
		
		$statement = $this->connect->prepare($query);

		$statement->bindParam(':user_id', $this->user_id);

		$statement->bindParam(':teacher_id', $this->teacher_id);

		$statement->bindParam(':file', $this->file);


		if($statement->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}	

	// function getAssignment()
	// {
	// 	$query = "SELECT "
	// }
}

?>