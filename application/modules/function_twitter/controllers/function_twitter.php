<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class function_twitter extends MX_Controller {

	public function __construct()
	{
	       parent::__construct();

	}
	
	public function display_tweets(){

		require_once   dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/twitter_api/tmhOAuth.php';
		
		// Use the data from http://dev.twitter.com/apps to fill out this info
		// notice the slight name difference in the last two items)
		
		define('CONSUMER_KEY', '6WRzQSWJQn40FDFAvuJA34c2d');
		define('CONSUMER_SECRET', 'J3VaoeoL6btZek1h6jbucLe06WpGbIBtgE1TyA7uOiTwnLeent');
		define('ACCESS_TOKEN', '2732477607-2Z0GSIUhoN8W6YBa9OPbau2k7LIr6llzH30Mdz3');
		define('ACCESS_TOKEN_SECRET', 'rlVk4ik3KV1J4dbng8jP911xCf7wTZpFMc07W8i3jScR3');
		
		$connection = new tmhOAuth(array(
		  'consumer_key' => CONSUMER_KEY,
			'consumer_secret' => CONSUMER_SECRET,
			'user_token' => ACCESS_TOKEN, //access token
			'user_secret' => ACCESS_TOKEN_SECRET //access token secret
		));
				
		// set up parameters to pass
		$parameters = array();
		
		$_GET["count"] = 1;
		
		if (isset($_GET['count'])) {
			$parameters['count'] = strip_tags($_GET['count']);
		}
		
		if (isset($_GET['screen_name'])) {
			$parameters['screen_name'] = "Cyberwatchcafe";
		}
		
		if (isset($_GET['twitter_path'])) { $twitter_path = $_GET['twitter_path']; }  else {
			$twitter_path = '1.1/statuses/user_timeline.json';
		}
		
		$http_code = $connection->request('GET', $connection->url($twitter_path), $parameters );
		
		if ($http_code === 200) { // if everything's good
			$response = strip_tags($connection->response['response']);
		
			if (isset($_GET['callback'])) { // if we ask for a jsonp callback function
				echo $_GET['callback'],'(', $response,');';
			} else {

				$this->display_response($response);	

			}
		} else {
			echo "Error ID: ",$http_code, "<br>\n";
			echo "Error: ",$connection->response['error'], "<br>\n";
		}
		
		// You may have to download and copy http://curl.haxx.se/ca/cacert.pem
		
		exit();
	}

    public function display_response($response){
			
			$response = json_decode($response);
			
			//echo "<pre>";
			//print_r($response);
			///echo "</pre>";
			
			$html = "";
				
			foreach($response as $tweet) {
//				$html .= '<article style="float:left; width:100%;">
//							<aside class="avatar" style="float:left; width:40px; height:40px">
//								<a href="http://twitter.com/'.$tweet->user->name.'" target="_blank">
//									<img alt="'.$tweet->user->name.'" src="'.$tweet->user->profile_image_url.'" style="float:left; width:50px; height:50px;" />
//								</a>
//							</aside>
//							<div style="float:left; width:180px; margin-left:22px; font-style:italic; font-family:arial; font-size:12px; color:#CCC">"'.$this->activate_url($tweet->text).'"</p>
//						</article>';
				
				$d = date( 'Y-m-d', strtotime($tweet->created_at) );
				
				$html .= '<article style="float:left; width:100%;">
							<div style="float:left; width:200px; margin-left:22px; font-style:italic; font-family:arial; font-size:12px; color:#78746C">"'.$this->activate_url($tweet->text).'"</div>
 							<div style="float:left; width:200px; margin-top:3px; margin-left:22px; font-family:arial; font-size:12px; color:#a09d95"><a href="http://twitter.com/'.$tweet->user->name.'" target="_blank" style="color:#a09d95"><b style="float:left">- '.$tweet->user->name.' '.$d.'</b></a></div>
 						  </article>';
				
		
			}
			
			exit($html);
	
	}

	public function activate_url($text){

				# Access as an object
				$tweetText = $text;
		
				# Make links active
				$tweetText = preg_replace("#(http://|(www.))(([^s<]{4,68})[^s<]*)#", '<a href="http://$2$3" style="color:#979907" target="_blank">$1$2$4</a>', $tweetText);
		
				# Linkify user mentions
				//$tweetText = preg_replace("/@(w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $tweetText);
		
				# Linkify tags
				//$tweetText = preg_replace("/#(w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>', $tweetText);
		
				return $tweetText;
	
	}


	public function display_tweets_old()
	{

		# Load Twitter class
		require_once   dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/twitter_api/twitter_api.php';
		
		# Define constants
		define('TWEET_LIMIT', 5);
		define('TWITTER_USERNAME', 'Cyberwatchcafe');
		define('CONSUMER_KEY', '6WRzQSWJQn40FDFAvuJA34c2d');
		define('CONSUMER_SECRET', 'J3VaoeoL6btZek1h6jbucLe06WpGbIBtgE1TyA7uOiTwnLeent');
		define('ACCESS_TOKEN', '2732477607-2Z0GSIUhoN8W6YBa9OPbau2k7LIr6llzH30Mdz3');
		define('ACCESS_TOKEN_SECRET', 'rlVk4ik3KV1J4dbng8jP911xCf7wTZpFMc07W8i3jScR3');
		
		# Create the connection
		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
		
		# Migrate over to SSL/TLS
		$twitter->ssl_verifypeer = true;
		
		# Load the Tweets
		$tweets = $twitter->get('statuses/user_timeline.json', array('screen_name' => TWITTER_USERNAME, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => TWEET_LIMIT));
		
		$html = "No Tweets Found";
		
		# Example output
		if(!empty($tweets)) {
			$html = "";
			foreach($tweets[0] as $tweet) {
				
				var_dump($tweet["text"]);
				
//				# Access as an object
//				$tweetText = $tweet['text'];
//		
//				# Make links active
//				$tweetText = preg_replace("#(http://|(www.))(([^s<]{4,68})[^s<]*)#", '<a href="http://$2$3" target="_blank">$1$2$4</a>', $tweetText);
//		
//				# Linkify user mentions
//				$tweetText = preg_replace("/@(w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $tweetText);
//		
//				# Linkify tags
//				$tweetText = preg_replace("/#(w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>', $tweetText);
//		
//				# Output
//				$html .= $tweetText;

//				$html .= '<article>
//					<aside class="avatar">
//						<a href="http://twitter.com/'.$tweet['from_user'].'" target="_blank">
//							<img alt="'.$tweet['from_user'].'" src="'.$tweet['user']['profile_image_url'].'" />
//						</a>
//					</aside>
//					<p>'.$tweet['created_at'].'</p>
//					<p>'.$tweet['text'].'</p>
//				</article>';
		
			}
			//exit($html);
		}		
		//exit($html);

	} 
	
	
}
