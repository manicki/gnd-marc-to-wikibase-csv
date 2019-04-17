<?php

namespace Wikibase\GND;

use League\Csv\Reader;
use League\Csv\Writer;

class CsvWriter {

	private $mapping;

	public function __construct() {
		$this->mapping = new Mapping(); // TODO: inject
	}

	public function write( array $records ) {
		$writer = Writer::createFromFileObject( new \SplFileObject('php://stdout', 'w'));
		$writer->setOutputBOM(Reader::BOM_UTF8);

		$this->writeHeader( $writer );

		foreach ( $records as $record ) {
			$writer->insertOne( [
				'',
				$record->getName(),
				$this->mapping->mapEntityType( $record->getEntityType() ),
				$this->mapping->mapCatalogLevel( $record->getCatalogLevel() ),
				$record->getGndUri(),
				$record->getGndId(),
				$record->getOrcid(),
				$record->getCountryId(),
				$this->mapping->mapGender( $record->getGender() ),
				$record->getPlaceOfBirth()
			] );
		}
	}

	private function writeHeader( Writer $writer ) {
		$writer->insertOne( [ 'qid', 'Lde', 'p9|Entitätentyp', 'p16|Katalogisierungslevel', 'p15|GND-URI', 'p19|GND ID', 'p20|ORCID', 'p22|Land', 'p23|Geschlecht', 'p38|Geburtsort (Verknüpfung)' ] );
	}
}
