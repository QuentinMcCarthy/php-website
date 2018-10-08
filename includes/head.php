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
						<a class="nav-link <?php if($page === 'home'){ echo 'active'; } ?>" href="index.php">Home</a>
						<?php
							// The path to search
							$path = ".";

							// Initialise array for files in the path as well as a counter
							$files = array();

							// Open the directory if it is valid
							if(is_dir($path)){
								if($handle = opendir($path)){
									// Read every file in the opened directory
									while(($file = readdir($handle)) !== false){
										// Don't push hidden files or the index
										if($file[0] != "." && $file != "index.php"){
											// Ignore folders
											if(is_dir($path."/".$file) === false){
												// Add the file to the array
												array_push($files, $file);
											}
										}
									}

									// Close the directory when done
									closedir($handle);
								}
							}

							// Sort and reset the array
							sort($files); reset($files);

							// List the files for navigation
							foreach ($files as $file):
								// Get the file name for each file
								$filename = pathinfo($file, PATHINFO_FILENAME);
						?>
						<a class="nav-link <?php if($page === $filename){ echo "active"; } ?>" href="<?= $file; ?>"><?= ucfirst($filename) ?></a>
						<?php endforeach; ?>
					</nav>
				</div>
			</header>
