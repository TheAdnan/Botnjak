<?php 
error_reporting(-1);

require "vendor/autoload.php";
include 'credentials.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use Analog\Analog;

ini_set('memory_limit', '2048M');


$log_file = 'bot.log';
Analog::handler (Analog\Handler\File::init ($log_file));


function search(array $query){
	global $connection;
	return $connection->get('search/tweets', $query);
}

$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_key, $access_secret);

$query = array(
  'q' => 'bosanac OR bosanci OR bosancu OR bosanca OR bosanaca  OR bosancima OR bosance',
  'count' => '20',
  'result_type' => 'recent'
);
  
$results = search($query);
  
foreach ($results->statuses as $result) {
   $text = $result->text;
   $user = $result->user->screen_name;
   $newtweet = "bošnjak*";
   $replyuser = "@" . $user ;
   $reply = "$replyuser  $newtweet";
   echo $reply  . "\n";
   $tweetID = $result->id_str;
   Analog::log('{$reply} to Tweet: $text \n');
   //Reply to tweet
   $response = $connection->post('statuses/update' , array('status' => $reply, 'in_reply_to_status_id' => $result->id_str));
}

?>
