<?php 
	require 'classes/mongo_db.php';
	require 'classes/DATA_ENTRY/add_hotel.php';
	require 'classes/DATA_ENTRY/add_order.php';
	require 'classes/routes.php';
	$mongo = new MongoDB_Main;
	$route = new Route;

	if (isset($_POST['submit']) || isset($_POST['show'])) {
		$data = $_POST;
		if (!empty($data['name']) && !empty($data['location']) && !empty($data['price'])) {
			new Add_Hotel($data);
			header('Location: main.php'.$route->handleSubmit($_POST));
		} else if (!empty($data['first_name']) && !empty($data['last_name'])) {
			new Add_Order($data);
			header('Location: main.php'.$route->handleSubmit($_POST));
		} else if (!empty($data['order_id'])) {
			header('Location: main.php'.$route->handleSubmit($_POST));
		}
	}

	if (!empty($_GET)) {
		echo '<b>Doc Added</b><br>';
		$data = $_GET;
		foreach ($data as $key => $value) {
			if ($key == 'order_id') {
				$orderDoc = $mongo->addCollection('orders');
				$orderDoc = $mongo->findDocs($orderDoc, array('_id'=>$value));
				$orderDoc = $mongo->displayDoc($orderDoc);
				foreach ($orderDoc as $order_doc) {

				}
 				continue;
			}
			echo $key .': '. $value.'<br>';
		}
		echo '<br>';
	}

	$hotels = $mongo->addCollection('hotels');
	$hotels = $mongo->findDocs($hotels);
	$hotels = $mongo->displayDoc($hotels);
	foreach ($hotels as $hotel) {
		(isset($hotel_dropdown)) ? $hotel_dropdown .= '<option value="'.$hotel['_id'].'">'.$hotel['name'].'</option>' : $hotel_dropdown = '<option value="'.$hotel['_id'].'">'.$hotel['name'].'</option>';
	}

	$orders = $mongo->addCollection('orders');
	$orders = $mongo->findDocs($orders);
	$orders = $mongo->displayDoc($orders);
	foreach ($orders as $order) {
		(isset($order_dropdown)) ? $order_dropdown .= '<option value="'.$order['_id'].'">'.$order['_id'].'</option>' : $order_dropdown = '<option value="'.$order['_id'].'">'.$order['_id'].'</option>';
	}

?>
<link rel="stylesheet" href="styles/main.css"/>
<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<fieldset>
		<legend>Add Hotel Document</legend>
		<input type="text" name="name" placeholder="name">
		<input type="text" name="location" placeholder="location">
		<input type="text" name="price" placeholder="price">
		<input type="submit" name="submit" value="Add">
	</fieldset>
</form>


<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<fieldset>
		<legend>Add Order Document</legend>
		<input type="text" name="first_name" placeholder="First Name">
		<input type="text" name="last_name" placeholder="Last Name">
		<select name="hotel">
			<?= $hotel_dropdown ?>
		</select>
		<br><br><label>Add Legs</label><br>
		<select name="leg_1[pickup]">
			<option value="Orlando Airport">Orlando Airport</option>
			<option value="Port Canaveral">Port Canaveral</option>
		</select> 
		<select name="leg_1[dropoff]">
			<option value="Port Canaveral">Port Canaveral</option>
			<option value="Orlando Airport">Orlando Airport</option>
		</select> 
		<select name="leg_2[pickup]">
			<option value="Port Canaveral">Port Canaveral</option>
			<option value="Orlando Airport">Orlando Airport</option>
		</select> 
		<select name="leg_2[dropoff]">
			<option value="Orlando Airport">Orlando Airport</option>
			<option value="Port Canaveral">Port Canaveral</option>
		</select> 
		<input type="submit" name="submit" value="Add">
	</fieldset>
</form>

<form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
	<fieldset>
		<legend>Show Order Document</legend>
		<select name="order_id">
			<?= $order_dropdown ?>
		</select>
		<input type="submit" name="show" value="Show">
	</fieldset>
</form>
