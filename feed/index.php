<?php
	ini_set("allow_url_fopen", 1);	  

	// options
	$imgSize = 125; // image thumbnail width
	 
	// get my feed
	$f = 'http://rotonde.electricgecko.de/feed.json'; // replace with your feed URL
	$myFeed = json_decode(file_get_contents($f)); 	
	
	// get list of portals i'm following
	$following = $myFeed->portal;
	
	// helper function to sort timeline by time of entry
	function cmp($a, $b) { 
		if ($a->time == $b->time) { return 0; } 
		return ($a->time > $b->time) ? -1 : 1;
	} 
	
	// get followed feeds and build timeline
	$timeline = array();	
	
	foreach($following as $followingUrl) {
		$user = json_decode(file_get_contents('http://'.$followingUrl));
		
			foreach ($user->feed as $userPost) {
				// attach user info to each post
				$userPost = (object) array_merge( (array)$userPost, array( 'user' => $user->profile ) );
				$timeline[] = $userPost;
			}
	}
	
	// sort by timestamp
	usort($timeline, 'cmp');
?>

<!DOCTYPE html>
<head>
	<meta charset="UTF-8"/>
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<link rel="apple-touch-icon" sizes="114x114" href="../assets/images/favicons/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="../assets/images/favicons/apple-touch-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="../assets/images/favicons/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="../assets/images/favicons/apple-touch-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="../assets/images/favicons/apple-touch-icon-180x180.png">
	<link rel="icon" type="image/png" href="../assets/images/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="../assets/images/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="../assets/images/favicons/manifest.json">
	<link rel="mask-icon" href="../assets/images/favicons/safari-pinned-tab.svg" color="#000">
	<link rel="shortcut icon" href="../assets/images/favicons/favicon.ico">

	<title>Radius &middot; Rotonde timeline</title>
	<link rel="stylesheet" href="../assets/css/feed.css">
</head>

<body>
	<header>
		<a href="#top"><h1>Radius &middot; Rotonde timeline</h1></a>
	</header>
	
	<main>
		<a class="btn" href="../post/">Post entry</a>
		<ul class="rotondeTimeline" id="rotondeTimeline">
		<?php foreach ($timeline as $entry) :?>
			
			<li>
				<main>
					<?php if ($entry->media != '') : ?> 
					<a target="_blank" href="<?= $entry->media ?>">
						<img src="<?= $entry->media ?>" alt="" width="<?= $imgSize ?>" />
					</a>
					<?php endif ?>
					
					<p>
						<?= $entry->text ?>
						
						<?php if ($entry->url != '') : ?>
							&rarr; <a href="<?= $entry->url ?>" style="border-color: <?= $entry->user->color ?>;">Link</a>
						<?php endif ?>	
					</p>
				</main>
				<footer>
					<span class="userColor" style="color: <?= $entry->user->color ?>;"></span>
					<img class="avatar" src="<?= $entry->user->avatar ?>" alt="Rotonde avatar" width="25" height="25"/>
					
					<ul class="meta">
						<li class="user">
							<span class="userName"><?= $entry->user->name ?></span>
							<?php if ($entry->ref != '') : ?>
								<span class="reference"> ⤷ <?= $entry->ref ?></span>
							<?php elseif ($entry->position != '') : ?>
								<span class="position"> from <a href="https://www.google.de/maps/place/<?= $entry->position ?>" style="border-color: <?= $entry->user->color ?>;"><?= $entry->position ?></a></span>
							<?php else : ?>
								<span class="userLocation"> from <a href="https://www.google.de/maps/place/<?= $entry->user->location ?>" style="border-color: <?= $entry->user->color ?>;"><?= $entry->user->location ?></a></span>
							<?php endif ?>
							</span>
						</li>
						<li class="time"><?= date('m.d.y - H:m:s', $entry->time) ?> (<?= $entry->time ?>)</li>
					</ul>
				</footer>
			</li>
		
		<?php endforeach ?>
		</ul>
	</main>	
</body>