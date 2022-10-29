<?php
/**
 * Vite Manifest plugin for Craft CMS 4.x
 *
 * Twig utility function to handle Vite manifest asset files for Craft CMS.
 *
 * @link       https://github.com/bryaneschultz/vite-manifest-plugin
 * @copyright  Copyright (c) 2022 Bryan E. Schultz
 */

/**
 * Vite Manifest config.php
 *
 * This file exists only as a template for the Craft Mix settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'vite-manifest.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 *
 * @author   Bryan E. Schultz
 * @package  vite-manifest-plugin
 * @since    1.0.0
 */

return [
    'webRootAlias' => '@webroot',
    'manifestFile' => 'manifest.json',
    'viteDist' => 'dist',
];
