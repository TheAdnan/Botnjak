<?php 

require "vendor/autoload.php";
include 'credentials.php';
use Abraham\TwitterOAuth\TwitterOAuth;

ini_set('memory_limit', '2048M');
 

function search(array $query){
	global $connection;
	return $connection->get('search/tweets', $query);
}

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_key, $access_secret);

$query = array(
  'q' => 'bosanac OR bosanci OR bosancu OR bosanca OR bosancima',
  'count' => '10',
  'result_type' => 'recent'
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
   $response = $connection->post('statuses/update' , array('status' => $reply, 'in_reply_to_status_id' => $result->id_str));
}

?>
