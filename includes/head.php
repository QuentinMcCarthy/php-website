<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>PHP website - <?= $page; ?></title>

		<!-- Bootstrap -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

		<!-- Custom styles for this template -->
		<link href="css/cover.css" rel="stylesheet">
	</head>
	<body class="text-center">
		<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
			<header class="masthead mb-auto">
				<div class="inner">
					<h3 class="masthead-brand">Cover</h3>

					<nav class="nav nav-masthead justify-content-center">
						<a class="nav-link <?php if($page === "home"){ echo "active"; } ?>" href="index.php">Home</a>
						<a class="nav-link <?php if($page === "features"){ echo "active"; } ?>" href="features.php">Features</a>
						<a class="nav-link <?php if($page === "contact"){ echo "active"; } ?>" href="contact.php">Contact</a>
					</nav>
				</div>
			</header>
