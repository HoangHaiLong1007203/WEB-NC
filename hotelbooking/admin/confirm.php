<?php
		include("inc/db_config.php");
		
		$t_id = $_GET['id'];
		
		$con->query("UPDATE orders SET status = 'Confirmed' WHERE tracking_no = '$t_id'") or die(mysqli_error());
        header("location: new_bookings.php");	
		
		?>