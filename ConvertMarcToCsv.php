<?php

require __DIR__ . '/vendor/autoload.php';

use Wikibase\GND\GndWikibaseMapper;

$filename = 'test.mrcxml';

$converter = new GndWikibaseMapper();

$converter->mapRecordsFromFile( $filename );
