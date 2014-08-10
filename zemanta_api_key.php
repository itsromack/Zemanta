<?php
require_once('Zemanta.php');

$zemanta = new Zemanta();
$zemanta->fetchApiKey();

return $zemanta->getApiKey();
