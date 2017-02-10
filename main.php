<?php 
	require 'classes/mongo_db.php';
	require 'classes/routes.php';
	$mongo = new CreateDatabase;
	$route = new Route;

	if (isset($_POST['submit'])) {
		$data = $_POST;
		if (!empty($data['name']) && !empty($data['location']) && !empty($data['price'])) {
			$mongo->addDocument($data['name'], $data['location'], $data['price']);
			header('Location: main.php'.$route->handleSubmit($_POST));
		}
	}

	if (!empty($_GET)) {
		echo '<b>Doc Added</b><br>';
		echo 'Hotel: ' . $data['name'] . '<br>' . 'Location: ' . $data['location'] . '<br>' . 'Price: ' . $data['price'];
	}
?>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<fieldset>
		<legend>Add Document</legend>
		<input type="text" name="name" placeholder="name">
		<input type="text" name="location" placeholder="location">
		<input type="text" name="price" placeholder="price">
		<input type="submit" name="submit" value="Add">
	</fieldset>
</form>