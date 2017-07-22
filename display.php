<?php
if ($_FILES['fileToUpload']['name'] != "") {


	define('DB_NAME', 'spider');
	define('DB_USER', 'root');
	define('DB_PASSWORD', '');
	define('DB_HOST', 'localhost');


	$link = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	if (mysqli_connect_errno()) {
	 	die("Failed to connect to MySQL: " . mysqli_connect_error());
	}

	//echo $_FILES['fileToUpload']['name'];
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	       	$message = "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	       	$message = "File is not an image.";
	        $uploadOk = 0;
	    }
	}
	// Check if file already exists

	if (file_exists($target_file)) {
	   	$message = "Sorry, file already exists.";
	    $uploadOk = 0;
	}
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 1000000) {
	   	$message = "Sorry, your file is too large.";
	    $uploadOk = 0;
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	   	$message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	// if everything is ok, try to upload file
	}
	else {
	    		move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

	    		
	    		$imgData = file_get_contents($target_file);
				$size = getimagesize($target_file);
				$sql = "INSERT INTO images (type, image, size, name) VALUES ('".mysqli_real_escape_string($link, $size['mime'])."', '".mysqli_real_escape_string($link, $imgData)."', '".$size[3]."', '".mysqli_real_escape_string($link, $_FILES['fileToUpload']['name'])."')";
				$query = mysqli_query($link,$sql);
				if (!$query) {
					die("<br> Error : " . mysqli_error($link)); 
				}


	       	$message = "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
	}
	echo $message;

}
else{
	header("Location: imageupload.html");
}
?>