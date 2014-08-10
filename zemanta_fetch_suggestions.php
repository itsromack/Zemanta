<?php
require_once('Zemanta.php');

$keyword = $_POST['keyword'];
$format = $_POST['format'];

$zemanta = new Zemanta();
if ($zemanta->getApiKey() === false) {
	error_log('fetching API key...');
	$zemanta->fetchApiKey();
}

echo $zemanta->fetchSuggestions($keyword, $format);
