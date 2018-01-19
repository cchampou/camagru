<h2>Connexion</h2>
<?= ($message != '')?$message:NULL; ?>
<form method="post" action="/user/login" class="center-block">
	<label>Email</label>
	<input type="email" name="email" value="<?= ($_POST && array_key_exists('email', $_POST))?$_POST['email']:''; ?>" />
	<label>Mot de passe</label>
	<input type="password" name="password" />
	<input type="submit" value="Se connecter">
</form>
