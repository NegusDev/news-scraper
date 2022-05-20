<?php 

class Route {

	public static function uri(){

		return $_SERVER['REQUEST_URI'];
	}
	

	public static function get($url, $content) {

		$request_uri = self::uri();

		if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			if ($request_uri == $url) {
				if (is_callable($content)) {
					$content();
					// var_dump($content());
				}
				else {
					echo $content;
					// var_dump($content);
				}
				exit;
			}
		}
	}

	public static function post($url, $content) {

		$request_uri = self::uri();

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ($request_uri == $url) {
				if (is_callable($content)) {
					$content();
				}
				else {
					echo $content;
				}
				exit;
			}
		}
	}


}