<?php

/**
 * @file plugins/themes/default/DefaultManuscriptChildThemePlugin.php
 *
 * Copyright (c) 2014-2020 Simon Fraser University
 * Copyright (c) 2003-2020 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @class DefaultManuscriptChildThemePlugin
 * @ingroup plugins_themes_default_manuscript
 *
 * @brief Default theme
 */
namespace APP\plugins\themes\defaultManuscript;

use PKP\plugins\ThemePlugin;

class DefaultManuscriptChildThemePlugin extends ThemePlugin {
	/**
	 * Initialize the theme's styles, scripts and hooks. This is only run for
	 * the currently active theme.
	 *
	 * @return null
	 */
	public function init() {

		// Initialize the parent theme
		$this->setParent('defaultthemeplugin');

		// Add custom styles
		$this->modifyStyle('stylesheet', array('addLess' => array('styles/index.less')));

		// Remove the typography options of the parent theme.
		$this->removeOption('typography');
		$this->removeOption('useHomepageImageAsHeader');

		// Add the option for an accent color
		$this->addOption('accentColour', 'FieldColor', [
			'label' => __('plugins.themes.defaultManuscript.option.accentColour.label'),
			'description' => __('plugins.themes.defaultManuscript.option.accentColour.description'),
			'default' => '#F7BC4A',
		]);

		// Dequeue the font and homepage header image loaded by the parent theme,
		// whose options are removed above
		$this->removeStyle('font');
		$this->removeStyle('homepageImage');

		// Restore this theme's fonts. The parent theme's typography option may
		// have added @font variables, which are compiled after this theme's
		// LESS files, so this theme's fonts must be set again after them.
		$additionalLessVariables = array(
			'@font:@manuscript-font;',
			'@font-heading:@manuscript-font-heading;',
		);

		// Update colour based on theme option from parent theme
		if (($baseColour = $this->getOption('baseColour')) !== '#1E6292') {
			if (!preg_match('/^#[0-9a-fA-F]{1,6}$/', $baseColour)) $baseColour = '#1E6292'; // pkp/pkp-lib#11974
			$additionalLessVariables[] = '@bg-base:' . $baseColour . ';';
			if (!$this->isColourDark($baseColour)) {
				$additionalLessVariables[] = '@text-bg-base:rgba(0,0,0,0.84);';
			}
		}

		// Update accent colour based on theme option
		if (($accentColour = $this->getOption('accentColour')) !== '#F7BC4A') {
			if (!preg_match('/^#[0-9a-fA-F]{1,6}$/', $accentColour)) $accentColour = '#F7BC4A'; // pkp/pkp-lib#11974
			$additionalLessVariables[] = '@accent:' . $accentColour . ';';
		}

		if ($baseColour && $accentColour) {
			$this->modifyStyle('stylesheet', array('addLessVariables' => join('', $additionalLessVariables)));
		}
	}

	/** @see ThemePlugin::saveOption */
	public function saveOption($name, $value, $contextId = null) {
		// Validate the base colour setting value.
		if ($name == 'baseColour' && !preg_match('/^#[0-9a-fA-F]{1,6}$/', $value)) $value = null; // pkp/pkp-lib#11974
		if ($name == 'accentColour' && !preg_match('/^#[0-9a-fA-F]{1,6}$/', $value)) $value = null; // pkp/pkp-lib#11974

		parent::saveOption($name, $value, $contextId);
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.themes.defaultManuscript.name');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.themes.defaultManuscript.description');
	}
}
