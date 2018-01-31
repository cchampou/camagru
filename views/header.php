<html>
	<head>
		<title>Camagru</title>
		<link rel="stylesheet" type="text/css" href="../assets/styles/main.css" />
		<link rel="stylesheet" type="text/css" href="../assets/styles/desktop.css" media="(min-width: 1200px)" />
		<link rel="stylesheet" type="text/css" href="../assets/styles/tablet.css" media="(min-width: 600px) and (max-width: 1200px)"/>
		<link rel="stylesheet" type="text/css" href="../assets/styles/mobile.css" media="(max-width: 600px)"/>
		<link rel="stylesheet" type="text/css" href="../assets/styles/shot.css" />
		<link rel="stylesheet" type="text/css" href="../assets/styles/form.css" />
		<link rel="stylesheet" type+"text/css" href="../assets/styles/fa/fontawesome-all.css" />
		<meta name="viewport" content="initial-scale=1, maximum-scale=1">
	</head>
	<body>
		<header>
			<a href="/"><h1>Camagru</h1></a>
			<nav class="mobile-menu">
				<a href="/" onclick="return unwrap();"><i class="fas fa-bars"></i>&nbsp;</a>
				<?php
				if ($_SESSION) {
					?>
					<a href="/user/logout"><i class="fas fa-sign-out-alt"></i>&nbsp;</a>
					<?php
				}
				?>
				<div id="dropdown-mobile" style="display: none;" data-wrapped="true">
					<?php
					if ($_SESSION && !array_key_exists('id', $_SESSION) || !$_SESSION['id']) {
						?>
						<a href="/user/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
						<a href="/user/signup" class="nav-highlight"><i class="fas fa-user-plus"></i> Inscription</a>
						<?php
					} else {
						?>
						<a href="/user/shot"><i class="fas fa-camera"></i> Take a picture !</a>
						<a href="/user/account"><i class="fas fa-user"></i> Mon compte</a>
						<?php
					}
					?>
				</div>
			</nav>
			<nav class="tablet-menu">
				<?php
				if ($_SESSION && !array_key_exists('id', $_SESSION) || !$_SESSION['id']) {
					?>
					<a href="/user/login"><i class="fas fa-sign-in-alt"></i>&nbsp;</a>
					<a href="/user/signup" class="nav-highlight"><i class="fas fa-user-plus"></i>&nbsp;</a>
					<?php
				} else {
					?>
					<a href="/user/shot"><i class="fas fa-camera"></i>&nbsp;</a>
					<a href="/user/account"><i class="fas fa-user"></i>&nbsp;</a>
					<a href="/user/logout"><i class="fas fa-sign-out-alt"></i>&nbsp;</a>
					<?php
				}
				?>
			</nav>
			<nav class="desktop-menu">
				<?php
				if ($_SESSION && !array_key_exists('id', $_SESSION) || !$_SESSION['id']) {
					?>
					<a href="/user/login"><i class="fas fa-sign-in-alt"></i> Connexion</a>
					<a href="/user/signup" class="nav-highlight"><i class="fas fa-user-plus"></i> Inscription</a>
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
