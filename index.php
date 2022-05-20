<?php 
require 'vendor/autoload.php';
require_once "Route.class.php";

$route = new Route();

$httpClient = new \GuzzleHttp\Client();

$articles = [];

$newspapers = [

	[
		'name' => 'Monitor',
		'address' => 'https://www.monitor.co.ug/uganda/news',
		'base' => 'https://www.monitor.co.ug/uganda/news',
		'country' =>  'Uganda'
	],
	[
		'name' => 'Nilepost',
		'address' => 'http://nilepost.co.ug/category/news/',
		'base' => '',
		'country' =>  'Kenya'
	]

];



$route::get('/', function() {

	echo "Welcome to our news aggregator scraper";
	
});

$route::get('/news', function() {

	global $httpClient;
	global $articles;
	global $newspapers;
	

	foreach ($newspapers as $news) {

		$response = $httpClient->get($news['address']);
		$htmlString = (string) $response->getBody();
		// libxml_use_internal_errors(true);



		$dom = new domDocument();

		@$dom->loadHTML($htmlString);

		$xpath = new DOMXPath($dom);

		// $post_titles = $xpath->evaluate('//h3');
		// $post_date = $xpath->evaluate('//ul[@class="grid-container"]//li//a//article//aside//span[@class="date"]');
		$monitor_links = $xpath->evaluate('//div//ul[@class="grid-container"]//li//a | //div[@class="jeg_posts"]//article//a');
		// $nilepost_links = $xpath->evaluate('//article//a');

		

		$extractedTitles = [];

		foreach ($monitor_links as  $link) {

			$t = str_replace("\n", "", $link->textContent);
			// $time = $post_date[$key]->textContent;
			$url = $news['base']. $link->getAttribute("href");


			
			// str_contains(haystack, needle)
			$extractedTitles = [
				'title' => $t,
				'url' => $url,
				'country' => $news['country']
				
			];	

			array_push($articles, $extractedTitles);
			
		}

		// echo json_encode($articles);

	}
	echo json_encode($articles);

	


	
});





/*

TOOLS FOR ALLOWING GEBERICS
---PSALMS
---PHPstan
---Phan

*/
