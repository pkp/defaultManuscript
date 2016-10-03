<?php

/**
 * @defgroup plugins_themes_default_manuscript Default theme plugin
 */

/**
 * @file plugins/themes/default-manuscript/index.php
 *
 * Copyright (c) 2014-2016 Simon Fraser University Library
 * Copyright (c) 2003-2016 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_themes_default-manuscript
 * @brief Wrapper for default manuscript theme plugin.
 *
 */

require_once('DefaultManuscriptChildThemePlugin.inc.php');

return new DefaultManuscriptChildThemePlugin();

?>
