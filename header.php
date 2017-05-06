<header>
<link rel="stylesheet" type="text/css" href="style_index.css">
<h1><center>My Library</center></h1>
<hr/>
<center>
<div id="navbar">
<?php if(session_status() == PHP_SESSION_NONE) session_start();?>
	
		<a id="a" href="index.php">Home</a>&nbsp;&nbsp;&nbsp;
		<a href="table.php">View Books</a>&nbsp;&nbsp;&nbsp;
		<?php 
		 if(isset($_SESSION['id'])){?>
		<a href="logout.php">Logout</a>
		<?php } ?>

</div>
</center>
</header>

