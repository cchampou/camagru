<div class="wrap-center">
	<h2>Réinitialiser mon mot de passe</h2>
	<?= $message; ?>
	<form method="post" action="/user/reset" class="center-block">
		<label>Email</label>
		<input type="email" name="email" value="<?= ($_POST && array_key_exists('email', $_POST))?$_POST['email']:''; ?>" />
		<input type="hidden" name="coucou" value="<?= $_SESSION['coucou']; ?>" />
		<input type="submit" value="Se connecter">
	</form>
</div>
