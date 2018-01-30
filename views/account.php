<div class="wrap-center">
	<h2>Mon compte</h2>
	<h3>Mes informations de connexion</h3>
	<p>
		<strong>Pseudo :</strong> <?= $user['pseudo']; ?><br />
		<strong>Email :</strong> <?= htmlspecialchars($user['email']); ?>
	</p>
	<form method="post" action="/user/account#login" id="login">
		<h3>Modifier mon pseudo</h3>
		<?php if (isset($message1)) { echo $message1; } ?>
		<label>Nouveau pseudo</label>
		<input type="text" name="pseudo" value="<?= ($_POST && array_key_exists('pseudo', $_POST))?$_POST['pseudo']:''; ?>" />
		<input type="submit" value="Modifier" name="changePseudo" />
	</form>
	<form method="post" action="/user/account#email" id="email">
		<h3>Modifier mon email</h3>
		<?php if (isset($message2)) { echo $message2; } ?>
		<label>Nouvelle adresse email</label>
		<input type="email" name="email" value="<?= ($_POST && array_key_exists('email', $_POST))?$_POST['email']:''; ?>" />
		<input type="submit" value="Modifier" name="changeEmail" />
	</form>
	<form method="post" action="/user/account#pass" id="pass">
		<h3>Modifier mon mot de passe</h3>
		<?php if (isset($message3)) { echo $message3; } ?>
		<label>Ancien mot de passe</label>
		<input type="password" name="oldpassword"/>
		<label>Nouveau mot de passe</label>
		<input type="password" name="password" />
		<label>Confirmation du nouveau mot de passe</label>
		<input type="password" name="confirmation" />
		<input type="submit" value="Modifier" name="changePass" />
	</form>
</div>
