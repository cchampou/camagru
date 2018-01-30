<div class="wrap-center">
	<h2>Inscription</h2>
	<?= (isset($message)?$message:NULL) ?>
	<form method="post" action="/user/signup" class="center-block">
		<label>Pseudo</label>
		<input type="text" name="pseudo" value="<?= ($_POST && array_key_exists('pseudo', $_POST))?$_POST['pseudo']:''; ?>" />
		<label>Email</label>
		<input type="email" name="email" value="<?= ($_POST && array_key_exists('email', $_POST))?$_POST['email']:''; ?>" />
		<label>Mot de passe</label>
		<input type="password" name="password" />
		<label>Confirmation du mot de passe</label>
		<input type="password" name="confirmation" />
		<input type="submit" name="check" value="Se connecter">
	</form>
</div>
