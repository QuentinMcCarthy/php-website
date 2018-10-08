<?php
	$page = "contact";

	require "includes/head.php";
?>

			<main role="main" class="inner cover">
				<h1 class="cover-heading">Contact</h1>
				<p class="lead">Send us an Email</p>

				<form method="POST" action="contact.php" enctype="multipart/form-data">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" placeholder="Enter Name" value="">
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" placeholder="Enter Email" value="" required>
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea name="message" rows="3" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<input type="checkbox" name="subscribe" class="form-check-input" id="subscribe">
						<label class="form-check-label" for="subscribe">Subscribe to Newsletter</label>
					</div>
					<button type="submit" class="btn btn-outline-light btn-block">Submit</button>
				</form>
			</main>

<?php require "includes/footer.php"; ?>
