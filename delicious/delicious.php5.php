<?
/*
 * Copyright 2007 noworks.net. This code cannot be redistributed without
 * permission from noworks.net.
 *
 */
class Delicious {

	var $logger;
	
	var $user;

	var $password;

	function Delicious($user, $password){
		$this->__construct($user, $password);
	}

    /*
    * PHP5 Constructor
    */
	function __construct($user, $password) {
		$this->user = $user;
		$this->password = $password;
		$this->logger =& Log::singleton('file', 'app.log', 'ident', array('mode' => 0644), PEAR_LOG_INFO);
	}

	function getTags(){
		$body = file_get_contents($this->api_resource('tags/get'));
		if(false === $body){
			return false;
		}
		$xml = new SimpleXMLElement($body); 

		$tags = array();
		foreach ($xml->tag as $tag) {
			$tags[(string)$tag['tag']] = (string)$tag['count'];
		}
		return $tags;
	}

	function tagrename($old, $new){
		$query = "&old=". urlencode($old). "&new=". urlencode($new);
		$body = file_get_contents($this->api_resource('tags/rename?'). $query);
		if(false === $body){
			$this->logger->warn('エラー');
			return false;
		}else{
			$this->logger->info($url. $query);
		}
	
		$xml = new SimpleXMLElement($body); 

		return true;
	}
	
	function update(){
		$body = @file_get_contents($this->api_resource('posts/update'));
		if(false === $body){
			$this->logger->info('認証エラー');
			return false;
		}
		$xml = new SimpleXMLElement($body); 
		return $xml;
	}

	function api_resource($api){
		return "https://". $this->auth_phrase(). "@api.del.icio.us/v1/". $api;
	}

	function auth_phrase(){
		return $this->user. ":". $this->password;
	}
}
?>