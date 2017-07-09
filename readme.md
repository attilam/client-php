# Rotonde web client
Very basic, php-based web client to view an ordered timeline based on a base Rotonde feed. It's awfully slow and needs some caching to be more usable. ***/post** is hastily duct-taped together and needs to be consolidated with the feed view.

There is a running instance at http://rotonde.electricgecko.de/feed/

## Setup
- Copy all files to your server. 
- Point a **rotonde.** subdomain to the folder you copied the script to.
- Create a *feed.json* in the main folder and edit it according to the [Rotonde Spec](https://github.com/Rotonde/Specs).
- Edit **/post/accounts.php** with a username and password combination to authenticate yourself before posting, like so:

    ```
	$userinfo = array(
  		'Username' => 'Hveywhb9yAGbVuBu'
	);
    ```

## Reading
Visit **/feed** to display a timeline of all feeds listed in the *Portal* section of your base Rotonde feed.

## Posting
Visit **/post** to add a new post to your base Rotonde feed.
