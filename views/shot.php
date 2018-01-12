<h2>Take a shot !</h2>
<div class="viewport">
	<video id="camwrap" autoplay></video>
	<script>
		navigator.mediaDevices.getUserMedia({
			audio: false,
			video: { width: 1280, height: 720}
		}).then(function(stream) {
			var source = document.createElement('source');
			source.src = window.URL.createObjectURL(stream);
			source.type = 'video/ogg';
			document.getElementById('camwrap').appendChild(source);
		});
	</script>
	<div id="recent">
		Pas de prises de vue récente
	</div>
</div>
