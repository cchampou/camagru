<h2>Mon compte</h2>
<h3>Mes informations de connexion</h3>
<p>
	<strong>Pseudo :</strong> <?= $user['pseudo']; ?><br />
	<strong>Email :</strong> <?= $user['email']; ?>
</p>
<h3>Modifier mon pseudo</h3>
<form method="post" action="/user/account">
	<label>Nouveau pseudo</label>
	<input type="text" name="pseudo" value="<?= $_POST['pseudo']; ?>" />
	<input type="submit" value="Modifier" />
</form>
<h3>Modifier mon email</h3>
<form method="post" action="/user/account">
	<label>Nouvelle adresse email</label>
	<input type="email" name="email" value="<?= $_POST['email']; ?>" />
	<input type="submit" value="Modifier" />
</form>
<h3>Modifier mon mot de passe</h3>
<form method="post" action="/user/account">
	<label>Ancien mot de passe</label>
	<input type="password" name="oldpassword" value="<?= $_POST['oldpassword']; ?>" />
	<label>Nouveau mot de passe</label>
	<input type="password" name="password" value="<?= $_POST['password']; ?>" />
	<label>Confirmation du nouveau mot de passe</label>
	<input type="password" name="confirmation" value="<?= $_POST['confirmation']; ?>" />
	<input type="submit" value="Modifier" />
</form>
