<?php
	define('DB_NAME', 'spider');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');


	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno()) {
	 	die("Failed to connect to MySQL: " . mysqli_connect_error());
	}

	if (isset($_GET['id'])) {
		$sql = "SELECT * FROM images where id = '".$_GET['id']."'";
		$query = mysqli_query($link, $sql);
		$result = mysqli_fetch_array($query);
		if (!$result) {
			echo "Not found";
		}
		else{
			echo 'data:image/jpeg;base64,'.base64_encode( $result['image'] );
		}
	}
	else{
		echo "Invalid query";
	}
	
?>