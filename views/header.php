<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="../assets/styles/main.css" />
		<link rel="stylesheet" type="text/css" href="../assets/styles/shot.css" />
		<link rel="stylesheet" type="text/css" href="../assets/styles/form.css" />
		<link rel="stylesheet" type+"text/css" href="../assets/styles/fa/fontawesome-all.css" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	</head>
	<body>
		<header>
			<h1>Camagru</h1>
			<nav>
				<a href="/"><i class="fas fa-home"></i> Accueil</a>
				<?php
				if (!$_SESSION) {
					?>
					<a href="/user/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
					<a href="/user/signup" class="nav-highlight"><i class="fas fa-user"></i> Inscription</a>
					<?php
				} else {
					?>
					<a href="/user/shot"><i class="fas fa-camera"></i> Take a picture !</a>
					<a href="/user/account"><i class="fas fa-user"></i> Mon compte</a>
					<a href="/user/logout"><i class="fas fa-sign-out-alt"></i> Deconnexion</a>
					<?php
				}
				?>
			</nav>
		</header>
