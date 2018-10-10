<?php
	function getRealIpAddr(){
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){   //check ip from share internet
			$ip=$_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){   //to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip=$_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}

	// phpinfo();
	// die();

	$applicationcookie_name = "applicationSent";
	$applicationcookie_value = "true";
	$applicationcookie_expiry = time() + (604800); // 1 week from now
	$applicationcookie_path = "/";

	$errors = array();

	if(!isset($_COOKIE[$applicationcookie_name])){
		if(!isset($_POST)){
			if(isset($_FILES["image"])){
				$imageSize = $_FILES["image"]["size"];
				$imageTmp = $_FILES["image"]["tmp_name"];
				$imageType = $_FILES["image"]["type"];

				// var_dump($fileSize);
				// var_dump($fileTmp);
				// var_dump($fileType);

				// If the file is over 5mb
				if($imageSize > 5000000){
					array_push($errors, "The image is too large, must be under 5MB");
				}

				$validImage = array(
					"jpeg",
					"jpg",
					"png"
				);

				$imageNameArray = explode(".", $_FILES["image"]["name"]);
				$imageExt = strtolower(end($imageNameArray));

				if(!in_array($imageExt, $validImage)){
					array_push($errors, "Image type not allowed, can only be a jpg or png");
				}
			} else {
				array_push($errors, "Please provide an image");
			}

			extract($_POST);

			if(!$name){
				array_push($errors, "Name is required, please enter a value");
			} elseif(strlen($name) < 2){
				array_push($errors, "Please enter at least 2 characters for your name");
			} elseif(strlen($name) > 100){
				array_push($errors, "Your name can't be more than 100 characters");
			}

			if(!$email){
				array_push($errors, "Email address is required, please enter a value");
			} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				array_push($errors, "Please enter a valid email address");
			}

			if(!$message){
				array_push($errors, "Please enter a message");
			} elseif(strlen($message) < 10){
				array_push($errors, "Message is too short, must be at least 10 characters");
			} elseif(strlen($message) > 1000){
				array_push($errors, "Message is too long, please restrict it to 1000 characters");
			}

			if(isset($_FILES["cv"])){
				$cvSize = $_FILES["cv"]["size"];
				$cvTmp = $_FILES["cv"]["tmp_name"];
				$cvType = $_FILES["cv"]["type"];

				// If the file is over 5mb
				if($cvSize > 5000000){
					array_push($errors, "The CV is too large, must be under 5MB");
				}

				$validCV = array(
					"pdf"
				);

				$cvNameArray = explode(".", $_FILES["cv"]["name"]);
				$cvExt = strtolower(end($cvNameArray));

				if(!in_array($cvExt, $validCV)){
					array_push($errors, "CV must be in PDF format");
				}
			} else {
				array_push($errors, "Please provide a CV");
			}

			if(empty($errors)){
				$destination = "jobApps";

				$userID = uniqid();

				if(!is_dir($destination)){
					mkdir($destination."/".$userID."/", 0777, true);
				}

				$newImageName = "userImage.".$imageExt;

				move_uploaded_file($imageTmp, $destination."/".$newImageName);

				$newCVName = "userCV.".$cvExt;

				move_uploaded_file($cvTmp, $destination."/".$newCVName);

				$log = getRealIpAddr().$userID.",".$name.",".$email.",".$message;

				setcookie($applicationcookie_name, $applicationcookie_value, $applicationcookie_expiry, $applicationcookie_path);
			}
		}
	} else {
		array_push($errors, "You have submitted within the last week and cannot submit again");
	}

	$page = "jobApplication";
	require "includes/head.php";
?>

<main role="main" class="inner cover">
	<h1 class="cover-heading">Job Application</h1>
	<p class="lead">Apply for a Job</p>

	<?php if(!empty($errors)): ?>
		<div class="alert alert-danger" role="alert">
			<ul class="mb-0">
				<?php foreach($errors as $error): ?>
					<li><?= $error; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form  action="jobApplication.php" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="image">Image of yourself</label>
			<input type="file" name="image" class="form-control-file">
		</div>
		<div class="form-group">
			<label for="name">Name</label>
			<input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php if(isset($_POST["name"])){ echo $_POST["name"]; } ?>">
		</div>
		<div class="form-group">
			<label for="email">Email</label>
			<input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php if(isset($_POST["email"])){ echo $_POST["email"]; } ?>">
		</div>
		<div class="form-group">
			<label for="message">Why you should have the job</label>
			<textarea name="message" rows="3" class="form-control"><?php if(isset($_POST["message"])){ echo $_POST["message"]; } ?></textarea>
		</div>
		<div class="form-group">
			<label for="cv">Upload your CV</label>
			<input type="file" name="cv" class="form-control-file">
		</div>
        <button type="submit" class="btn btn-outline-light btn-block">Submit</button>
	</form>
</main>

<?php require "includes/footer.php" ?>
