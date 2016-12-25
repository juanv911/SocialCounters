# SocialCounters
* Display social media counters. 
* Twitter Followers
* Facebook Likes
* Instagram Followers 
* Google Plus Followers 
* LinkedIn Connections
* YouTube Subcribers
* Vine Followers
* Pinterest Followers
* Dribbble Followers
* SoundCloud Followers
* Vimeo Followers
* GitHub Followers
* Behance Followers
* VK Followers
* Foursquare Friends
* Tumblr Blog Followers
* Twitch Channel Followers

## Limits
* Some of these API have limits on the amount of requests per hour your access token can make.
* These API sometimes update their parameters or endpoints. When that happens the code might not work and might need to be updated. If that happens submit an issue here on GitHub and I will try fix any issues.
* If too many request are made at the same time with my access tokens in my demos, you might hit a limit and wait for the new request to be available. Try to create your own access tokens to prevent hitting a limit.

## Requirements
* These requirements apply mainly for Twitter and Tumblr
* PHP 5+
* CURL

## Instructions
* The Twitter and Vine counters require PHP to work, all other counters only require jQuery. 
* Due to the update to the Instagram API after June 1, 2016 you can only access your own photos and profile information using the access token you create.
* After uploading all files to the server, you might need to change this in the api.js for  Twitter and Vine. Change ../SocialCounter/twitter/index.php to http://yoursite.com/SocialCounter/twitter/index.php to include the path to your domain.
* Most of these counters require either access tokens, client id or keys. You need to create these keys in order to display a value.
* In the index.html, place your username and tokens inside the single quotes and it should work.

# How To Use
* Use the example html file provided to display your social media stats. Make sure that there is an html tag with a class belonging to a particular counter. The example below only fetches information about soundcloud, you can add up to 15 counters. In the example file, all html classes are provided, so you can just plugin your username and token, you can also remove counters. Every counter has to have its own html class such as facebook, twitter, instagram, etc...
<pre>
<code>
$('#wrapper').SocialCounter({
  soundcloud_user_id: 'USER-ID-HERE',
  soundcloud_client_id:'TOKEN-HERE'
});
</code>
</pre>


* For this particular counter, the soundcloud class must be included, otherwise it will not display anything.

&lt;a class="item soundcloud"></a&gt;

## Edit Demos in Codepen
* http://codepen.io/juanv911/pen/gbgjLe 
* http://codepen.io/juanv911/pen/ozPoaB
* http://codepen.io/juanv911/pen/oYgbjb

## Credits
* <a href="https://github.com/j7mbo/twitter-api-php">twitter-api-php</a>
* <a href="https://github.com/gregavola/tumblrPHP">tumblrPHP</a>
