<?php

namespace Wikibase\GND;

class AuthorityRecord {

	public const TYPE_CORPORATE_BODY = 'b';

	private $name;
	private $entityType;
	private $catalogLevel;
	private $gndUri;
	private $gndId;
	private $orcid;
	private $countryId;
	private $gender;
	private $placeOfBirth;

	public function __construct( string $name, string $entityType, string $catalogLevel, string $gndUri, string $gndId, string $orcid, string $countryId, string $gender, string $placeOfBirth ) {
		$this->name = $name;
		$this->entityType = $entityType;
		$this->catalogLevel = $catalogLevel;
		$this->gndUri = $gndUri;
		$this->gndId = $gndId;
		$this->orcid = $orcid;
		$this->countryId = $countryId;
		$this->gender = $gender;
		$this->placeOfBirth = $placeOfBirth;
	}

	public function getName() {
		return $this->name;
	}

	public function getEntityType() {
		return $this->entityType;
	}

	public function getCatalogLevel() {
		return $this->catalogLevel;
	}

	public function getGndUri() {
		return $this->gndUri;
	}

	public function getGndId() {
		return $this->gndId;
	}

	public function getOrcid() {
		return $this->orcid;
	}

	public function getCountryId() {
		return $this->countryId;
	}

	public function getGender() {
		return $this->gender;
	}

	public function getPlaceOfBirth() {
		return $this->placeOfBirth;
	}
}
