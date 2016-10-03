<?php

/**
 * @file plugins/themes/default/DefaultManuscriptChildThemePlugin.inc.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
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

		// Load the Montserrat and Open Sans fonts
		$this->addStyle(
			'font',
			'//fonts.googleapis.com/css?family=Montserrat:400,700|Noto+Serif:400,400i,700,700i',
			array('baseUrl' => '')
		);

		// Due to a quirk in the order that the LESS variables and stylesheets
		// are loaded, any variables passed with the `addLessVariables` param
		// are processed last. Since the default theme uses this param to load
		// fonts based on theme options, we have to use this param to override
		// those settings.
		//
		// In an ideal world, this wouldn't be necessary and we could include
		// these variable declarations within variables.less. But until a
		// solution is worked out for child themes to better interact with
		// parent theme options, this workaround is required.
		$additionalLessVariables = '@font:  "Noto Serif", -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;';
		$additionalLessVariables .= '@font-heading:  "Montserrat", -apple-system, BlinkMacSystemFont, "Segoe UI", "Roboto", "Oxygen-Sans", "Ubuntu", "Cantarell", "Helvetica Neue", sans-serif;';
		$this->modifyStyle('stylesheet', array('addLessVariables' => $additionalLessVariables));
	}

	/**
	 * Get the display name of this plugin
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.themes.default-manuscript.name');
	}

	/**
	 * Get the description of this plugin
	 * @return string
	 */
	function getDescription() {
		return __('plugins.themes.default-manuscript.description');
	}
}

?>
