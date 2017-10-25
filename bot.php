<?php 

require "vendor/autoload.php";
//require_once('path/to/twitteroauth.php');
include 'credentials.php';
use Abraham\TwitterOAuth\TwitterOAuth;

ini_set('memory_limit', '2048M');
 
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_key, $access_secret);

function search(array $query){
	global $connection;
	return $connection->get('search/tweets', $query);
}

$query = array(
  'q' => 'bosanac OR bosanci OR bosancu OR bosanca OR bosancima',
  'lang' => 'bs', 
);
  
$results = search($query);
  
foreach ($results->statuses as $result) {
   $user = $result->user->screen_name;
   $newtweet = "bošnjak*";
   $replyuser = "@" . $user ;
   $reply = "$replyuser  $newtweet";
   echo "<br>";
   echo $reply  . "\n";
   $tweetID = $result->id_str;
   echo "<br>";
   //Reply to tweet
   $response = $connection->post('statuses/update' , array('status' => $reply ));
}

?>
