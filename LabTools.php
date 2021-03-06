<?php

/**
 * Infinity Fab Lab Tool Module
 *
 * Developed for the Infinity Fab Lab at the University of Florida.
 * Defines a Lab Tool page type which holds data and behaviors relevant to an
 * individual tool.
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabTools extends PagesType {

	protected $labTools = null;

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
		return 'LabTool';
	}

  /**
	 * Hook called when a lab tool is deleted
	 *
	 * @param Page $language
	 *
	 */
	public function ___deleted(Page $labTool) {
		$this->updated($labTool, 'deleted');
	}

	/**
	 * Hook called when a lab tool is added
	 *
	 * @param Page $language
	 *
	 */
	public function ___added(Page $labTool) {
		$this->updated($labTool, 'added');
	}

	/**
	 * Hook called when a lab tool is added or deleted
	 *
	 * @param Page $language
	 * @param string $what What occurred? ('added' or 'deleted')
	 *
	 */
	public function ___updated(Page $labTool, $what) {
		// $this->reloadLabTools();
		$this->message("Updated lab tool item $labTool->name ($what)", Notice::debug);
	}

}
