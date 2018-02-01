<div class="wrap-center">
	<h2>Définir un nouveau mot de passe</h2>
	<?= $message; ?>
	<form method="post" action="/user/newpass?token=<?= $_GET['token'];?>" class="center-block">
		<label>Nouveau mot de passe</label>
		<input type="password" name="password" />
		<label>Confirmation</label>
		<input type="password" name="confirmation" />
		<input type="hidden" name="coucou" value="<?= $_SESSION['coucou']; ?>" />
		<input type="submit" value="Valider">
	</form>
</div>
