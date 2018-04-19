<?php

/**
 * @file plugins/themes/default/DefaultManuscriptChildThemePlugin.inc.php
 *
 * Copyright (c) 2014-2018 Simon Fraser University Library
 * Copyright (c) 2003-2018 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class DefaultManuscriptChildThemePlugin
 * @ingroup plugins_themes_default_manuscript
 *
 * @brief Default theme
 */
import('lib.pkp.classes.plugins.ThemePlugin');

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
		// `removeOption` was introduced in OJS 3.0.2
		if (method_exists($this, 'removeOption')) {
			$this->removeOption('typography');
		}

		// Add the option for an accent color
		$this->addOption('accentColour', 'colour', array(
			'label' => 'plugins.themes.defaultManuscript.option.accentColour.label',
			'description' => 'plugins.themes.default.option.colour.description',
			'default' => '#F7BC4A',
		));

		// Load the Montserrat and Open Sans fonts
		$this->addStyle(
			'font',
			'//fonts.googleapis.com/css?family=Montserrat:400,700|Noto+Serif:400,400i,700,700i',
			array('baseUrl' => '')
		);

		// Dequeue any fonts loaded by parent theme
		// `removeStyle` was introduced in OJS 3.0.2
		if (method_exists($this, 'removeStyle')) {
			$this->removeStyle('fontNotoSans');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSansNotoSerif');
			$this->removeStyle('fontLato');
			$this->removeStyle('fontLora');
			$this->removeStyle('fontLoraOpenSans');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
			$this->removeStyle('fontNotoSerif');
		}

		// Start with a fresh array of additionalLessVariables so that we can
		// ignore those added by the parent theme. This gets rid of @font
		// variable overrides from the typography option
		$additionalLessVariables = array();

		// Update colour based on theme option from parent theme
		if ($this->getOption('baseColour') !== '#1E6292') {
			$additionalLessVariables[] = '@bg-base:' . $this->getOption('baseColour') . ';';
			if (!$this->isColourDark($this->getOption('baseColour'))) {
				$additionalLessVariables[] = '@text-bg-base:rgba(0,0,0,0.84);';
			}
		}

		// Update accent colour based on theme option
		if ($this->getOption('accentColour') !== '#F7BC4A') {
			$additionalLessVariables[] = '@accent:' . $this->getOption('accentColour') . ';';
		}

		if ($this->getOption('baseColour') && $this->getOption('accentColour')) {
			$this->modifyStyle('stylesheet', array('addLessVariables' => join('', $additionalLessVariables)));
		}
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

?>
