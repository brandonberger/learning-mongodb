<?php 
	require 'classes/mongo_db.php';
	require 'classes/DATA_ENTRY/add_hotel.php';
	require 'classes/DATA_ENTRY/add_order.php';
	require 'classes/routes.php';
	$mongo = new MongoDB_Main;
	$route = new Route;
	$break = '<br>';
	$break_2 = '<br><br>';

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
		echo '<b><h2>RESULT:</h2></b><hr>';
		$data = $_GET;
		foreach ($data as $key => $value) {
			if ($key == 'order_id') {
				$orderDoc = $mongo->addCollection('orders');
				$orderDoc = $mongo->findDocs($orderDoc, array('_id' => new MongoId($value)));
				$orderDoc = $mongo->displayDoc($orderDoc);
				foreach ($orderDoc as $order_doc) {
					$legs = 0;
					foreach ($order_doc as $key => $value) {
						if (substr($key, 0, strpos($key, '_')) == 'leg') {

							if ($legs == 0)
								echo '<b><h3>Transportation:</h3></b>';
							else
								echo $break;

							$legs++;
							$leg_block  = '<b>'.ucfirst(str_replace('_', ' ', $key)).'</b>';
							$leg_block .= $break.'Pickup #' .$legs.': '.$order_doc[$key]['pickup'];
							$leg_block .= $break.'Dropoff #'.$legs.': '.$order_doc[$key]['dropoff'];
							$leg_block .= $break;
							echo $leg_block;
						} else {
							if ($key == 'hotel') {
								foreach($value as $hotel_ref => $hotel_ref_val) {
									$hotel_id = $value['$id'];
									$hotel_collection = $value['$ref'];
								}
								$hotelDoc = $mongo->addCollection($hotel_collection);

								$hotelDoc = $mongo->findDocs($hotelDoc, array('_id' => new MongoId($hotel_id)));
								$hotelDoc = $mongo->displayDoc($hotelDoc);
								foreach ($hotelDoc as $hotel_doc) {
									foreach ($hotel_doc as $hotel_key => $hotel_property) {
										if ($hotel_key == '_id') {
											echo '<b><h3>'.ucfirst($key).':</h3></b>';
											continue;
										}
										echo ucfirst(str_replace('_', ' ', $hotel_key)).': '. ucfirst($hotel_property).$break;
									}
								}
								continue;
							}

							if ($key == '_id') {
								echo '<b><h3>Customer:</h3></b>';
								continue;
							}
							echo ucfirst(str_replace('_', ' ', $key)).': '. ucfirst($value).$break;
						}
					}
				}
 				continue;
			}
			echo '<br>'.$key .': '. $value.'<br>';
		}
		echo '<br>';
	}

	$hotels     = $mongo->addCollection('hotels');
	$collection = $hotels->getName();
	$hotels     = $mongo->findDocs($hotels);
	$hotels     = $mongo->displayDoc($hotels);

	// Using DBRefs
	// Get hotel by DBRef
	// > var order = db.orders.findOne({'first_name':'Brandon'})
	// > var dbRef = order.hotel
	// > db[dbRef.$ref].findOne({'_id':ObjectId(dbRef.$id)})

	foreach ($hotels as $hotel) {
		$id = $hotel['_id'];
		(isset($hotel_dropdown)) ? $hotel_dropdown .= '<option value="'.$id.'">'.$hotel['name'].'</option>' : $hotel_dropdown = '<option value="'.$id.'">'.$hotel['name'].'</option>';
	}

	$orders = $mongo->addCollection('orders');
	$orders = $mongo->findDocs($orders);
	$orders = $mongo->displayDoc($orders);
	foreach ($orders as $order) {
		(isset($order_dropdown)) ? $order_dropdown .= '<option value="'.$order['_id'].'">'.$order['first_name'].' '.$order['last_name'].'</option>' : $order_dropdown = '<option value="'.$order['_id'].'">'.$order['first_name'].' '.$order['last_name'].'</option>';
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
		<!-- Hidden Input for the collection name when using DBRefs -->
		<input type="hidden" value="hotels" name="hotel[$ref]">
		<!-- && -->
		<select name="hotel[$id]">
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
