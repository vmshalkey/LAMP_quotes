<!DOCTYPE html>
<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="/assets/styles.css">
	<meta charset="utf-8">
	<title>Welcome</title>
</head>
<body>
	<h2>Welcome <?= $user['first_name'] ?></h2>
	<div>
		<h3>Quotable Quotes</h3>
		<div>
			<?php foreach($quotes as $quote) { ?>
				<div class="post">
					<p><?= $quote['author'] ?>: <?= $quote['quote'] ?></p>
        			<p>Posted by <?= $quote['username'] ?></p>
        			<form action="/logins/add_favorite" method="post">
			        	<input type="hidden" name="favorited" value="<?= $quote['id'] ?>">
			        	<input type="submit" value="Add to Favorites!">
			        </form>
        		</div>
        	<?php } ?>
        </div>
	</div>

	<div>
		<h3>Favorite Quotes</h3>
		<div>
			<?php foreach($favorites as $favorite) { ?>
				<div class="post">
					<p><?= $favorite['author'] ?>: <?= $favorite['quote'] ?></p>
        			<p>Posted by <?= $favorite['username'] ?></p>
        			<form action="/logins/remove_favorite" method="post">
			        	<input type="hidden" name="unfavorited" value="<?= $favorite['favorite'] ?>">
			        	<input type="submit" value="Remove from Favorites!">
			        </form>
        		</div>
        	<?php } ?>
        </div>
	</div>
	<div>
		<h4>Add a quote:</h4>
        <form action="/logins/add_quote" method="post">
        	<textarea name="quote"></textarea>
        	<input type="text" name="author">
        	<input type="submit" value="Submit!">
        </form>
	</div>
	<div id="errors">
		<?= $this->session->flashdata("errors"); ?>
	</div>
	<a href="logins/logoff_user"><button>Log Off</button></a>
</body>
</html>