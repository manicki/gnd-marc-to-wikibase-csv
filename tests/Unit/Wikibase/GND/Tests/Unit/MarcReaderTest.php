<?php

namespace Wikibase\GND\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Wikibase\GND\AuthorityRecord;
use Wikibase\GND\MarcReader;

class MarcReaderTest extends TestCase {

	public function testLoadParsesAuthorityRecordName() {
		$reader = new MarcReader();

		$records = $reader->load( __DIR__ . '/../data/authority.xml' );

		$authority = $records[0];

		$this->assertEquals( 'Association for Artichoke Studies', $authority->getName() );
	}

	public function testLoadParsesAuthorityRecordEntityType() {
		$reader = new MarcReader();

		$records = $reader->load( __DIR__ . '/../data/authority.xml' );

		$authority = $records[0];

		$this->assertEquals( AuthorityRecord::TYPE_CORPORATE_BODY, $authority->getEntityType() );
	}

}
