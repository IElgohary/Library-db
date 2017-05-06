<!DOCTYPE html>
<html>
<head>
	<title>My Library</title>
</head>
<link rel="stylesheet" type="text/css" href="style_index.css">
<body >

	<?php session_start(); 
	include"header.php" ?>

<?php if(!isset($_SESSION['id'])){?>
<center>
<div id="login_form">
<form method = "post" action="">
	<div id="l">
	<h3>Login</h3>
	<label for ="email">Email: </label>
	<input type = "text" name = "email1" id="email">
	<br>
	<label for="password">Password: </label>
	<input type="password" name="password1" id="password">
	<br>
	<input type="submit" name="login" value="Login">
	</div>
</form>
<br>
<form method="post" action="">
	<h3>New User</h3>
	<label for="name">Name: </label>
	<input type ="text" name="name" id="name">
	<br>
	<label for = "email" >Email: </label>
	<input type ="text" name="email" id="email">
	<br>
	<label for="password">Password: </label>
	<input type ="password" name="password" id="password">
	<br>
	<label for="password2">Confirm Password: </label>
	<input type ="password" name="password2" id="password2">
	<br>
	<input type="submit" name="register" value="Register">
	<br>

</form>
</div>
</center>
<?php }else{
	?>
<center>
<div id="login_form">
	<form method="post" action="">
		<h3>Add A Book:</h3>
		<label for ="title">Book Title:</label>
		<input type="text" name ="title" id = "title">
		<br>
		<label for ="author">Author:</label>
		<input type="text" name="author" id="author">
		<br>
		<label for ="copies">Number of Copies:</label>
		<input type="text" name="copies" id="copies">
		<br>
		<input type="submit" name="addbook" value="Add Book">
		<br>
	</form>
	<form method="post" action="">
		<h3>Borrow A Book:</h3>
		<label for="bookid">Book ID:</label>
		<input type="text" name="bookid" id="bookid">
		<br>
		<input type="submit" name="borrowbook" value="Borrow Book">
		<br>
		
	</form>
	</div>
</center>
<?php } ?>

</body>
</html>

<?php 
	include ('database.php');
	$database = new database();
	
	if(isset($_POST['login']))
	{
		$e = $_POST['email1'];
		$p = $_POST['password1'];
		if($database->login($e,$p))
		{
			header("Refresh:0");			
		}
		else
		{
			echo 'Invalid email or password';
		}
		
	}
	else if (isset($_POST['register'])) 
	{
		$n= $_POST['name'];
		$e = $_POST['email'];
		$p = $_POST['password'];
		$p2 = $_POST['password2'];
		if($database->register($n,$e,$p,$p2))
		{
			echo 'done';
		}
		else
		{
			echo 'error';
		}
	}
	else if(isset($_POST['addbook']))
	{
		$t = $_POST['title'];
		$a = $_POST['author'];
		$c = $_POST['copies'];
		$database->addBook($t,$a,$c);
	}
	else if(isset($_POST['borrowbook']))
	{
		$b = $_POST['bookid'];
		$database->borrowBook($b);
	}
	else if(isset($_POST['logout']))
	{
		session_destroy();
		header("Refresh:0");
	}else

?>