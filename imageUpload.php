<?php
	// Include composer autoload
	require "vendor/autoload.php";

	// Import the Intervention Image Manager Class
	use Intervention\Image\ImageManager;

	// phpinfo();
	// die();

	$uploadcookie_name = "imageUploaded";
	$uploadcookie_value = "true";
	$uploadcookie_expiry = time() + (60); // 1 minute from now
	$uploadcookie_path = "/";

	$errors = array();

	if(!isset($_COOKIE[$uploadcookie_name])){
		if(isset($_FILES["image"])){
			$fileSize = $_FILES["image"]["size"];
			$fileTmp = $_FILES["image"]["tmp_name"];
			$fileType = $_FILES["image"]["type"];

			// var_dump($fileSize);
			// var_dump($fileTmp);
			// var_dump($fileType);

			// If the file is over 5mb
			if($fileSize > 5000000){
				array_push($errors, "The file is too large, must be under 5MB");
			}

			$validExtensions = array(
				"jpeg",
				"jpg",
				"png"
			);
			$fileNameArray = explode(".", $_FILES["image"]["name"]);
			$fileExt = strtolower(end($fileNameArray));

			if(!in_array($fileExt, $validExtensions)){
				array_push($errors, "File type not allowed, can only be a jpg or png");
			}

			if(empty($errors)){
				$destination = "img/uploads";
				if(!is_dir($destination)){
					mkdir($destination."/", 0777, true);
				}

				$newFileName = uniqid().".".$fileExt;

				// move_uploaded_file($fileTmp, $destination."/".$newFileName);

				$manager = new ImageManager();

				$mainImage = $manager->make($fileTmp);
				$mainImage->save($destination."/".$newFileName);

				$thumbDestination = "img/uploads/thumbs";

				if(!is_dir($thumbDestination)){
					mkdir($thumbDestination."/", 0777, true);
				}

				$thumbnailImage = $manager->make($fileTmp);

				$thumbnailImage->resize(300, null, function($constraint){
					$constraint->aspectRatio();
					$constraint->upsize();
				});

				$thumbnailImage->save($thumbDestination."/".$newFileName, 100);

				setcookie($uploadcookie_name, $uploadcookie_value, $uploadcookie_expiry, $uploadcookie_path);
			}
		}
	} else {
		array_push($errors, "You must wait a minute between image uploads");
	}

	$page = "imageUpload";
	require "includes/head.php";
?>

<main role="main" class="inner cover">
	<h1 class="cover-heading">Image Upload Page</h1>
	<p class="lead">Upload an image to our server</p>

	<?php if(!empty($errors)): ?>
		<div class="alert alert-danger" role="alert">
			<ul class="mb-0">
				<?php foreach($errors as $error): ?>
					<li><?= $error; ?></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<form  action="imageUpload.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="image">Upload an Image</label>
            <input type="file" name="image" class="form-control-file">
        </div>
        <button type="submit" class="btn btn-outline-light btn-block">Submit</button>
	</form>
</main>

<?php require "includes/footer.php" ?>
