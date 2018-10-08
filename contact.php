<?php
	if($_POST){
		// var_dump($_POST);
		/*
		$name = $_POST["name"];
		$email = $_POST["email"];
		$message = $_POST["message"];
		$subscribe = $_POST["subscribe"];
		*/

		extract($_POST);

		$errors = array();

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

		if(empty($errors)){
			// var_dump("Valid");
		}
	}



	$page = "contact";

	require "includes/head.php";
?>

			<main role="main" class="inner cover">
				<h1 class="cover-heading">Contact</h1>
				<p class="lead">Send us an Email</p>

				<?php if($_POST && !empty($errors)): ?>
				<div class="alert alert-danger" role="alert">
					<ul class="mb-0">
						<?php foreach($errors as $error): ?>
						<li><?= $error ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif; ?>

				<form method="POST" action="contact.php" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Name" value="<?php if(isset($_POST["name"])){ echo $_POST["name"]; } ?>">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" placeholder="Enter Email" value="<?php if(isset($_POST["email"])){ echo $_POST["email"]; } ?>">
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea name="message" rows="3" class="form-control"><?php if(isset($_POST["message"])){ echo $_POST["message"]; } ?></textarea>
					</div>
					<div class="form-group">
						<input type="checkbox" name="subscribe" class="form-check-input" id="subscribe" <?php if(isset($_POST["subscribe"])){ echo "checked"; } ?>>
						<label class="form-check-label" for="subscribe">Subscribe to Newsletter</label>
					</div>
					<button type="submit" class="btn btn-outline-light btn-block">Submit</button>
				</form>
			</main>

<?php require "includes/footer.php"; ?>
