<?php

/**
 * Infinity Fab Lab Reservation Module
 *
 * Developed for the Infinity Fab Lab at the University of Florida.
 * Defines a Lab Reservation page type which holds data and behaviors relevant to an
 * individual reservation.
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabReservations extends PagesType {

	protected $labReservations = null;

	/**
	 * Like find() but returns only the first match as a Page object (not PageArray)
	 *
	 * This is an alias of the findOne() method for syntactic convenience and
   * consistency.
	 *
	 * @param string $selectorString
	 * @return Page|null
	 */
	public function get($selectorString) {
		$lc = parent::get($selectorString);
		return $lc;
	}

  public function getPageClass() {
		return 'LabReservation';
	}

  /**
	 * Hook called when a lab reservation is deleted
	 *
	 * @param Page $language
	 *
	 */
	public function ___deleted(Page $labReservation) {
		$this->updated($labReservation, 'deleted');
	}

	/**
	 * Hook called when a lab reservation is added
	 *
	 * @param Page $language
	 *
	 */
	public function ___added(Page $labReservation) {
		$this->updated($labReservation, 'added');
	}

	/**
	 * Hook called when a lab reservation is added or deleted
	 *
	 * @param Page $language
	 * @param string $what What occurred? ('added' or 'deleted')
	 *
	 */
	public function ___updated(Page $labReservation, $what) {
		// $this->reloadLabReservations();
		$this->message("Updated lab reservation item $labReservation->name ($what)", Notice::debug);
	}

}
