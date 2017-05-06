<!DOCTYPE html>
<html>
<head>
	<title>Books List</title>
</head>
<link rel="stylesheet" type="text/css" href="style_index.css">
<body>

<?php include('header.php'); 
	require('database.php');?>
<div id="tables">
<?php $database = new database(); ?>
<h3>Available Books:</h3>
<table>
<tr>
	<th>Title</th>
	<th>Author</th>
	<th>Available Copies</th>
	<th>ID</th>
</tr>
	<?php 
		$books = $database->getAvailable();
		while($row = $books->fetch_assoc())
		{
			echo"<tr><td>",$row['Title'],"</td>";
			echo"<td>",$row['Author'],"</td>";
			echo"<td>",$row['Available_Copies'],"</td>";
			echo"<td>",$row['ID'],"</td>";
			echo"</tr>";
		}

	 ?>
</table>
<br>
<h3>Borrowed Books:</h3>
<table >
<tr>
	<th>Title</th>
	<th>Author</th>
	<th>Borrowed Copies</th>
	<th>ID</th>
</tr>	
<?php 
		$books = $database->getBorrowed();
		while($row = $books->fetch_assoc())
		{
			echo"<tr><td>",$row['Title'],"</td>";
			echo"<td>",$row['Author'],"</td>";
			echo"<td>",$row['Borrowed_Copies'],"</td>";
			echo"<td>",$row['ID'],"</td>";
			echo"</tr>";
		}

	 ?>
</table>

</div>
</body>


</html>