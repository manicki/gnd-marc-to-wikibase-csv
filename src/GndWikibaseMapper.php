<?php

namespace Wikibase\GND;

class GndWikibaseMapper {

	private $marcReader;

	private $csvWriter;

	public function __construct() {
		$this->marcReader = new MarcReader();
		$this->csvWriter = new CsvWriter();
	}

	public function mapRecordsFromFile( string $filename ) {
		$records = $this->marcReader->load( $filename );

		$this->csvWriter->write( $records );

		return;
	}

}
