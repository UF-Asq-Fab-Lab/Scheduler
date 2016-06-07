<?php

/**
 * Infinity Fab Lab Ruleset Module
 *
 * Developed for the Infinity Fab Lab at the University of Florida.
 * Defines a Lab Ruleset page type which holds data and behaviors relevant to an
 * individual ruleset.
 *
 * Thomas R Storey, 2015
 * Licensed under MIT License, see LICENSE.TXT
 *
 * http://fablab.arts.ufl.edu
 * https://github.com/UF-Asq-Fab-Lab
 */

class LabRulesets extends PagesType {

	protected $labRulesets = null;

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
		return 'LabRuleset';
	}

  /**
	 * Hook called when a lab ruleset is deleted
	 *
	 * @param Page $language
	 *
	 */
	public function ___deleted(Page $labRuleset) {
		$this->updated($labRuleset, 'deleted');
	}

	/**
	 * Hook called when a lab ruleset is added
	 *
	 * @param Page $language
	 *
	 */
	public function ___added(Page $labRuleset) {
		$this->updated($labRuleset, 'added');
	}

	/**
	 * Hook called when a lab ruleset is added or deleted
	 *
	 * @param Page $language
	 * @param string $what What occurred? ('added' or 'deleted')
	 *
	 */
	public function ___updated(Page $labRuleset, $what) {
		// $this->reloadLabRulesets();
		$this->message("Updated lab ruleset item $labRuleset->name ($what)", Notice::debug);
	}

}
