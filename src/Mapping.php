<?php

namespace Wikibase\GND;

class Mapping {

	private $entityTypeMapping;
	private $catalogLevelMapping;
	private $genderMapping;

	public function __construct() {
		$this->entityTypeMapping = [
			'p' => 'Q9',
			AuthorityRecord::TYPE_CORPORATE_BODY => 'Q10',  // TODO: config
			'u' => 'Q11',
			's' => 'Q12',
		];
		$this->catalogLevelMapping = [
			'gnd1' => '1',
			'gnd2' => '2',
			'gnd3' => '3',
			'gnd4' => '4',
			'gnd5' => '5',
			'gnd6' => '6',
			'gnd7' => '7',
		];
		$this->genderMapping = [
			'1' => 'Q8', // TODO: config
			'2' => 'Q7',
		];
	}

	public function mapEntityType( string $type ) {
		if ( array_key_exists( $type, $this->entityTypeMapping ) ) {
			return $this->entityTypeMapping[$type];
		}

		return '';
	}

	public function mapCatalogLevel( string $level ) {
		if ( array_key_exists( $level, $this->catalogLevelMapping ) ) {
			return $this->catalogLevelMapping[$level];
		}

		return '';
	}

	public function mapGender( string $code ) {
		if ( array_key_exists( $code, $this->genderMapping ) ) {
			return $this->genderMapping[$code];
		}

		return '';
	}

}
