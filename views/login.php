<div class="wrap-center">
	<h2>Connexion</h2>
	<?= $message; ?>
	<form method="post" action="/user/login" class="center-block">
		<label>Email</label>
		<input type="email" name="email" value="<?= ($_POST && array_key_exists('email', $_POST))?$_POST['email']:''; ?>" />
		<label>Mot de passe</label>
		<input type="password" name="password" />
		<a href="/user/signup">Je n'ai pas encore de compte</a><br /><br />
		<a href="/user/reset">J'ai oublié mon mot de passe</a>
		<input type="hidden" name="coucou" value="<?= $_SESSION['coucou']; ?>" />
		<input type="submit" value="Se connecter">
	</form>
</div>
