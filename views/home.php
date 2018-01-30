<div class="wrap-center">
	<?php
	foreach($posts as $post) {
		?>
		<div class="post">
			<p><?= $post['pseudo']; ?></p>
			<img src="<?= '/'.$post['img']; ?>" alt="Image du post" />
			<div class="reaction">
				<p class="reaction-count"><?= count($post['likes']); ?> likes, <?= count($post['comments']); ?> commentaires</p>
				<?php
				if ($_SESSION && in_array($_SESSION['id'], $post['likes'])) {
					?>
					<a href="/post/like?id=<?= $post['postid']; ?>" onclick="return toggleLike(this, <?= $post['postid']; ?>);" data-liked="false"><i class="fas fa-heart"></i></a>
					<?php
				} else {
					?>
					<a href="/post/like?id=<?= $post['postid']; ?>" onclick="return toggleLike(this, <?= $post['postid']; ?>);" data-liked="true"><i class="far fa-heart"></i></a>
					<?php
				}
				?>
				<form method="post" action="/post/comment">
					<input type="hidden" name="id" value="<?= $post['postid']; ?>" />
					<textarea name="content" placeholder="Lache ton com ..." rows="1" ></textarea>
					<button type="submit" onclick="return sendComment(this, <?= $post['postid']; ?>);"><i class="fas fa-paper-plane"></i></button>
				</form>
				<div style="clear: both;"></div>
				<div class="comments">
				<?php
				foreach ($post['comments'] as $comment) {
					?>
					<p><span class="author"><?= htmlspecialchars($comment['author']); ?> :</span>
						<?= htmlspecialchars($comment['content']); ?>
					</p>
					<?php
				}
				?>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<p class="pagination">
		<?= ($_GET && array_key_exists('page', $_GET) && $_GET['page'] > 1)?'<a href="/home/index?page='.($_GET['page'] - 1).'"><</a>':NULL; ?>
		<?php
		for ($i=1; $i <= $nb_pages; $i++) {
			echo '<a href="/home/index?page='.$i.'">'.$i.'</a> ';
		}
		?>
		<?= ($_GET && array_key_exists('page', $_GET) && $_GET['page'] < $nb_pages)?'<a href="/home/index?page='.($_GET['page'] + 1).'">></a>':NULL; ?>
		<?= ((!$_GET  && $nb_pages > 1) || ($_GET && !array_key_exists('page', $_GET) && $nb_pages > 1))?'<a href="/home/index?page=2">></a>':NULL; ?>
	</p>
</div>
<script src="/assets/js/home.js"></script>
