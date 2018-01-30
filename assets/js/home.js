var xhr = new XMLHttpRequest();

function toggleLike(e, id) {
	var reactionCount = e.parentElement.getElementsByClassName("reaction-count")[0];
	e.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
	httpGet("/post/like?id="+id, function(data) {
		if (e.dataset.liked == "true") {
			e.innerHTML = '<i class="fas fa-heart"></i>';
			e.dataset.liked = "false";
		} else {
			e.innerHTML = '<i class="far fa-heart"></i>';
			e.dataset.liked = "true";
		}
		httpGet("/post/get?id="+id, function(data) {
			var newCount = JSON.parse(data);
			reactionCount.innerHTML = newCount.likes.length+' likes, '+newCount.comments.length+' commentaires';
		});
	});
	return false;
}

function sendComment(e, id) {
	var content = e.parentElement.getElementsByTagName('textarea')[0];
	if (content.value.length > 0) {
		e.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i>';
		var reactionCount = e.parentElement.parentElement.getElementsByClassName("reaction-count")[0];
		var commentSection = e.parentElement.parentElement.getElementsByClassName("comments")[0];
		httpPost("/post/comment", "content="+content.value+"&id="+id, function(data) {
			e.parentElement.getElementsByTagName('textarea')[0].value = "";
			e.innerHTML = '<i class="far fa-paper-plane"></i>';
			httpGet("/post/get?id="+id, function(data) {
				var post = JSON.parse(data);
				reactionCount.innerHTML = post.likes.length+' likes, '+post.comments.length+' commentaires';
				commentSection.innerHTML = "";
				post.comments.forEach(function (comment) {
					commentSection.innerHTML += '<p><span class="author">'+comment.author+' :</span> '+comment.content+'</p>';
				});
			});
		});
	}
	return false;
}

function httpGet(uri, callback) {
	xhr.open("GET", uri, true);
	xhr.send(null);
	xhr.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			callback(xhr.responseText);
	    }
  };
}

function httpPost(uri, data, callback) {
	xhr.open("POST", uri, true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send(data);
	xhr.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {
			callback(xhr.responseText);
	    }
  };
}
