<?php

require __DIR__ . '/vendor/autoload.php';

use Wikibase\GND\GndWikibaseMapper;

if (count($argv) !== 2) {
	die("Usage php ConvertMarcToCsv.php input.xml\n");
}

$filename = $argv[1];

$converter = new GndWikibaseMapper();

$converter->mapRecordsFromFile( $filename );
