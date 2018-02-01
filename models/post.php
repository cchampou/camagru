<?php

require('config/database.php');

class PostModel {

	public function create($image) {
		global $db;
		$query = $db->prepare("INSERT INTO posts VALUES (null, ?, ?)");
		$query->execute(array($_SESSION['id'], $image));
	}

	public function delete($id) {
		global $db;
		$current = $this->getOne($id);
		unlink($current['img']);
		$query = $db->prepare("DELETE FROM posts WHERE id = ? AND owner = ?");
		$query->execute(array($id, $_SESSION['id']));
	}

	public function getOne($id) {
		global $db;
		$query = $db->prepare("SELECT id, img FROM posts WHERE id = ?");
		$query->execute(array($id));
		$post = $query->fetch();
		$req = $db->prepare("SELECT * FROM likes WHERE post = ?");
		$req->execute(array($id));
		$post['likes'] = $req->fetchAll(PDO::FETCH_COLUMN);
		$req = $db->prepare("SELECT *, users.pseudo AS author FROM comments LEFT JOIN users ON users.id = comments.owner WHERE post = ?");
		$req->execute(array($id));
		$post['comments'] = $req->fetchAll();
		return $post;
	}

	public function getMine() {
		global $db;
		$query = $db->prepare("SELECT id, img FROM posts WHERE owner = ? ORDER BY id DESC");
		$query->execute(array($_SESSION['id']));
		return $query->fetchAll();
	}

	public function getPages() {
		global $db;
		$getPages = $db->prepare("SELECT COUNT(id) as nb FROM posts");
		$getPages->execute();
		$res = $getPages->fetch();
		return ceil($res['nb'] / 5);
	}

	public function getAll($page) {
		global $db;
		$query = $db->prepare("SELECT img, posts.id as postid, users.pseudo as pseudo FROM posts LEFT JOIN users ON users.id = posts.owner ORDER BY posts.id DESC LIMIT :min, :range");
		$min = ($page - 1) * 5;
		$range = $page * 5;
		$query->bindParam(':min', $min, PDO::PARAM_INT);
		$query->bindParam(':range', $range,  PDO::PARAM_INT);
		$query->execute();
		$posts = $query->fetchAll();
		foreach($posts as $key => $post) {
			$getLikes = $db->prepare("SELECT owner FROM likes WHERE post = ?");
			$getLikes->execute(array($post['postid']));
			$posts[$key]['likes'] = $getLikes->fetchAll(PDO::FETCH_COLUMN);
			$getComments = $db->prepare("SELECT owner, users.pseudo as author, content FROM comments LEFT JOIN users ON users.id = comments.owner WHERE post = ?");
			$getComments->execute(array($post['postid']));
			$posts[$key]['comments'] = $getComments->fetchAll();
		}
		return $posts;
	}

	public function toggleLike($id) {
		global $db;
		$getExistent = $db->prepare("SELECT id FROM likes WHERE post = ? AND owner = ?");
		$getExistent->execute(array($id, $_SESSION['id']));
		$data = $getExistent->fetch();
		if ($data['id']) {
			$remove = $db->prepare("DELETE FROM likes WHERE post = ? AND owner = ?");
			$remove->execute(array($id, $_SESSION['id']));
		} else {
			$add = $db->prepare("INSERT INTO likes VALUES (null, ?, ?)");
			$add->execute(array($id, $_SESSION['id']));
		}
		return;
	}

	public function comment($id, $content) {
		global $db;
		$do = $db->prepare("INSERT INTO comments VALUES (null, ?, ?, ?)");
		$do->execute(array($id, $_SESSION['id'], $content));
		$owner = $db->prepare("SELECT * FROM posts LEFT JOIN users ON users.id = posts.owner WHERE posts.id = ?");
		$owner->execute(array($id));
		$owner = $owner->fetch();
		if ($owner['notif']) {
			mail($owner['email'], "Camagru notifier", "Un commentaire a été ajouté a une de vos photos");
		}
		return;
	}

}
