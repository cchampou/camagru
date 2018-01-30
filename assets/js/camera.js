navigator.mediaDevices.getUserMedia({
	audio: false,
	video: { width: 1280, height: 720}
}).then(function(stream) {
	var source = document.createElement('source');
	source.src = window.URL.createObjectURL(stream);
	source.type = 'video/ogg';
	document.getElementById('camwrap').appendChild(source);
});


document.getElementById("form").addEventListener('click', function (e) {
	var radios = document.getElementsByName('overlay');
	var length = radios.length;
	for (var i = 0; i < length; i++) {
		if (radios[i].checked) {
			document.getElementById('sendfile').removeAttribute('disabled');
			document.getElementById('shotit').style.backgroundColor = '#1A237E';
			document.getElementById('shotit').style.cursor = 'pointer';
			if (i == 0) {
				document.getElementById('preview').setAttribute('src', '/cool.png');
			}
			if (i == 1) {
				document.getElementById('preview').setAttribute('src', '/idc.png');
			}
			if (i == 2) {
				document.getElementById('preview').setAttribute('src', '/dude.png');
			}
			document.getElementById('shotit').addEventListener('click', function(e) {
				e.preventDefault();
				var form = document.getElementById('form');
				var canvas = document.getElementById('canvas');
				var camwrap = document.getElementById('camwrap');
				var height = camwrap.clientHeight;
				var width = camwrap.clientWidth;
				canvas.setAttribute("height", height);
				canvas.setAttribute("width", width);
				console.log(width);
				console.log(height);
				canvas.getContext('2d').drawImage(camwrap, 0, 0, width, height);
				var img = canvas.toDataURL('image/png');
				document.getElementById('camdata').setAttribute("value", img);
				form.submit();
				return;
			});
		}
	}
});
