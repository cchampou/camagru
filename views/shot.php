<div class="wrap-large">
	<h2>Take a shot !</h2>
	<?= $message; ?>
	<div id="viewport">
		<form method="post" action="/user/shot" enctype="multipart/form-data" id="form">
			<input type="hidden" name="imgdata" id="camdata" />
			<label for="filter1" style="float: left; display: block; width: 5em;"><img src="../cool.png" alt="Filtre 1" class="filter" /><input type="radio" id="filter1" name="overlay" value="1"></label>
			<label for="filter2" style="float: left; display: block; width: 5em;"><img src="../idc.png" alt="Filtre 2" class="filter" /><input type="radio" id="filter2" name="overlay" value="2"></label>
			<label for="filter3" style="float: left; display: block; width: 5em;"><img src="../dude.png" alt="Filtre 3" class="filter" /><input type="radio" id="filter3" name="overlay" value="3"></label>
			<input type="hidden" name="coucou" value="<?= $_SESSION['coucou']; ?>" />
			<input type="file" name="shot" />
			<input type="submit" name="sendfile" value="Envoyer" id="sendfile" disabled />
			<p id="or">OU</p>
		</form>
		<div id="camtopwrap">
			<p style="position: absolute; z-index: -1;">Veuillez autoriser l'utilisation de la caméra pour accéder à cette fonctionnalité</p>
			<canvas id="canvas">
			</canvas>
			<img id="preview" />
			<video id="camwrap" autoplay></video>
			<button id="shotit"><i class="fas fa-camera"></i></button>
		</div>
	</div>
	<div id="recent">
		<?php
		foreach($previous as $elem) {
			?>
			<a href="/post/delete?id=<?= $elem['id']; ?>"><img src="<?= "/".$elem['img']; ?>" alt="Miniature" class="mini" /></a>
			<?php
		}
		?>
	</div>
	<div id="clearfix"></div>
</div>
<script src="/assets/js/camera.js"></script>
