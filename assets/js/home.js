var xhr = new XMLHttpRequest();

function toggleLike(e, id) {
	var reactionCount = e.parentElement.getElementsByClassName("reaction-count")[0];
	e.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
	httpGet("/post/like?id="+id, function(status, data) {
		if (status == 200) {
			if (e.dataset.liked == "true") {
				e.innerHTML = '<i class="fas fa-heart"></i>';
				e.dataset.liked = "false";
			} else {
				e.innerHTML = '<i class="far fa-heart"></i>';
				e.dataset.liked = "true";
			}
			httpGet("/post/get?id="+id, function(status, data) {
				var newCount = JSON.parse(data);
				reactionCount.innerHTML = newCount.likes.length+' '+((newCount.likes.length < 2)?'like':'likes')+', '+newCount.comments.length+' '+((newCount.comments.length < 2)?'commentaire':'commentaires');
			});
		} else if (status == 202) {
			if (e.dataset.liked == "true") {
				e.innerHTML = '<i class="far fa-heart"></i>';
			} else {
				e.innerHTML = '<i class="fas fa-heart"></i>';
			}
			window.location = "/user/login?prompt=true";
		}
	});
	return false;
}

function sendComment(e, id) {
	var content = e.parentElement.getElementsByTagName('textarea')[0];
	var token = e.parentElement.getElementsByTagName('input')[0];
	if (content.value.length > 0) {
		e.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
		var reactionCount = e.parentElement.parentElement.getElementsByClassName("reaction-count")[0];
		var commentSection = e.parentElement.parentElement.getElementsByClassName("comments")[0];
		httpPost("/post/comment", "content="+content.value+"&coucou="+token.value+"&id="+id, function(status, data) {
			if (status == 200) {
				e.parentElement.getElementsByTagName('textarea')[0].value = "";
				e.innerHTML = '<i class="fas fa-paper-plane"></i>';
				httpGet("/post/get?id="+id, function(status, data) {
					var post = JSON.parse(data);
					reactionCount.innerHTML = post.likes.length+' '+((post.likes.length < 2)?'like':'likes')+', '+post.comments.length+' '+((post.comments.length < 2)?'commentaire':'commentaires');
					commentSection.innerHTML = "";
					post.comments.forEach(function (comment) {
						commentSection.innerHTML += '<p><span class="author">'+htmlEntities(comment.author)+' :</span> '+htmlEntities(comment.content)+'</p>';
					});
				});
			} else if (status == 202){
				e.innerHTML = '<i class="fas fa-paper-plane"></i>';
				window.location = "/user/login?prompt=true";
			}
		});
	}
	return false;
}

function httpGet(uri, callback) {
	xhr.open("GET", uri, true);
	xhr.setRequestHeader('X-Async-Agent', 'yes');
	xhr.send(null);
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status >= 200 && this.status <= 299) {
			callback(this.status, xhr.responseText);
		}
	};
}

function httpPost(uri, data, callback) {
	xhr.open("POST", uri, true);
	xhr.setRequestHeader('X-Async-Agent', 'yes');
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data);
	xhr.onreadystatechange = function() {
		if (this.readyState == 4 && this.status >= 200 && this.status <= 299) {
			callback(this.status, xhr.responseText);
		}
	};
}

function htmlEntities(str) {
	return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}
