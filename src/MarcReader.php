<?php

namespace Wikibase\GND;

use File_MARC_Data_Field;
use File_MARC_Record;
use File_MARCXML;

class MarcReader {

	public function load( string $filename ): array {
		$marcRecords = new File_MARCXML( $filename );
		$records = [];

		while ( $record = $marcRecords->next() ) {
			$records[] = $this->loadRecord( $record );
		}

		return $records;
	}

	private function loadRecord(File_MARC_Record $record) {
		// TODO: get type and assert it is an authority record
		/** @var File_MARC_Data_Field $nameField */
		$nameField = $record->getField( '110' );

		$name = '';
		if ( $nameField !== false && $nameField->getSubfield( 'a' ) !== false ) {
			$name = $nameField->getSubfield( 'a' )->getData();
		}

		return new AuthorityRecord(
			$name,
			$this->getEntityType( $record ),
			$this->getCatalogLevel( $record ),
			$this->getGndUri( $record ),
			$this->getGndId( $record ),
			$this->getOrcid( $record ),
			$this->getCountryId( $record ),
			$this->getGender( $record ),
			$this->getPlaceOfBirth( $record )
		);
	}

	private function getEntityType(File_MARC_Record $record) {
		$fields = $record->getFields( '075' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ( $field->getIndicator( 1 ) !== ' ' || $field->getIndicator( 2 ) !== ' ' ) {
				continue;
			}

			if ( $field->getSubfield( '2' ) === false ) {
				continue;
			}
			if ( $field->getSubfield( '2' )->getData() !== 'gndgen' ) {
				continue;
			}

			$typeCode = $field->getSubfield( 'b' )->getData();

			// TODO: constant differentiated person
			if ( $typeCode === 'p' ) {
				return 'p'; // TODO: constant
			}

			if ( $typeCode === 'b' ) {
				return AuthorityRecord::TYPE_CORPORATE_BODY;
			}

			// TODO: constant TODO
			if ( $typeCode === 'u' ) {
				return 'u'; // TODO: constant
			}

			// TODO: constant TODO
			if ( $typeCode === 's' ) {
				return 's'; // TODO: constant
			}
		}

		// TODO
		return '';
	}

	private function getCatalogLevel( File_MARC_Record $record ) {
		$fields = $record->getFields( '042' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== ' ' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ($field->getSubfield('a') === false) {
				continue;
			}
			$level = $field->getSubfield('a')->getData();
			// TODO: validate

			return $level;
		}

		return null;
	}

	private function getGndUri( File_MARC_Record $record ) {
		$fields = $record->getFields( '024' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== '7' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ( $field->getSubfield( '2' ) === false ) {
				continue;
			}
			if ( $field->getSubfield( '2' )->getData() !== 'uri' ) {
				continue;
			}

			if ($field->getSubfield('a') === false) {
				continue;
			}

			return $field->getSubfield('a')->getData();
		}

		return '';
	}

	private function getGndId( File_MARC_Record $record ) {
		$fields = $record->getFields( '035' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== ' ' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ($field->getSubfield('a') === false) {
				continue;
			}

			$id = $field->getSubfield('a')->getData();

			if ( substr( $id, 0, strlen( '(DE-588)') ) === '(DE-588)') {
				return $id;
			}
		}

		return '';
	}

	private function getOrcid( File_MARC_Record $record ) {
		$fields = $record->getFields( '024' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== '7' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ( $field->getSubfield( '2' ) === false ) {
				continue;
			}
			if ( $field->getSubfield( '2' )->getData() !== 'orcid' ) {
				continue;
			}

			if ($field->getSubfield('a') === false) {
				continue;
			}

			return $field->getSubfield('a')->getData();
		}

		return '';
	}

	private function getCountryId( File_MARC_Record $record ) {
		$fields = $record->getFields( '043' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== ' ' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ($field->getSubfield('c') === false) {
				continue;
			}

			return $field->getSubfield('c')->getData();
		}

		return '';
	}

	private function getGender( File_MARC_Record $record ) {
		$fields = $record->getFields( '375' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== ' ' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ( $field->getSubfield( '2' ) === false ) {
				continue;
			}
			if ( $field->getSubfield( '2' )->getData() !== 'iso5218' ) {
				continue;
			}

			if ($field->getSubfield('a') === false) {
				continue;
			}

			return $field->getSubfield('a')->getData();
		}

		return '';
	}

	private function getPlaceOfBirth( File_MARC_Record $record ) {
		$fields = $record->getFields( '551' );
		foreach ( $fields as $field ) {
			/** @var File_MARC_Data_Field $field */
			if ($field->getIndicator(1) !== ' ' || $field->getIndicator(2) !== ' ') {
				continue;
			}

			if ( $field->getSubfield( '4' ) === false ) {
				continue;
			}
			if ( $field->getSubfield( '4' )->getData() !== 'ortg' ) {
				continue;
			}

			if ($field->getSubfield('0') === false) {
				continue;
			}

			return $field->getSubfield('0')->getData();
		}

		return '';
	}
}
