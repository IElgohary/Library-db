<?php
class database{

	private $name;
	private $email;
	private $password;
	private $password2;
	private $encPassword;
	private $errors;
	private $db;
	private $title;
	private $author;
	private $copies;
	private $bCopies;

	public function __construct()
	{
		$this->db = new mysqli('localhost','root','','library');
		$this->errors = array();
	}

	function register($n,$e,$p,$p2)
	{
		$this->name = $n;
		$this->email = $e;
		$this->password = $p;
		$this->password2=$p2;;
		$this->errors = array();
		$this->encPassword = md5($this->password);
		$this->validate_reg();

		if(count($this->errors) == 0)
		{
			$insertUser = $this->db->prepare ("INSERT INTO users (name, email , password) VALUES (?,?,?)" );
			$insertUser->bind_param('sss', $this->name , $this->email,$this->encPassword);
			$insertUser->execute();
			return true;
		}else
		{
			foreach ($this->errors as $error) {
				echo $error.'<br>';
			}
			return false;
		}
	}

	function validate_reg()
	{
		if(empty($this->name)||empty($this->password) || empty($this->password2)|| empty($this->email))
			$this->errors[] = "Fields cannot be empty.";
		if($this->emailExists())
			$this->errors[] = "Email already exists.";
		if($this->emailFormat())
			$this->errors[] = "Email Format Error.";
		if($this->password != $this->password2)
			$this->errors[] = "Passwords don't match";
	}

	function emailExists()
	{
		$check = $this->db->query("SELECT email FROM users WHERE email ='{$this->email}'");
		if($check->num_rows)
			return true;
		return false;
	}

	function emailFormat()
	{
		if(!filter_var($this->email, FILTER_VALIDATE_EMAIL))
			return true;
		return false;
	}

	function login($e,$p)
	{
		$this->email = $e;
		$this->encPassword =md5($p);
		$check = $this->db->query("SELECT * FROM users WHERE email ='{$this->email}' AND password = '{$this->encPassword}'");
		if($check->num_rows)
		{

			$check = $check->fetch_object();
			$_SESSION['id'] = $check->ID;
			$_SESSION['name'] = $check->Name;
			$_SESSION['email'] = $check->email;
			return true;
		}
		return false;
	}

	function addBook($t,$a,$c)
	{
		$this->title = $t;
		$this->author= $a;
		$this->copies = $c;
		$this->bCopies = 0;
		$this->state = 'Available';
		if(!$this->available())
		{	$insertBook = $this->db->prepare("INSERT INTO books(Title,Author,Available_Copies,Borrowed_Copies) VALUES (?,?,?,?) ");
			$insertBook->bind_param('ssii',$this->title,$this->author,$this->copies,$this->bCopies);
			$insertBook->execute();
			echo'A New Book was Added to the list';
		}
		else
		{
			$update = $this->db->query("UPDATE books SET Available_Copies = Available_Copies+$this->copies WHERE Title = '{$this->title}'");
			echo "Book already on the list, Number of available copies has been updated.";
		}
	}

	function borrowBook($b)
	{
		$check = $this->db->query("SELECT Available_Copies FROM books WHERE ID ={$b}");
		if($check->num_rows)
		{

	   	 while($row = $check->fetch_assoc()) {
	   	 	if($row['Available_Copies'] > 0)
	   	 	{
	   	 		$this->db->query("UPDATE books SET Available_Copies = Available_Copies - 1  , Borrowed_Copies=Borrowed_Copies+1 WHERE ID = '{$b}'");
	   	 		echo'Book has been borrowed successfully';
	   	 	}
	   	 	else
	   	 	{
	   	 		echo'Book is currently unavailable.';
	   	 	}
			}

		}
		else
		{
			echo'Invalid ID';
		}
	}


	function available()
	{
		$check = $this->db->query("SELECT ID FROM books WHERE Title = '{$this->title}'");
		if($check->num_rows)
			return true;
		return false;
	}

	function getAvailable()
	{
		$check = $this->db->query("SELECT * FROM books WHERE Available_Copies > 0");
		return $check;
	}

	function getBorrowed()
	{
		$check = $this->db->query("SELECT * FROM books WHERE Borrowed_Copies > 0");
		return $check;
	}
}

